<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\MaterialEntryOrder;
use App\Models\MaterialEntryOrderDetail;
use App\Models\Warehouse;
use App\Models\Material;
use App\Models\DepositMaterial;
class OrdenDeEntradaDeMateriales extends Component
{
    public $orders, $date, $hour, $orden, $funcion="", $count=0, $depositm, $detailem, $warehouse_id, $nombre_deposito, $depositos, $materiales, $detail=array(), $details=array(),$searchordenesem="", $amount, $description, $presentation, $origen, $causa, $material_id, $code, $modo, $create_date, $create_hour, $searchmateriales, $select=false;
    public $orderdetails, $entry_order_id;
    public function render()
    {
        $this->orders=MaterialEntryOrder::where('id','LIKE','%' . $this->searchordenesem . '%')
            ->orWhere('buy_order_id','LIKE','%'.$this->searchordenesem.'%')
            ->orWhere('follow_number','LIKE','%'.$this->searchordenesem.'%')
            ->orWhere('date','LIKE','%'.$this->searchordenesem.'%')
            ->orWhere('hour','LIKE','%'.$this->searchordenesem.'%')->get();
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
        return view('livewire.orden-de-entrada-de-materiales');
    }
    public function store()
    {
        if($this->modo=="Sin orden de compra"){
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
        }
    }
    public function addmaterial(Material $material)
    {
        $warehouse=Warehouse::where('name',$this->nombre_deposito)->get();
        foreach($warehouse as $ware){
            $this->warehouse_id=$ware->id;
        }
        $this->validate([
            'amount'=>'required|integer|min:1|max:1000000'
        ], [
            'amount.required'=>'El campo Cantidad es requerido',
            'amount.integer' => 'El campo Cantidad tiene que ser un número entero',
            'amount.min' => 'El campo Cantidad es como mínimo 1(uno)',
            'amount.max' => 'El campo Cantidad es como máximo 1000000(un millon)',
        ]);
        foreach($this->details as $detail){
            if($detail[0]==$material->code && $detail[5]==$this->presentation && $detail[6]==$this->warehouse_id){
                $this->downmaterial($detail[3]);
            }        
        }  
        $this->detail[0]=$material->code;
        $this->detail[1]=$material->description;
        $this->detail[2]=$this->amount;
        $this->detail[3]=$this->count;
        $this->detail[4]=$material->id;
        $this->detail[5]=$this->presentation;
        $this->detail[6]=$this->warehouse_id;
        $this->details[]=$this->detail;
        $this->count=$this->count+1;
        $this->amount=0;
        $this->presentation=0;
    }
    public function downmaterial($orden)
    {
        unset($this->details[$orden]);
    }
    public function create()
    {
        $this->funcion="create";
    }
    public function explora(MaterialEntryOrder $order)
    {
        $this->entry_order_id=$order->id;
        $this->funcion="explora";
    }
    public function volver(){
        $this->reset();
    }
}
