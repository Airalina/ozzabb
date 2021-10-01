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
 
    public $date, $provider_price_unit, $provider_price_price, $provider_id, $i = 0, $x = 0, $total = [], $mats = [], $material = [], $materials = [], $present = [], $orders, $ottPlatform = '', $search, $clientOrders = [], $clientorders = [], $order = [], $order_detail = [], $installations, $installation, $installation_code = [[]], $revision_detail = [], $detail = [], $total_amount = [], $buys = [], $deposit_material = [], $total_material = [], $div = false, $select = false, $presentation = [], $stock, $suma = [], $block = true, $selection = false, $providers = [], $provider, $in_transit = [], $transit = [], $transits, $requirements = [], $requirement = [], $req = [], $amount, $provider_price = [], $provider_presentation = [], $comprar = [], $cant, $iva, $subtotal, $total_price, $select_present;
    protected $listeners = ['clientOrdersSelected'];
    private $select_presentation = [], $select_provider = [];

    public function render()
    {    
        $this->orders = Clientorder::where('id','LIKE','%'.$this->search.'%')
        ->orWhere('customer_name','LIKE','%'.$this->search.'%')
        ->get();

        return view('livewire.purchasing-sheet');
    }
    public function clientOrdersSelected($clientOrdersValues){ 
        $this->clientOrders = $clientOrdersValues;
    }

    public function order_change(){
        $this->div=true;
        $this->select=true;
        
        #dd($this->clientOrders);
        foreach ($this->clientOrders as $key => $order) {
            $this->clientorders[$key] = Clientorder::find((int)$order);
            $this->order_detail[$key] = Orderdetail::where('clientorder_id', $this->clientorders[$key]->id)->get();      
         #W   dd($this->order_detail[$key]);
            $this->total_amount[$key] = $this->order_detail[$key]->sum('cantidad');
            $this->buys[$key] = PucharsingSheetOrder::where('clientorder_id', $this->clientorders[$key]->id)->first();
            
            foreach($this->order_detail[$key] as $indice => $detail){ 
                    $this->installations[(int)$this->x] = Installation::where('code',$detail->material_id)->first(); 
                    $this->x++;
                }
           
        }
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
        if(!empty($this->provider)){
          
            $this->select_present = true;
            $this->select_provider = json_decode($this->provider);
            $this->present[$this->select_provider->material_id]= ProviderPrice::where('material_id', $this->select_provider->material_id)->where('provider_id', $this->select_provider->provider_id)->get();

                if(!empty($this->presentation)){
                    $this->cant = true;
                    $this->select_presentation = json_decode($this->presentation);
                   // $this->stock[$this->select_presentation->material_id] = $this->select_presentation->stock;
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
                if(!empty($this->amount)){
                    foreach($this->amount as $i => $amnt){
                    $this->total[$i] = $amnt;
                    }
                    foreach ($this->total as $t => $cant) {
                        if(isset($this->provider_price_price[$t])){
                      $this->comprar[$this->select_provider->material_id] = ($this->provider_price_price[$t]*$cant)/$this->provider_price_unit[$t];
                        } 
                    }
                    $this->subtotal = array_sum($this->comprar);
                    if(!empty($this->iva)){
                        $this->total_price = $this->subtotal * (1 + ($this->iva /100));
                    }
                  
                }             
            }
            
           
                           
    }
     public function save(){
     #  dd($this->clientorders);
       $this->pucharsing_sheet = PucharsingSheet::create([
            'date' => $this->date,
        ]);

        foreach ($this->material as $key => $mat) {
            PucharsingSheetDetail::create([
                'pucharsing_sheet_id' => $this->pucharsing_sheet->id,
                'material_id' => $mat,
                'amount' => $this->total[$mat],
                'presentation' => $this->provider_price_unit[$mat],
                'provider_id' => $this->provider_id[$mat],
            ]);
        }
        foreach ($this->clientorders as $order) {
           
            PucharsingSheetOrder::create([
                'pucharsing_sheet_id' => $this->pucharsing_sheet->id,
                'clientorder_id' => $order["id"],
            ]);
        }
       
         
     }                        
}

   
  
