<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Warehouse;
use App\Models\Material;
use App\Models\DepositMaterial;
use App\Models\DepositInstallation;
use App\Models\Deposit;
use App\Models\Assembled;
use App\Models\Installation;
use App\Models\MaterialEntryOrder;
use App\Models\ExpendOrder;
use App\Models\ExpendOrderDetail;
use App\Models\Revision;
use Carbon\Carbon;

class Depositos extends Component
{
    public $depositos, $deposito, $deposito_id, $name, $location, $state, $create_date, $amount, $purpose, $searchensamblados="", $searchdeposito="", $searchmateriales="", $searchinstallation="", $funcion="", $selector;
    public $seleccion, $ingreso, $material_id, $materiales, $code, $description, $select=false, $revi=false, $ensamblados, $instalaciones, $revisiones, $number_version, $serial_number, $client_order_id, $materialesdepo, $ensambladosdepo, $instalacionesdepo;
    public $entry_order_id, $buy_order_id, $follow_number, $ordenesdepo, $egreso, $details=array(), $detail=array(), $id_depomaterial;
    public $material_description, $material_code, $count=0, $ordenegreso, $ordenegresodatail, $ordenegresodetail, $user, $sta, $destination;
    public function render()
    {
        $this->ensamblados=Assembled::where('id','like','%'.$this->searchensamblados.'%')
            ->orWhere('description','LIKE','%'.$this->searchensamblados.'%')->get();
        $this->instalaciones=Installation::where('id','LIKE','%' .$this->searchinstallation. '%')
            ->orWhere('code','LIKE','%'.$this->searchinstallation.'%')
            ->orWhere('description','LIKE','%'.$this->searchinstallation.'%')->get();
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
        $this->depositos=Warehouse::where('id','LIKE','%'.$this->searchdeposito.'%')
            ->orWhere('name','LIKE','%'.$this->searchdeposito.'%')
            ->orWhere('location','LIKE','%'.$this->searchdeposito.'%')
            ->orWhere('state','Like','%'.$this->searchdeposito.'%')
            ->orWhere('create_date', 'LIKE','%'.$this->searchdeposito.'%')
            ->orWhere('purpose','LIKE','%'.$this->searchdeposito.'%')->get();
        $this->materialesdepo=DepositMaterial::where('is_material', true)->where('warehouse_id', $this->deposito_id)->get();
        $this->ensambladosdepo=DepositMaterial::where('is_material', false)->where('warehouse_id', $this->deposito_id)->get();
        $this->instalacionesdepo=DepositInstallation::where('warehouse_id', $this->deposito_id)->get();
        $this->ordenesdepo=MaterialEntryOrder::where('warehouse_id', $this->deposito_id)->get();
        return view('livewire.depositos');
        
    }
    public function create()
    {
        $this->funcion="create";
    }

