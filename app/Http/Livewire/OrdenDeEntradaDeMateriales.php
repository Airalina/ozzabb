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
use App\Models\Provider;
use Livewire\WithPagination;
use Carbon\Carbon;

class OrdenDeEntradaDeMateriales extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $orders, $buyorders;
    public  $order= 'date',$material_entry, $x=0,$date, $ingresa=false, $hour,$paginas=25,$paginas1=25, $buyorderdetails, $orden, $funcion="", $searchorderbuy="", $count=0, $depositm, $detailem, $warehouse_id, $nombre_deposito, $depositos, $materiales, $detail=array(), $details=array(),$searchordenesem="", $amount, $description, $presentation, $origen, $causa, $material_id, $code, $modo, $create_date, $create_hour, $searchmateriales, $select=false, $material_order, $close_order = false, $code_m, $description_m, $presentation_m, $id_m, $deposit_m;
    public $orderdetails,$entry_orderbuy, $smaterial, $entry_order_id, $entry_order_type , $buy_order_id, $follow, $amount_requested, $amount_follow, $difference, $set, $amount_undelivered, $campos_modo, $buyorderinfo, $refer_amount, $received_amount, $requested_amount, $requested_presentation , $id_warehouse, $buyorder_id, $entry_order_detail, $sin_entrega, $sin_entrega_detail, $sum, $buy_order_state, $cant, $present, $select_depo = array(), $provider, $materials = array(), $deposito_id, $order_selected;

    public function updatingSearch()
    {
        $this->resetPage();
    }
   
    
    public function render()
    {
        $fecha = date('Y-m-d', strtotime($this->searchordenesem));
        $type = ($this->order == 'date') ? 'desc' : 'asc';

         $this->orders=MaterialEntryOrder::where('id','LIKE','%' . $this->searchordenesem . '%')
            ->orWhere('buy_order_id','LIKE','%'.$this->searchordenesem.'%')
            ->orWhere('follow_number','LIKE','%'.$this->searchordenesem.'%')
            ->orWhere('origin','LIKE','%'.$this->searchordenesem.'%')
            ->orWhere('reason','LIKE','%'.$this->searchordenesem.'%')
            ->orWhere('date','LIKE','%'.$fecha.'%')
            ->orWhere('provider','LIKE','%'.$this->searchordenesem.'%')
            ->orWhereDay('date','LIKE','%'.$this->searchordenesem.'%')
            ->orWhereMonth('date','LIKE','%'.$this->searchordenesem.'%')
            ->orWhereYear('date','LIKE','%'.$this->searchordenesem.'%')
            ->orWhere('hour','LIKE','%'.$this->searchordenesem.'%')->orderBy($this->order, $type)->paginate($this->paginas);




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
            ->orWhere('pucharsing_sheet_id','LIKE','%',$this->searchorderbuy.'%')
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
                'details' => 'required',
            ],
            [
                'date.required' => 'El campo Fecha es requerido',
                'hour.required' => 'El campo Hora es requerido',
                'name.max' => 'El campo Nombre tiene como maximo 100 caracteres',
                'origen.string' => 'El campo Origen es requerido',
                'origen.min' => 'El campo Origen tiene como minimo 4 caracteres',
                'origen.max' => 'El campo Origen tiene como maximo 300 caracteres',
                'causa.string' => 'El campo Causa es requerido',
                'causa.min' => 'El campo Causa tiene como minimo 4 caracteres',
                'causa.max' => 'El campo Causa tiene como maximo 300 caracteres',
                'details.required' => 'Debe seleccionar al menos un material',
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
                $this->smaterial=Material::where('code', $this->detailem->material_code )->first();
                $this->smaterial->stock+=$this->detailem->amount_received*$this->detailem->presentation;
                $this->smaterial->save();
            }      
        }elseif($this->modo=="Con orden de compra"){
          
            $count = (!empty($this->buyorderinfo)) ? count($this->buyorderinfo) : 0;
            $this->validate([
                'date' => 'required',
                'hour' => 'required',
                'follow' => 'required|max:100|min:1',
                'buyorder_id' => 'required',
                'received_amount' => 'required|min:'.$count,
                'refer_amount' => 'required|min:'.$count,
            ],
            [
                'date.required' => 'El campo Fecha es requerido',
                'hour.required' => 'El campo Hora es requerido',
                'follow.required' => 'El campo N° de remito es obligatorio ("S/N", en caso de no tener.)',
                'follow.max' => 'El campo N° de remito tiene como máximo 100 caracteres',
                'follow.max' => 'El campo N° de remito tiene como mínimo 1 caracter',
                'buyorder_id.required' => 'Debe seleccionar una orden de compra',
                'received_amount.min' => 'Un campo Cantidad Enviada está vacio',
                'refer_amount.min' => 'El campo Cantidad Remito está vacio',
                'select_depo.min' => 'El campo Deposito está vacio',
                'received_amount.required' => 'El campo Cantidad Enviada es requerido',
                'refer_amount.required' => 'El campo Cantidad Remito es requerido',
            ]);       
                $this->orden=new MaterialEntryOrder;
                $this->orden->date=$this->date;
                $this->orden->hour=$this->hour;
                $this->orden->buy_order_id=$this->buyorder_id;
                $this->orden->provider=$this->provider;
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
                    if($this->material_entry){             
                        foreach ($this->material_entry as $code => $entry_detail) {
                            $this->sum[$code] = array_sum(array_column($entry_detail, 'amount_received')); 
                            $this->buy_order_state=BuyOrder::find($this->buyorder_id);
                                foreach ($entry_detail as  $entry_detail_amount) {
                                        if($this->sum[$code] < $entry_detail_amount->amount_requested){
                                            $this->buy_order_state->state=0;                   
                                        }else{
                                            $this->buy_order_state->state=2;                   
                                        }
                                    }
                                $this->buy_order_state->save();
                        }
                    }
                }

                foreach($this->details as $detail){
                    if(isset($this->material_entry[$detail[0]])){
                        if(count($this->material_entry[$detail[0]]) > 0){
                            $detail[10]=abs($detail[2])-abs(end($this->material_entry[$detail[0]])->difference);
                            $detail[2]+=end($this->material_entry[$detail[0]])->amount_received;
                                if($detail[10] == 0){
                                    $this->buy_order_state->state=2;                       
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
                    $this->smaterial=Material::where('code', $this->detailem->material_code )->first();
                    $this->smaterial->stock_transit-=$this->detailem->amount_requested*$this->detailem->presentation;
                    $this->smaterial->stock+=$this->detailem->amount_received*$this->detailem->presentation;
                    $this->smaterial->save();
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
                'deposito_id' => 'required'
            ],[
                'cant.required' => 'El campo "Cantidad" es requerido',
                'cant.integer' => 'El campo "Cantidad" debe ser un entero',
                'cant.min' => 'El campo "Cantidad" debe ser como mínimo 1(Uno)',
                'cant.max' => 'El campo "Cantidad" debe ser como máximo 1000000(Un millón)',
                'present.required' => 'El campo "Presentación" es requerido',
                'present.integer' => 'El campo "Presentación" debe ser un entero',
                'present.min' => 'El campo "Presentación" debe ser como mínimo 1(Uno)',
                'present.max' => 'El campo "Presentación" debe ser como máximo 1000000(Un millón)',
                'deposito_id.required' => 'Seleccione una opción del campo "Deposito"'
    
            ]);
            
            $warehouse=Warehouse::where('id',$this->deposito_id)->first();
          
            foreach($this->details as $detail){
                if($detail[0]==$this->code_m){
                    $this->downmaterial($detail[3],$detail[1],$detail[2]);
                }        
            } 
            
            $this->detail[0]=$material->code;
            $this->detail[1]=$material->description;
            $this->detail[4]=$material->id;
            $this->detail[2]=$this->cant;
            /*$material->stock += $this->cant;
            
            if(isset($material->stock)){
                $material->save();
            }*/
            $this->detail[3]=$this->count;
            $this->detail[5]=$this->present;
            $this->detail[6]=$warehouse->id;
            $this->cant=0;
            $this->present=0;
            $this->deposito_id='';
            $this->dispatchBrowserEvent('hide-form');

        }else{
            $this->validate([
                'received_amount' => 'required|integer|min:0|max:1000000',
                'refer_amount' => 'required|integer|min:0|max:1000000',
                'deposito_id' => 'required'
            ],[
                'received_amount.required' => 'El campo "Cantidad enviada" es requerido',
                'received_amount.integer' => 'El campo "Cantidad enviada" debe ser un entero',
                'received_amount.min' => 'El campo "Cantidad enviada" debe ser como mínimo 0(cero)',
                'received_amount.max' => 'El campo "Cantidad enviada" debe ser como máximo 1000000(Un millón)',
                'refer_amount.required' => 'El campo "Cantidad remito" es requerido',
                'refer_amount.integer' => 'El campo "Cantidad remito" debe ser un entero',
                'refer_amount.min' => 'El campo "Cantidad remito" debe ser como mínimo 0(cero)',
                'refer_amount.max' => 'El campo "Cantidad remito" debe ser como máximo 1000000(Un millón)',
                'deposito_id.required' => 'Seleccione una opción del campo "Deposito"'
    
            ]);

            $this->difference = $this->received_amount-$this->requested_amount;

            $warehouse=Warehouse::where('id',$this->deposito_id)->first();
            $this->detail[0]=$material->code;
            $this->detail[1]=$material->description;
            $this->detail[4]=$material->id;
            $this->detail[2]=$this->received_amount;
            $this->detail[3]=$material->count;
            $this->detail[5]=$this->requested_presentation;
            $this->detail[6]=$warehouse->id;
            $this->detail[7]=$this->requested_amount;
            $this->detail[8]=$this->refer_amount;
       #     dd($this->close_order);
            if($this->close_order){
                $this->detail[9]=abs($this->difference);
            }else{
                $this->detail[9]=0;
            }
            $this->detail[10]=$this->difference;
            $this->detail[11]=$material->set;

            $this->materials[$material->id]['received_amount']=$this->received_amount;
            $this->materials[$material->id]['refer_amount']=$this->refer_amount;
            $this->materials[$material->id]['difference']=$this->difference;
            $this->materials[$material->id]['warehouse']=$warehouse->name;
/*
            $material->stock += $this->received_amount[$material->id];
            
            if(isset($material->stock)){
                $material->save();
            }*/
            $this->received_amount=0;
            $this->requested_presentation=0;
            $this->requested_amount=0;
            $this->refer_amount=0;
            $this->difference=0;
            $this->dispatchBrowserEvent('hide-form');
        }  
       # dd($material);
        $this->details[$material->id]=$this->detail;
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
        $this->materials = array();
        //Faltan agregar las ordenes de compra y guardar 
        $this->searchorderbuy=""; 
        $this->buyorder_id=$order->id;
        $this->provider=$order->provider->name;
        $this->order_selected = $order;
        #$this->buyorderinfo=BuyOrderDetail::where('buy_order_id',$this->buyorder_id)->get();

                foreach($order->buyorderdetails as $detailorder){      
                            $material=$detailorder->material;
                                if (!empty($material->id)) {
                                    $material['id']=$material->id;
                                    $material['code']=$material->code;
                                    $material['description']=$material->description;
                                    $material['stock']=$material->stock;
                                    $material['stock_transit']=$material->stock_transit;
                                    $material['presentation']=$detailorder->presentation;
                                    $material['amount']=$detailorder->amount;
                                    $material['received_amount']='';
                                    $material['refer_amount']='';
                                    $material['difference']='';
                                    $material['warehouse']='';

                                    $this->materials[$material->id]=$material;
                            
                                }
                                
                        }
                    
    }  


    public function selectmaterial(Material $material){
        $this->id_m = $material->id;
        $this->code_m=$material->code;
        $this->description_m=$material->description;
        $this->requested_presentation = (isset($this->materials[$material->id]['presentation'])) ? $this->materials[$material->id]['presentation'] : '';
        $this->requested_amount = (isset($this->materials[$material->id]['amount'])) ? $this->materials[$material->id]['amount'] : '';

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

    public function ingresar(Material $material){
        $this->material_id=$material->id;
        $this->code_m=$this->material->code;
        $this->description_m=$this->material->description;
        
        $this->dispatchBrowserEvent('show-form-mat');
    }
}
