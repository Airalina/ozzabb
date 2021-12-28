<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\MaterialEntryOrder;
use App\Models\MaterialEntryOrderDetail;
use App\Models\Warehouse;
use App\Models\Material;
use App\Models\DepositMaterial;
use App\Models\BuyOrder;
use App\Models\BuyOrderDetail;
use App\Models\BuyOrderMaterialEntryOrder;
use Livewire\WithPagination;
use Carbon\Carbon;

class OrdenDeEntradaDeMateriales extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $orders, $buyorders;
    public  $material_entry, $x=0,$date, $ingresa=false, $hour,$paginas=25,$paginas1=25, $buyorderdetails, $orden, $funcion="", $searchorderbuy="", $count=0, $depositm, $detailem, $warehouse_id, $nombre_deposito, $depositos, $materiales, $detail=array(), $details=array(),$searchordenesem="", $amount, $description, $presentation, $origen, $causa, $material_id, $code, $modo, $create_date, $create_hour, $searchmateriales, $select=false, $material_order, $close_order = false, $code_m, $description_m, $presentation_m, $id_m, $deposit_m;
    public $orderdetails,$entry_orderbuy, $entry_order_id, $entry_order_type , $buy_order_id, $follow, $amount_requested, $amount_follow, $difference, $set, $amount_undelivered, $campos_modo, $buyorderinfo, $refer_amount, $received_amount, $requested_amount, $requested_presentation , $id_warehouse, $buyorder_id, $entry_order_detail, $sin_entrega, $sin_entrega_detail, $sum, $buy_order_state, $cant, $present;
  

    public function updatingSearch()
    {
        $this->resetPage();
    }
   
    
    public function render()
    {
        $this->orders=MaterialEntryOrder::where('id','LIKE','%' . $this->searchordenesem . '%')
        ->orWhere('buy_order_id','LIKE','%'.$this->searchordenesem.'%')
        ->orWhere('follow_number','LIKE','%'.$this->searchordenesem.'%')
        ->orWhere('origin','LIKE','%'.$this->searchordenesem.'%')
        ->orWhere('reason','LIKE','%'.$this->searchordenesem.'%')
        ->orWhere('date','LIKE','%'.$this->searchordenesem.'%')
        ->orWhere('hour','LIKE','%'.$this->searchordenesem.'%')->orderBy('buy_order_id','desc')->paginate($this->paginas);
       
        $this->depositos=Warehouse::where('type', 1)->get();
        $this->orderdetails=MaterialEntryOrderDetail::where('entry_order_id', $this->entry_order_id)->get();
        $this->materiales=Material::where('code','like','%'.$this->searchmateriales.'%')
            ->orWhere('name','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('family','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('color','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('description','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('stock_min','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('stock_max','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('stock','LIKE','%'.$this->searchmateriales.'%')->get();
        $this->buyorders=BuyOrder::where('id','LIKE','%' . $this->searchorderbuy . '%')
            ->orWhere('provider_id','LIKE','%',$this->searchorderbuy.'%')
            ->orWhere('order_number','LIKE','%',$this->searchorderbuy.'%')
            ->orWhere('purchasing_sheet_id','LIKE','%',$this->searchorderbuy.'%')
            ->orWhere('state','LIKE','%',$this->searchorderbuy.'%')->orderBy('state','desc')->paginate($this->paginas1);
        return view('livewire.orden-de-entrada-de-materiales',[
            'orders' => $this->orders,
            'buyorders' => $this->buyorders,
        ]);
    }
    public function modo_select(){
        $this->validate([
            'modo'=>'required'
        ], [
            'modo.required'=>'Seleccione un modo de orden de ingreso',
        ]);
        $this->campos_modo = $this->modo;
    }
    public function store()
    {
        $this->validate([
            'modo'=>'required'
        ], [
            'modo.required'=>'Seleccione un modo de orden de ingreso',
        ]);

        if($this->modo=="Sin orden de compra"){
            $this->validate([
                'date' => 'required',
                'hour' => 'required',
                'origen' => 'string|min:4|max:300',
                'causa' => 'string|min:4|max:300',
            ],
            [
                'date.required' => 'El campo Fecha es requerido',
                'hour.required' => 'El campo Hora es requerido',
                'name.max' => 'El campo Nombre tiene como maximo 100 caracteres',
                'origen.string' => 'El campo Origen es requerido',
                'origen.min' => 'El campo Origen tiene como minimo 4 caracteres',
                'origen.max' => 'El campo Origen tiene como maximo 300 caracteres',
                'causa.string' => 'El campo Origen es requerido',
                'causa.min' => 'El campo Origen tiene como minimo 4 caracteres',
                'causa.max' => 'El campo Origen tiene como maximo 300 caracteres',
            ]);
            $this->orden=new MaterialEntryOrder;
            $this->orden->date=$this->date;
            $this->orden->hour=$this->hour;
            $this->orden->origin=$this->origen;
            $this->orden->reason=$this->causa;
            $this->orden->save();
            foreach($this->details as $detail){
                $this->ingreso=DepositMaterial::where('material_id',$detail[4])->where('is_material',true)->where('presentation',$detail[5])->where('warehouse_id',$detail[6])->get();
                if($this->ingreso->count()==0){
                    $this->depositm=new DepositMaterial;
                    $this->depositm->material_id=$detail[4];
                    $this->depositm->warehouse_id=$detail[6];
                    $this->depositm->presentation=$detail[5];
                    $this->depositm->amount=$detail[2];
                    $this->depositm->date_change=$this->date;
                    $this->depositm->is_material=1;
                    $this->depositm->save();
                }else{
                    foreach($this->ingreso as $ing){
                        $ing->amount=($ing->amount+$detail[2]);
                        $ing->date_change=$this->date;
                        $ing->save();
                        $this->modo="";
                        $this->funcion="";
                    }
                }
                $this->detailem=new MaterialEntryOrderDetail;
                $this->detailem->entry_order_id=$this->orden->id;
                $this->detailem->material_code=$detail[0];
                $this->detailem->material_description=$detail[1];
                $this->detailem->warehouse_id=$detail[6];
                $this->detailem->presentation=$detail[5];
                $this->detailem->amount_received=$detail[2];
                $this->detailem->save();
            }      
        }elseif($this->modo=="Con orden de compra"){
            $this->validate([
                'date' => 'required',
                'hour' => 'required',
            ],
            [
                'date.required' => 'El campo Fecha es requerido',
                'hour.required' => 'El campo Hora es requerido',
                'name.max' => 'El campo Nombre tiene como maximo 100 caracteres',
            ]);       
                $this->orden=new MaterialEntryOrder;
                $this->orden->date=$this->date;
                $this->orden->hour=$this->hour;
                $this->orden->buy_order_id=$this->buyorder_id;
                $this->orden->follow_number=$this->follow;
                $this->orden->save();
                $this->entry_orderbuy=new BuyOrderMaterialEntryOrder;
                $this->entry_orderbuy->buy_order_id=$this->buyorder_id;
                $this->entry_orderbuy->entry_order_id=$this->orden->id;
                $this->entry_orderbuy->save();
                $this->sin_entrega = MaterialEntryOrder::where('buy_order_id', $this->buyorder_id)->get();             
                if (count($this->sin_entrega)>1) {
                    foreach ($this->sin_entrega as $key => $value) {
                        $this->sin_entrega_detail[$value->id] = MaterialEntryOrderDetail::where('entry_order_id',  $value->id)->get();
                       
                        foreach ($this->sin_entrega_detail[$value->id] as $index => $material_entry_order_detail) {
        
                            $this->material_entry[$material_entry_order_detail->material_code][$this->x]=$material_entry_order_detail;
                            $this->x++;
                        }                   
                    }             
                    foreach ($this->material_entry as $code => $entry_detail) {
                            $this->sum[$code] = array_sum(array_column($entry_detail, 'amount_received')); 
                            $this->buy_order_state=BuyOrder::find($this->buyorder_id);
                           
                                foreach ($entry_detail as  $entry_detail_amount) {
                                    if($this->sum[$code] < $entry_detail_amount->amount_requested){
                                        $this->buy_order_state->state=0;                   
                                    }else{
                                        $this->buy_order_state->state=1;                   
                                    }
                                }
                            $this->buy_order_state->save();
                        }
                }
                foreach($this->details as $detail){
                    if(isset($this->material_entry[$detail[0]])){
                        if(count($this->material_entry[$detail[0]]) > 0){
                            $detail[10]=abs($this->received_amount[$detail[4]])-abs(end($this->material_entry[$detail[0]])->difference);
                            $detail[2]+=end($this->material_entry[$detail[0]])->amount_received;
                                if($detail[10] == 0){
                                    $this->buy_order_state->state=1;                       
                                }
                                
                                 $this->buy_order_state->save();
                           }
                    }                   
                    $this->ingreso=DepositMaterial::where('material_id',$detail[4])->where('is_material',true)->where('presentation',$detail[5])->where('warehouse_id',$detail[6])->get();
                    if($this->ingreso->count()==0){
                        $this->depositm=new DepositMaterial;
                        $this->depositm->material_id=$detail[4];
                        $this->depositm->warehouse_id=$detail[6];
                        $this->depositm->presentation=$detail[5];
                        $this->depositm->amount=$detail[2];
                        $this->depositm->date_change=$this->date;
                        $this->depositm->is_material=1;
                        $this->depositm->save();
                    }else{
                        foreach($this->ingreso as $ing){
                            $ing->amount=($ing->amount+$detail[2]);
                            $ing->date_change=$this->date;
                            $ing->save();
                        }
                    }         
                    $this->detailem=new MaterialEntryOrderDetail;
                    $this->detailem->entry_order_id=$this->orden->id;
                    $this->detailem->material_code=$detail[0];
                    $this->detailem->material_description=$detail[1];
                    $this->detailem->warehouse_id=$detail[6];
                    $this->detailem->presentation=$detail[5];
                    $this->detailem->amount_received=$detail[2];
                    $this->detailem->amount_follow=$detail[8];
                    $this->detailem->amount_requested=$detail[7];
                    $this->detailem->amount_undelivered=$detail[9];
                    $this->detailem->difference=$detail[10];
                    $this->detailem->set=$detail[11];
                    $this->detailem->save();
                }
        }
        $this->modo="";
        $this->funcion="";
        $this->function="";
        $this->resetValidation();
        return redirect()->to('/ordenes-de-ingreso-de-materiales');
    }
    public function addmaterial(Material $material)
    {  
        if($this->modo=="Sin orden de compra"){
            $this->validate([
                'cant' => 'required|integer|min:1|max:1000000',
                'present' => 'required|integer|min:1|max:1000000',
                'nombre_deposito' => 'required'
            ],[
                'cant.required' => 'El campo "Cantidad" es requerido',
                'cant.integer' => 'El campo "Cantidad" debe ser un entero',
                'cant.min' => 'El campo "Cantidad" debe ser como mínimo 1(Uno)',
                'cant.max' => 'El campo "Cantidad" debe ser como máximo 1000000(Un millón)',
                'present.required' => 'El campo "Presentación" es requerido',
                'present.integer' => 'El campo "Presentación" debe ser un entero',
                'present.min' => 'El campo "Presentación" debe ser como mínimo 1(Uno)',
                'present.max' => 'El campo "Presentación" debe ser como máximo 1000000(Un millón)',
                'nombre_deposito.required' => 'Seleccione una opción del campo "Deposito"'
    
            ]);
            
            $warehouse=Warehouse::where('name',$this->nombre_deposito)->get();
            foreach($warehouse as $ware){
                $this->warehouse_id=$ware->id;
            }
          
            foreach($this->details as $detail){
                if($detail[0]==$this->code_m){
                    $this->downmaterial($detail[3],$detail[1],$detail[2]);
                }        
            } 
            
            $this->detail[0]=$material->code;
            $this->detail[1]=$material->description;
            $this->detail[4]=$material->id;
            $this->detail[2]=$this->cant;
            $material->stock += $this->cant;
            
            if(isset($material->stock)){
                $material->save();
            }
            $this->detail[3]=$this->count;
            $this->detail[5]=$this->present;
            $this->detail[6]=$this->warehouse_id;
            $this->cant=0;
            $this->present=0;
            $this->nombre_deposito='';
            $this->dispatchBrowserEvent('hide-form');

        }else{
                
            $this->id_warehouse = Warehouse::where('nombre_deposito', 1)->first();
            if(is_null($this->id_warehouse)){
                $this->id_warehouse = Warehouse::find(1);
            }
            $this->detail[0]=$material->code;
            $this->detail[1]=$material->description;
            $this->detail[4]=$material->id;
            $this->detail[2]=$this->received_amount[$material->id];
            $this->detail[3]=$material->count;
            $this->detail[5]=$this->requested_presentation[$material->id];
            $this->detail[6]=$this->id_warehouse->id;
            $this->detail[7]=$this->requested_amount[$material->id];
            $this->detail[8]=$this->refer_amount[$material->id];
       #     dd($this->close_order);
            if($this->close_order){
                $this->detail[9]=abs($this->difference[$material->id]);
            }else{
                $this->detail[9]=0;
            }
            $this->detail[10]=$this->difference[$material->id];
            $this->detail[11]=$material->set;

            $material->stock += $this->received_amount[$material->id];
            
            if(isset($material->stock)){
                $material->save();
            }
            

        }  
       # dd($material);
        $this->details[]=$this->detail;
        $this->count=$this->count+1;
        $this->amount=0;
        $this->presentation=0;
        $this->ingresa=false;
        $this->resetValidation();

    }
    public function downmaterial($orden)
    {
        unset($this->details[$orden]);
    }
    public function ingresomaterial(BuyOrderDetail $buy)
    {
        $this->ingresa=true;
        $this->code=$buy->materials->code;
        $this->description=$buy->materials->description;
        $this->material_id=$buy->materials->id;
        $this->presentation=$buy->presentation;
        $this->amount_requested=$buy->amount;
    }
    public function create()
    {   
        $this->date=Carbon::now()->format('Y-m-d');
        $this->hour=Carbon::now()->format('H:m');
        $this->funcion="create";
       
       # $this->modo="Sin orden de compra";
    }
    public function explora(MaterialEntryOrder $order)
    {  
        $this->entry_order_id= $order->id;
        $this->entry_order_type=$order->origin;
        $this->origen=$order->origin;
        $this->causa=$order->reason;
        $this->follow=$order->follow_number;
        $this->date=$order->date;
        $this->hour=$order->hour;

        $this->funcion="explora";
    }
    public function explorabuyorder(BuyOrder $order)
    {   
        $this->buy_order_id=$order->id;
        $this->buyorderdetails=BuyOrderDetail::where('buy_order_id',$order->id)->get();
        $this->modo="Con orden de compra";
        $this->funcion="create";
    }
    public function volver(){
        $this->reset();
        $this->resetValidation();
    }
    public function addorder(BuyOrder $order){
        $this->buyorder_id=$order->id;
        $this->buyorderinfo=BuyOrderDetail::where('buy_order_id',$this->buyorder_id)->get();
        
      
    }
    public function amount_change(BuyOrderDetail $orderDetail){
  
        $this->validate([
            "received_amount.$orderDetail->material_id"=>'required|numeric',
            "refer_amount.$orderDetail->material_id"=>'required|numeric'
        ]);   
        
        $this->material_order = Material::where('id',$orderDetail->material_id)->first();
        if(isset($this->received_amount[$orderDetail->material_id])){
            $this->requested_amount[$orderDetail->material_id] = $orderDetail->amount;
            $this->requested_presentation[$orderDetail->material_id] = $orderDetail->presentation;
            $this->difference[$orderDetail->material_id] = $this->received_amount[$orderDetail->material_id]-$orderDetail->amount;
        }
        if(isset($this->received_amount[$orderDetail->material_id]) && isset($this->refer_amount[$orderDetail->material_id])){
            $this->addmaterial($this->material_order);
        }
       
    }

    public function selectmaterial(Material $material){
        $this->id_m = $material->id;
        $this->code_m=$material->code;
        $this->description_m=$material->description;
        $this->dispatchBrowserEvent('show-form');
    }

    public function addmaterialup(){
       
        $this->detail[0]=$this->code_m;
        $this->detail[1]=$this->description_m;
        $this->detail[2]=$this->cant;
        $this->detail[3]=$this->count;
        $this->detail[4]=$this->present;
        $this->detail[5]=$this->nombre_deposito;
        $this->details[$this->count]=$this->detail;
        $this->total=$this->total+$this->detail[1]*$this->detail[2];
        round($this->total,2);
        $this->count=$this->count+1;
       
    }
    
    public function close(){
        $this->close_order = true;
        $this->emit('alertClose');
    }
}
