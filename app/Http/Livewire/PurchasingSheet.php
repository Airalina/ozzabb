<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Clientorder;
use App\Models\Orderdetail;
use App\Models\Installation;
use App\Models\Revisiondetail;
use App\Models\Material;
use App\Models\DepositMaterial;
use App\Models\ProviderPrice;
use App\Models\PucharsingSheet;
use App\Models\PucharsingSheetDetail;
use App\Models\PucharsingSheetOrder;

class PurchasingSheet extends Component
{
 
    public $funcion="", $ord, $searchMounth='', $explora, $pedidos = false, $detail = array(), $count=0,$date, $provider_price_unit, $provider_price_price, $provider_id, $i = 0, $x = 0, $orderC, $total = [], $mats = [], $material = [], $materials = [], $present = [], $orders, $ottPlatform = '', $search = '', $clientOrders, $clientorders = [], $order = [], $order_detail = [], $installations, $installation, $installation_code = [[]], $revision_detail = [], $total_amount = [], $buys = [], $deposit_material = [], $total_material = [], $div = false, $select = false, $presentation = [], $stock, $suma = [], $block = true, $selection = false, $providers = [], $provider, $in_transit = [], $transit = [], $transits, $requirements = [], $requirement = [], $req = [], $amount, $provider_price = [], $provider_presentation = [], $comprar = [], $iva, $subtotal, $total_price, $select_present, $m_comprar = [], $purchasing_sheets, $searchP, $searchmateriales, $months, $cantidad, $msg, $msg_error, $selection_provider = true, $provider_selected;
  #  protected $listeners = ['clientOrdersSelected'];
    private $select_presentation = [], $select_provider = [];