    public function store()
    {
        if($this->funcion=="create"){
            $this->validate([
                'name' => 'required|string|min:4|max:100',
                'location' => 'required|string|min:4|max:300',
                'purpose' => 'required|string|min:4|max:300',
            ]);
            $this->deposito=new Warehouse;
            $this->deposito->name=$this->name;
            $this->deposito->location=$this->location;
            $this->deposito->state=1;
            $this->deposito->create_date=$this->create_date;
            $this->deposito->purpose=$this->purpose;
            $this->deposito->save();
            $this->volver();
        }  
        elseif($this->funcion=="ingreso"){
            if($this->seleccion=="Material"){
                $this->validate([
                    'amount' => 'required|integer|min:1|max:1000000',
                ]);
                $this->ingreso=DepositMaterial::where('material_id', $this->material_id)->where('is_material',true)->where('warehouse_id', $this->deposito_id)->get();
                if($this->ingreso->count()==0){
                    $this->ingreso=new DepositMaterial;
                    $this->ingreso->warehouse_id=$this->deposito_id;
                    $this->ingreso->material_id=$this->material_id;
                    $this->ingreso->amount=$this->amount;
                    $this->ingreso->date_change=Carbon::now();
                    $this->ingreso->is_material=true;
                    $this->ingreso->save();
                    $this->funcion="explora";
                    $this->seleccion="";
                }else{
                    foreach($this->ingreso as $ing){
                        $ing->amount=($ing->amount+$this->amount);
                        $ing->date_change=Carbon::now();
                        $ing->save();
                        $this->funcion="explora";
                        $this->seleccion="";
                    }
                }
                $this->amount=0;
                $this->select=false;
            }elseif($this->seleccion=="Ensamblado"){
                $this->validate([
                    'amount' => 'required|integer|min:1|max:1000000',
                ]);
                $this->ingreso=DepositMaterial::where('material_id', $this->material_id)->where('is_material', false)->where('warehouse_id', $this->deposito_id)->get();
                if($this->ingreso->count()==0){
                    $this->ingreso=new DepositMaterial;
                    $this->ingreso->warehouse_id=$this->deposito_id;
                    $this->ingreso->material_id=$this->material_id;
                    $this->ingreso->amount=$this->amount;
                    $this->ingreso->date_change=Carbon::now();
                    $this->ingreso->is_material=false;
                    $this->ingreso->save();
                    $this->funcion="explora";
                    $this->seleccion="";
                }else{
                    foreach($this->ingreso as $ing){
                        $ing->amount=($ing->amount+$this->amount);
                        $ing->date_change=Carbon::now();
                        $ing->save();
                        $this->funcion="explora";
                        $this->seleccion="";
                    }
                }
                $this->amount=0;
                $this->select=false;
            }elseif($this->seleccion=="Instalacion"){
                $this->validate([
                    'serial_number' => 'required|string|min:4|max:100',
                    'client_order_id' => 'required|numeric|min:0|max:1000000',
                    'number_version' => 'required|numeric|min:0|max:1000000',
                ]);
                    $this->ingreso=new DepositInstallation;
                    $this->ingreso->warehouse_id=$this->deposito_id;
                    $this->ingreso->installation_id=$this->material_id;
                    $this->ingreso->serial_number=$this->serial_number;
                    $this->ingreso->number_version=$this->number_version;
                    $this->ingreso->client_order_id=$this->client_order_id;
                    $this->ingreso->date_admission=Carbon::now();
                    $this->ingreso->save();
                    $this->funcion="explora";
                    $this->seleccion="";              
            }elseif($this->seleccion=="Orden de ingreso de materiales"){
                $this->validate([
                    'follow_number' => 'required|string|min:4|max:100',
                    'entry_order_id' => 'required|numeric|min:0|max:10000000',
                    'buy_order_id' => 'required|numeric|min:0|max:10000000',
                ]);
                $this->ingreso=new MaterialEntryOrder;
                $this->ingreso->entry_order_id=$this->entry_order_id;
                $this->ingreso->warehouse_id=$this->deposito_id;
                $this->ingreso->buy_order_id=$this->buy_order_id;
                $this->ingreso->follow_number=$this->follow_number;
                $this->ingreso->date=Carbon::now();
                $this->ingreso->hour=Carbon::now()->format('H:i:s');
                $this->ingreso->save();
                $this->funcion="explora";
                $this->seleccion="";               
            }
        }elseif($this->funcion=="egreso"){
            $this->validate([
                'sta' => 'required|string|min:0|max:15',
                'user' => 'required|string|min:4|max:300',
            ]);
            $this->ordenegreso=new ExpendOrder;
            $this->ordenegreso->date_time=Carbon::now();
            $this->ordenegreso->state=$this->sta;
            $this->ordenegreso->user=$this->user;
            $this->ordenegreso->save();
            foreach($this->details as $detail){
                $this->ordenegresodetail=new ExpendOrderDetail;
                $this->ordenegresodetail->expend_order_id=$this->ordenegreso->id;
                $this->ordenegresodetail->material_id=$detail[0];
                $this->ordenegresodetail->warehouse_id=$this->deposito_id;
                $this->ordenegresodetail->amount=$detail[2];
                $this->ordenegresodetail->destination=$detail[8];
                $this->ordenegresodetail->save();
                $this->egreso=DepositMaterial::find($detail[5]);
                $this->egreso->amount=$this->egreso->amount-$detail[2];
                $this->egreso->save();
                $this->details=null;
                if($this->egreso->amount==0){
                    $this->egreso->delete();
                }
            }
            $this->amount=0;
            $this->sta=null;
            $this->user=null;
            $this->egreso=0;
            $this->destination=null;
            $this->funcion="explora"; 
        }
        $this->select=false;
    }

