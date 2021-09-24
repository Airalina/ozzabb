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
class OrdenDeEntradaDeMateriales extends Component
{
    use WithPagination;
    protected $orders;
    public  $date,$ingresa=false, $hour, $buyorders,$buyorderdetails, $orden, $funcion="", $searchorderbuy="", $count=0, $depositm, $detailem, $warehouse_id, $nombre_deposito, $depositos, $materiales, $detail=array(), $details=array(),$searchordenesem="", $amount, $description, $presentation, $origen, $causa, $material_id, $code, $modo, $create_date, $create_hour, $searchmateriales, $select=false;
    public $orderdetails,$entry_orderbuy, $entry_order_id, $buy_order_id, $follow, $amount_requested, $amount_follow, $difference, $set, $amount_undelivered;
    public function render()
    {
        $this->buyorders=BuyOrder::where('id','LIKE','%'.$this->searchorderbuy.'%')
            ->orWhere('provider_id','LIKE','%',$this->searchorderbuy.'%')
            ->orWhere('order_number','LIKE','%',$this->searchorderbuy.'%')
            ->orWhere('purchasing_sheet_id','LIKE','%',$this->searchorderbuy.'%')
            ->orWhere('order_number','LIKE','%',$this->searchorderbuy.'%')
            ->orWhere('state','LIKE','%',$this->searchorderbuy.'%')->orderByDesc('state')->get();
        $this->orders=MaterialEntryOrder::where('id','LIKE','%' . $this->searchordenesem . '%')
        ->orWhere('buy_order_id','LIKE','%'.$this->searchordenesem.'%')
        ->orWhere('follow_number','LIKE','%'.$this->searchordenesem.'%')
        ->orWhere('date','LIKE','%'.$this->searchordenesem.'%')
        ->orWhere('hour','LIKE','%'.$this->searchordenesem.'%')->orderByDesc('buy_order_id','desc')->paginate(10);
        $this->depositos=Warehouse::all();
        $this->orderdetails=MaterialEntryOrderDetail::where('entry_order_id', $this->entry_order_id)->get();
        $this->materiales=Material::where('code','like','%'.$this->searchmateriales.'%')
            ->orWhere('name','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('family','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('color','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('description','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('line_id','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('usage_id','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('stock_min','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('stock_max','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('stock','LIKE','%'.$this->searchmateriales.'%')->get();
        return view('livewire.orden-de-entrada-de-materiales',[
            'orders' => $this->orders
        ]);
    }
    public function store()
    {
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
                'origen.required' => 'El campo Origen es requerido',
                'origen.min' => 'El campo Origen tiene como minimo 4 caracteres',
                'origen.max' => 'El campo Origen tiene como maximo 300 caracteres',
                'causa.required' => 'El campo Origen es requerido',
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
                'follow' => 'string|min:4|max:300',
            ],
            [
                'date.required' => 'El campo Fecha es requerido',
                'hour.required' => 'El campo Hora es requerido',
                'name.max' => 'El campo Nombre tiene como maximo 100 caracteres',
                'follow.required' => 'El campo Origen es requerido',
                'follow.min' => 'El campo Origen tiene como minimo 4 caracteres',
                'follow.max' => 'El campo Origen tiene como maximo 300 caracteres',
            ]);
            $this->orden=new MaterialEntryOrder;
            $this->orden->date=$this->date;
            $this->orden->hour=$this->hour;
            $this->orden->buy_order_id=$this->buy_order_id;
            $this->orden->follow_number=$this->follow;
            $this->orden->save();
            $this->entry_orderbuy=new BuyOrderMaterialEntryOrder;
            $this->entry_orderbuy->buy_order_id=$this->buy_order_id;
            $this->entry_orderbuy->entry_order_id=$this->orden->id;
            $this->entry_orderbuy->save();
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
                $this->detailem->amount_follow=$detail[8];
                $this->detailem->amount_requested=$detail[7];
                $this->detailem->amount_undelivered=$detail[9];
                $this->detailem->difference=$detail[10];
                $this->detailem->set=$detail[11];
                $this->detailem->save();
            }
        }
        $this->function="";
        $this->resetValidation();
    }
    public function addmaterial(Material $material)
    {
        $this->validate([
            'nombre_deposito'=>'required|string|min:5|max:100'
        ], [
            'nombre_deposito.required'=>'El campo Nombre de Deposito es requerido',
            'nombre_deposito' => 'El campo Nombre de Deposito tiene como mínimo 5(cinco) caracteres',
            'nombre_deposito' => 'El campo Nombre de Deposito tiene como máximo 100(cienn) caracteres',
        ]);
        $warehouse=Warehouse::where('name',$this->nombre_deposito)->get();
        foreach($warehouse as $ware){
            $this->warehouse_id=$ware->id;
        }
        $this->validate([
            'amount'=>'required|integer|min:1|max:1000000'
        ], [
            'amount.required'=>'El campo Cantidad recibida es requerido',
            'amount.integer' => 'El campo Cantidad recibida tiene que ser un número entero',
            'amount.min' => 'El campo Cantidad recibida es como mínimo 1(uno)',
            'amount.max' => 'El campo Cantidad recibida es como máximo 1000000(un millon)',
        ]);
        foreach($this->details as $detail){
            if($detail[0]==$material->code && $detail[5]==$this->presentation && $detail[6]==$this->warehouse_id){
                $this->downmaterial($detail[3]);
            }        
        }
        if($this->modo=="Sin orden de compra"){
            $this->validate([
                'presentation'=>'required|integer|min:1|max:1000000'
            ], [
                'presentation.required'=>'El campo Presentación es requerido',
                'presentation.integer' => 'El campo Presentación tiene que ser un número entero',
                'presentation.min' => 'El campo Presentación es como mínimo 1(uno)',
                'presentation.max' => 'El campo Presentación es como máximo 1000000(un millon)',
            ]);
            $this->detail[0]=$material->code;
            $this->detail[1]=$material->description;
            $this->detail[4]=$material->id;
            $this->detail[2]=$this->amount;
            $this->detail[3]=$this->count;
            $this->detail[5]=$this->presentation;
            $this->detail[6]=$this->warehouse_id;
        }else{
            $this->validate([
                'presentation'=>'required|integer|min:1|max:1000000',
                'amount_follow'=>'required|integer|min:0|max:1000000',
                'amount_undelivered'=>'required|integer|min:0|max:1000000',
                'set'=>'required|string|min:1|max:30'
            ], [
                'presentation.required'=>'El campo Presentación es requerido',
                'presentation.integer' => 'El campo Presentación tiene que ser un número entero',
                'presentation.min' => 'El campo Presentación es como mínimo 1(uno)',
                'presentation.max' => 'El campo Presentación es como máximo 1000000(un millon)',
                'amount_follow.required'=>'El campo Cantidad de remito es requerido',
                'amount_follow.integer' => 'El campo Cantidad de remito tiene que ser un número entero',
                'amount_follow.min' => 'El campo Cantidad de remito es como mínimo 0(cero)',
                'amount_follow.max' => 'El campo Cantidad de remito es como máximo 1000000(un millon)',
                'amount_undelivered.required'=>'El campo Sin recibir es requerido',
                'amount_undelivered.integer' => 'El campo Sin recibir tiene que ser un número entero',
                'amount_undelivered.min' => 'El campo Sin recibir es como mínimo 0(cero)',
                'amount_undelivered.max' => 'El campo Sin recibir es como máximo 1000000(un millon)',
                'set.required'=>'El campo Lote es requerido',
                'set.min' => 'El campo Presentación tiene como mínimo 1(un) caracter',
                'set.max' => 'El campo Presentación es como máximo 30(trinta) caracteres',
            ]);
            $this->detail[0]=$this->code;
            $this->detail[1]=$this->description;
            $this->detail[4]=$this->material_id;
            $this->detail[2]=$this->amount;
            $this->detail[3]=$this->count;
            $this->detail[5]=$this->presentation;
            $this->detail[6]=$this->warehouse_id;
            $this->detail[7]=$this->amount_requested;
            $this->detail[8]=$this->amount_follow;
            $this->detail[9]=$this->amount_undelivered;
            $this->detail[10]=$this->amount_requested-$this->amount;
            $this->detail[11]=$this->set;
        }  
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
        $this->funcion="create";
        $this->modo="Sin orden de compra";
    }
    public function explora(MaterialEntryOrder $order)
    {
        $this->entry_order_id=$order->id;
        $this->funcion="explora";
    }
    public function explorabuyorder(BuyOrder $order)
    {   
        $this->buy_order_id=$order->id;
        $this->buyorderdetails=BuyOrderDetail::where('buy_order_id',$this->buy_order_id)->get();
        $this->modo="Con orden de compra";
        $this->funcion="create";
    }
    public function volver(){
        $this->reset();
        $this->resetValidation();
    }
}