    public function render()
    {    $this->months = [1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril', 5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto', 9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre' ]; 
      // dd($this->months);
        foreach ($this->months as $number_month => $month) {
           if($this->search == $month){
            $this->searchMounth =  $number_month;
           } 
        }
        
        $this->orders = Clientorder::where('id','LIKE','%'.$this->search.'%')
        ->orWhere('customer_name','LIKE','%'.$this->search.'%')
        ->orWhereMonth('date', $this->searchMounth)
        ->orWhereDay('date',  $this->search)
        ->get();

        $this->purchasing_sheets = PucharsingSheet::where('id','LIKE','%'.$this->searchP.'%')
        ->orWhere('date','LIKE','%'.$this->searchP.'%')
        ->get();
        return view('livewire.purchasing-sheet');
    }
    public function addorder(Clientorder $order){
     //   dd($orderC);
      //  $this->select=true;
    
      $this->clientOrders[$this->count] = $order->id; 
      $this->count++;

      $this->div=true;
      $this->select=true;
      $this->order_change();
       
    }
    public function order_change(){
     
      #  dd($this->clientOrders);
      if(!empty($this->clientOrders)){
        foreach ($this->clientOrders as $key => $order) {
            $this->clientorders[$key] = Clientorder::find($order);
            $this->order_detail[$key] = Orderdetail::where('clientorder_id', $this->clientorders[$key]->id)->get();      
         #W   dd($this->order_detail[$key]);
            $this->total_amount[$key] = $this->order_detail[$key]->sum('cantidad');
            $this->buys[$key] = PucharsingSheetOrder::where('clientorder_id', $this->clientorders[$key]->id)->first();
            
            foreach($this->order_detail[$key] as $indice => $detail){ 
                    $this->installations[(int)$this->x] = Installation::where('code',$detail->material_id)->first(); 
                    $this->x++;
                }
           
        }
        if(empty($this->installations)){
            $this->msg  ='El pedido no tiene instalación registrada';
        }else{
           
            unset($this->msg);
            foreach ($this->installations as $key => $inst) {
                if(isset($inst->id)){
                    $this->installation[$inst->code] = $inst;
                    $this->revision_detail[(int)$this->i] = Revisiondetail::where('installation_id', $inst->id)->get();
                    $this->i++; 
                        }
            }
        
            foreach ($this->revision_detail as $k => $revisions) {
                foreach ($revisions as $i => $revision) {
                    if(isset($revision->material_id)){
                    $this->materials[$revision->material_id] = $revision;
                    $this->material[$revision->material_id] = $revision->material_id;
                    }
                }
            }
            if(!empty($this->date)){
                $this->pedidos = true;
            }
            foreach ($this->material as $key => $value) {
            $this->deposit_material[$key] = DepositMaterial::where('material_id', $value)->groupBy('presentation')->selectRaw('material_id, presentation, sum(amount) as sum')->get();
            $this->in_transit[$key] = PucharsingSheetDetail::where('material_id', $value)->groupBy('material_id', 'presentation')->selectRaw('material_id, presentation, sum(amount) as sum')->get();
            $this->providers[$key] = ProviderPrice::where('material_id', $value)->get();
                    
            foreach ($this->installation as $inst) {
                    if(isset($inst->id)){
                    $this->requirements[$inst->id] = Revisiondetail::where('installation_id', $inst->id)->groupBy('material_id')->selectRaw('material_id, installation_id, sum(amount) as sum')->get();   
                        foreach ($this->requirements[$inst->id] as $ki => $requi) {
                            if($requi->material_id == $key){
                                $this->requirement[$key][$inst->id] = $requi;
                            }
                        
                        }
                    }
                }       
            }
            foreach ($this->requirement as $mat => $material) {
                            $this->req[$mat] = array_sum(array_column($material, 'sum')); 
                    }
        }
        if(!empty($this->provider)){
        //  dd($this->provider);
            $this->select_present = true;
            $this->selection_provider = false;
            $this->select_provider = json_decode($this->provider);
           //  dd($this->select_provider);
            $this->present[$this->select_provider->material_id]= ProviderPrice::where('material_id', $this->select_provider->material_id)->where('provider_id', $this->select_provider->provider_id)->get();
//dd($this->present);
          
                if(!empty($this->presentation)){
                   
                    $this->cantidad[$this->select_provider->material_id] = true;
                 
                    $this->select_presentation = json_decode($this->presentation);
                    $this->transits = $this->in_transit[$this->select_presentation->material_id];
             
                    foreach ($this->transits as $k => $value) {
                   
                        if($value->presentation == $this->select_presentation->unit){
                            $this->transit[$this->select_presentation->material_id]= $value->sum;
                        }
                    }
                
                }
            $this->provider_price = $this->providers[$this->select_provider->material_id];
         
            foreach ($this->provider_price as $index => $price) {
               
                if(!empty($this->select_presentation)){
                    if (($this->select_provider->provider_id == $price->provider_id) && ($this->select_presentation->unit == $price->unit)){
                      //  dd($price);
                        $this->provider_price_price[$this->select_provider->material_id]=$price->usd_price;
                        $this->provider_price_unit[$this->select_provider->material_id]=$price->unit;
                        $this->provider_id[$this->select_provider->material_id]=$price->provider_id;
                    }
                   
                }
            
                }
                if(!empty($this->amount[$this->select_provider->material_id])){
                    if(is_numeric($this->amount[$this->select_provider->material_id])){
                        $this->m_comprar[$this->select_provider->material_id] = true;
                        //   $this->cantidad = true;
                        //   dd($this->m_comprar);
                           foreach($this->amount as $i => $amnt){
                           $this->total[$i] = $amnt;
                           }
                         //  dd($this->total);
                           foreach ($this->total as $t => $cant) {
                               
                               if(isset($this->provider_price_price[$t])){
                             $this->comprar[$this->select_provider->material_id] = ($this->provider_price_price[$t]*$cant)/$this->provider_price_unit[$t];
                               } 
                           }
                         #  dd($this->comprar);
                           $this->subtotal = array_sum($this->comprar);
                           if(!empty($this->iva)){
                               $this->total_price = $this->subtotal * (1 + ($this->iva /100));
                           }
                    }else{
                        $this->msg = "La cantidad debe ser un número";
                    }
                    
                  
                }           
            }              
      }
             
    }
    public function funcion()
    {
        $this->funcion="crear";
        $this->date=null;
        $this->search='';
        $this->pedidos = false;
        $this->div=false;
        $this->select=false;
        $this->total_price = null;
        $this->subtotal = null;
        $this->iva = null;

    }

     public function save(){
  //     dd($this->total);

        
        $this->validate([
            'date' => 'required|date',
        ], [ 
            'date.required' => 'El campo fecha es requerido',
            'date.date' => 'El campo fecha debe ser una fecha válida',
        ]);
        $this->pucharsing_sheet = PucharsingSheet::create([
            'date' => $this->date,
        ]);
      
     
        foreach ($this->material as $key => $mat) {
               
            //dd($this->total);
            if(isset($this->provider_price_unit[$mat]) && isset($this->provider_id[$mat])){
                unset($this->msg_error[$mat]);
                if(empty($this->total[$mat])){
                    $this->total[$mat] = 0;
                }       
                PucharsingSheetDetail::create([
                    'pucharsing_sheet_id' => $this->pucharsing_sheet->id,
                    'material_id' => $mat,
                    'amount' => $this->total[$mat],
                    'presentation' => $this->provider_price_unit[$mat],
                    'provider_id' => $this->provider_id[$mat],
                ]);
                foreach ($this->clientorders as $order) {
                    PucharsingSheetOrder::create([
                        'pucharsing_sheet_id' => $this->pucharsing_sheet->id,
                        'clientorder_id' => $order["id"],
                    ]);
                }
                return redirect()->to('/planilla-de-compras');

            }else{
                $this->msg_error[$mat] = 'Escoge un proveedor y presentación para el material nro: '. $mat;
                $this->order_change();
            }
            
        }
     //dd( $this->msg_error);
     }                        
}

   
  