    public function explora(Warehouse $deposito)
    {
        $this->funcion="explora";
        $this->deposito_id=$deposito->id;
        $this->name=$deposito->name;
        $this->location=$deposito->location;
        $this->state=$deposito->state;
        $this->create_date=$deposito->create_date;
        $this->purpose=$deposito->purpose;
    }

    public function addmaterial(Material $material)
    {
        $this->searchmateriales="";
        $this->select=true;
        $this->material_id=$material->id;
        $this->code=$material->code;
        $this->description=$material->description;
    }

    public function downmaterial()
    {
        $this->searchmateriales="";
        $this->searchensamblados="";
        $this->select=false;
        $this->material_id=null;
        $this->code=null;
        $this->description=null;
        $this->amount=null;
    }

    public function retiromaterial(DepositMaterial $material)
    {
        $this->select=true;
        $this->material_code=$material->materials->code;
        $this->material_description=$material->materials->description;
        $this->id_depomaterial=$material->id;
        $this->material_id=$material->material_id;
        $this->amount=$material->amount;
        $this->id_depomaterial=$material->id;
        
    }

    public function egresomaterial()
    {
        if($this->amount>=$this->egreso){
            foreach($this->details as $detail){
                if($detail[0]==$this->material_id){
                    $this->downegreso($detail[4]);
                }
            } 
            $this->validate([
                'egreso' => 'required|integer|min:1',
                'destination' => 'required|string|min:4|max:300'
            ]);
            $this->detail[0]=$this->material_id;
            $this->detail[1]=$this->amount;
            $this->detail[2]=$this->egreso;
            $this->detail[3]=$this->id_depomaterial;
            $this->detail[4]=$this->count;
            $this->detail[5]=$this->id_depomaterial;
            $this->detail[6]=$this->material_code;
            $this->detail[7]=$this->material_description;
            $this->detail[8]=$this->destination;
            $this->details[]=$this->detail;
            $this->egreso=0;
            $this->count=$this->count+1;
            $this->select=false;
        }
    }

    public function downegreso($algo)
    {
        unset($this->details[$algo]);
    }

    public function addassembled(Assembled $material)
    {
        $this->searchensamblados="";
        $this->select=true;
        $this->material_id=$material->id;
        $this->description=$material->description;
    }

    public function addinstallation(Installation $material)
    {
        $this->searchmateriales="";
        $this->searchmensamblados="";
        $this->select=true;
        $this->material_id=$material->id;
        $this->code=$material->code;
        $this->description=$material->description;
        $this->revisiones=Revision::where('installation_id', $material->id)->get();

    }

    public function downinstallation()
    {
        $this->searchinstalaciones="";
        $this->select=false;
        $this->material_id=null;
        $this->code=null;
        $this->description=null;
        $this->amount=null;
    }

    public function selectrevision(Revision $revision)
    {
        $this->revisiones=Revision::where('installation_id', $revision->installation_id)->where('number_version', $revision->number_version)->get();
        $this->number_version=$revision->number_version;
        $this->revi=true;
    }

    public function downrevision()
    {
        $this->revi=false;
        $this->number_version=null;
    }

    public function ingreso()
    {
        $this->funcion="ingreso";
    }

    public function egreso()
    {
        $this->funcion="egreso";
    }

    public function retiros()
    {
        $this->funcion="retiros";
        $this->ordenegresodatail=ExpendOrderDetail::where('warehouse_id',$this->deposito_id)->get();
    }

    public function toexplora()
    {
        $this->select=false;
        $this->funcion="explora";
    }

    public function delete(Warehouse $deposito)
    {
        $this->deposito_id=$deposito->id;
        $this->materialesdepo=DepositMaterial::where('is_material', true)->where('warehouse_id', $this->deposito_id)->get();
        $this->ensambladosdepo=DepositMaterial::where('is_material', false)->where('warehouse_id', $this->deposito_id)->get();
        $this->instalacionesdepo=DepositInstallation::where('warehouse_id', $this->deposito_id)->get();
        $this->ordenesdepo=MaterialEntryOrder::where('warehouse_id', $this->deposito_id)->get();
        if( ($this->materialesdepo->count()==0) && ($this->ensambladosdepo->count()==0)  && ($this->instalacionesdepo->count()==0) && ($this->ordenesdepo->count()==0)){
            $deposito->delete();
        }
    }

    public function volver()
    {
        $this->reset();
    }
}
