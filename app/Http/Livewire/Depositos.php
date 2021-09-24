<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Warehouse;
use App\Models\Material;
use App\Models\DepositMaterial;
use App\Models\DepositInstallation;
use App\Models\Deposit;
use App\Models\AssembledDetail;
use App\Models\Assembled;
use App\Models\Installation;
use App\Models\MaterialEntryOrderDetail;
use App\Models\MaterialEntryOrder;
use App\Models\ExpendOrder;
use App\Models\ExpendOrderDetail;
use App\Models\Revision;
use Carbon\Carbon;

class Depositos extends Component
{
    public $depositos, $deposito, $origen, $causa, $modo, $deposito_id, $name, $location, $state, $create_date, $amount, $searchensamblados="", $searchdeposito="", $searchmateriales="", $searchinstallation="", $funcion="", $selector;
    public $seleccion, $ingreso, $material_id, $materiales, $code, $descriptionw, $description, $select=false, $revi=false, $ensamblados, $instalaciones, $revisiones, $number_version, $serial_number, $client_order_id, $materialesdepo, $ensambladosdepo, $instalacionesdepo;
    public $entry_order_id, $buy_order_id, $follow_number, $ordenesdepo, $date, $egreso, $details=array(), $detail=array(), $id_depomaterial;
    public $material_description, $material_code, $temporary, $count=0, $ordenegreso, $hour, $ordenegresodatail, $ordenegresodetail, $user, $sta, $destination, $presentation;
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
            ->orWhere('description','Like','%'.$this->searchdeposito.'%')
            ->orWhere('create_date', 'LIKE','%'.$this->searchdeposito.'%')
            ->orWhere('temporary','LIKE','%'.$this->searchdeposito.'%')->get();
        $this->materialesdepo=DepositMaterial::where('is_material', true)->where('warehouse_id', $this->deposito_id)->get();
        $this->ensambladosdepo=DepositMaterial::where('is_material', false)->where('warehouse_id', $this->deposito_id)->get();
        $this->instalacionesdepo=DepositInstallation::where('warehouse_id', $this->deposito_id)->get();
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
                'descriptionw' => 'string|min:4|max:300',
            ],
            [
                'name.required' => 'El campo Nombre es requerido',
                'name.min' => 'El campo Nombre tiene por lo menos 4 caracteres',
                'name.max' => 'El campo Nombre tiene como maximo 100 caracteres',
                'location.required' => 'El campo Ubicación es requerido',
                'location.min' => 'El campo Ubicación tiene como minimo 4 caracteres',
                'location.max' => 'El campo Ubicación tiene como maximo 300 caracteres',
                'descriptionw.min' => 'El campo Descripción tiene como minimo 4 caracteres',
                'descriptionw.max' => 'El campo Descripción tiene como maximo 300 caracteres',
            ]);
            $this->deposito=new Warehouse;
            $this->deposito->name=$this->name;
            $this->deposito->location=$this->location;
            $this->deposito->state=1;
            $this->deposito->create_date=$this->create_date;
            $this->deposito->description=$this->descriptionw;
            if($this->temporary==null){
                $this->temporary=false;
            }
            $this->deposito->temporary=$this->temporary;
            $this->deposito->save();
            $this->volver();
        }  
        elseif($this->funcion=="ingreso"){
            if($this->seleccion=="Material"){
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
                                $ing->date_change=Carbon::now();
                                $ing->save();
                                $this->funcion="explora";
                                $this->seleccion="";
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
                $this->amount=0;
                $this->select=false;
                $this->origen=null;
                $this->causa=null;
                $this->date=null;
                $this->hour=null;
                $this->details=null;
                $this->resetValidation();
            }elseif($this->seleccion=="Ensamblado"){
                $this->validate([
                    'amount' => 'required|integer|min:1|max:1000000',
                ],[
                    'amount.required' => 'El campo Cantidad es requerido',
                    'amount.integer' => 'El campo Cantidad es entero',
                    'amount.min' => 'El campo Cantidad tiene como mínimo 1(uno)',
                    'amount.max' => 'El campo Cantidad tiene como maximo 1000000(un millon)',
                ]);
                $this->ingreso=DepositMaterial::where('material_id', $this->material_id)->where('is_material', false)->where('warehouse_id', $this->deposito_id)->get();
                if($this->ingreso->count()==0){
                    $this->ingreso=new DepositMaterial;
                    $this->ingreso->warehouse_id=$this->deposito_id;
                    $this->ingreso->material_id=$this->material_id;
                    $this->ingreso->amount=$this->amount;
                    $this->ingreso->date_change=Carbon::now();
                    $this->ingreso->is_material=false;
                    $this->ingreso->presentation=1;
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
                $this->resetValidation();
            }elseif($this->seleccion=="Instalacion"){
                $this->validate([
                    'serial_number' => 'required|string|min:4|max:100',
                    'client_order_id' => 'required|numeric|min:0|max:1000000',
                    'number_version' => 'required|numeric|min:0|max:1000000',
                ],[
                    'serial_number.required' => 'El campo Número de serie es requerido',
                    'serial_number.min' => 'El campo Número de serie tiene como minimo 4 caracteres',
                    'serial_number.max' => 'El campo Número de serie tiene como maximo 100 caracteres',
                    'number_version.required' => 'El campo N° de version es requerido',
                    'number_version.numeric' => 'El campo N° de version es numerico',
                    'number_version.min' => 'El campo N° de version tiene como mínimo 0(cero)',
                    'number_version.max' => 'El campo N° de version tiene como maximo 10000000(diez millon)',
                    'client_order_id.required' => 'El campo Id orden de cliente es requerido',
                    'client_order_id.numeric' => 'El campo Id orden de cliente es numerico',
                    'client_order_id.min' => 'El campo Id orden de cliente tiene como mínimo 0(cero)',
                    'client_order_id.max' => 'El campo Id orden de cliente tiene como maximo 10000000(diez millon)',
                ]);
                    $this->ingreso=new DepositInstallation;
                    $this->ingreso->warehouse_id=$this->deposito_id;
                    $this->ingreso->installation_id=$this->material_id;
                    $this->ingreso->serial_number=$this->serial_number;
                    $this->ingreso->number_version=$this->number_version;
                    $this->ingreso->client_order_id=$this->client_order_id;
                    $this->ingreso->date_admission=Carbon::now();
                    $this->ingreso->save();
                    $this->description=null;
                    $this->funcion="explora";
                    $this->seleccion=""; 
                    $this->resetValidation();             
            }
        }elseif($this->funcion=="egreso"){
            $this->validate([
                'sta' => 'required|string|min:0|max:15',
                'user' => 'required|string|min:4|max:300',
            ],[ 'sta.required' => 'El campo Estado es requerido',
                'sta.min' => 'El campo Estado tiene como minimo 4 caracteres',
                'sta.max' => 'El campo Estado tiene como maximo 300 caracteres',
                'user.required' => 'El campo Usuario es requerido',
                'user.min' => 'El campo Usuario tiene como minimo 4 caracteres',
                'user.max' => 'El campo Usuario tiene como maximo 300 caracteres',
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
                $this->ordenegresodetail->description=$detail[7];
                $this->ordenegresodetail->warehouse_id=$this->deposito_id;
                $this->ordenegresodetail->amount=$detail[2];
                $this->ordenegresodetail->destination=$detail[8];
                $this->ordenegresodetail->presentation=$detail[9];
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
            $this->resetValidation(); 
        }elseif($this->funcion=="createassembled"){
            $this->validate([
                'description' => 'required|string|min:5|max:200'
            ],[
                'description.required' => 'El campo Descripción es requerido',
                'description.min' => 'El campo Descripción tiene como mínimo 5 caracteres',
                'description.max' => 'El campo Descripción tiene como máximo 200 caracteres'
            ]);
            $this->assembled=new Assembled;
            $this->assembled->description=$this->description;
            $this->assembled->create_date=$this->date;
            $this->assembled->save();
            foreach($this->details as $detail){
                $this->assembleddetail=new AssembledDetail;
                $this->assembleddetail->assembled_id=$this->assembled->id;
                $this->assembleddetail->material_id=$detail[0];
                $this->assembleddetail->amount=$detail[2];
                $this->assembleddetail->save();
                }
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
        $this->descriptionw=$deposito->description;
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

    public function addmateriald(Material $material)
    {
        foreach($this->details as $detail){
            if($detail[0]==$material->code && $detail[5]==$this->presentation && $detail[6]==$this->deposito_id){
                $this->downmateriald($detail[3]);
            }        
        }  
        $this->detail[0]=$material->code;
        $this->detail[1]=$material->description;
        $this->detail[2]=$this->amount;
        $this->detail[3]=$this->count;
        $this->detail[4]=$material->id;
        $this->detail[5]=$this->presentation;
        $this->detail[6]=$this->deposito_id;
        $this->details[]=$this->detail;
        $this->count=$this->count+1;
        $this->amount=0;
        $this->presentation=0;
        $this->searchmateriales="";
    }
    public function downmateriald($orden)
    {
        unset($this->details[$orden]);
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
        $this->presentation=$material->presentation;
        
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
                'egreso' => 'required|integer|min:1|max:1000000',
                'destination' => 'required|string|min:4|max:300',
                'amount' => 'required|integer|min:1|max:1000000',
            ],[
                'destination.required' => 'El campo Destino  es requerido',
                'destination.min' => 'El campo Destino tiene como minimo 4 caracteres',
                'destination.max' => 'El campo Destino tiene como maximo 300 caracteres',
                'amount.required' => 'El campo Cantidad es requerido',
                'amount.integer' => 'El campo Cantidad es entero',
                'amount.min' => 'El campo Cantidad tiene como mínimo 1(uno)',
                'amount.max' => 'El campo Cantidad tiene como maximo 1000000(un millon)',
                'egreso.required' => 'El campo Egreso es requerido',
                'egreso.integer' => 'El campo Egreso es entero',
                'egreso.min' => 'El campo Egreso tiene como mínimo 1(uno)',
                'egreso.max' => 'El campo Egreso tiene como maximo 1000000(un millon)',
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
            $this->detail[9]=$this->presentation;
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
        $this->resetValidation();
        $this->sta=null;
        $this->user=null;
        $this->seleccion="";
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

    public function createassembled()
    {
        $this->funcion="createassembled";
    }

    public function addmateriall(Material $material)
    {
        $this->validate([
            'amount'=>'required|integer|min:1|max:1000000'
        ], [
            'amount.required'=>'El campo Cantidad es requerido',
            'amount.integer' => 'El campo Cantidad tiene que ser un número entero',
            'amount.min' => 'El campo Cantidad es como mínimo 1(uno)',
            'amount.max' => 'El campo Cantidad es como máximo 1000000(un millon)',
        ]);
        foreach($this->details as $detail){
            if($detail[0]==$material->code){
                $this->downmaterial($detail[3]);
            }        
        }
        $this->detail[0]=$material->code;
        $this->detail[1]=$material->description;
        $this->detail[2]=$this->amount;
        $this->detail[3]=$this->count;
        $this->detail[4]=$material->id;
        $this->details[]=$this->detail;
        $this->count=$this->count+1;
        $this->amount=0;
    }

    public function downmateriall($orden)
    {
        unset($this->details[$orden]);
    }

    public function volver()
    {
        $this->resetValidation();
        $this->reset();
    }
}
