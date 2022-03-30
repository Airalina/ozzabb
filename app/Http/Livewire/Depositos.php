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
use App\Models\BuyOrder;
use App\Models\BuyOrderDetail;
use App\Models\BuyOrderMaterialEntryOrder;
use App\Models\Workorder;
use Carbon\Carbon;
use Livewire\WithPagination;
use DB;

class Depositos extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $deposito, $origen,$paginas=25, $paginasinternas=10, $causa, $modo, $deposito_id, $name, $location, $state, $create_date, $amount, $searchensamblados="", $searchdeposito="", $searchmateriales="", $searchinstallation="", $searchorderbuy, $funcion="", $selector;
    protected $depositos, $materialesdepo, $ensambladosdepo, $instalacionesdepo, $deposit_material;
    public $seleccion, $ingreso, $codem, $descriptionm, $presentationm=[], $material_id, $type, $materiales, $name_receive, $name_entry, $code, $descriptionw, $description, $select=false, $revi=false, $ensamblados, $instalaciones, $revisiones, $number_version, $serial_number, $client_order_id;
    public $searchmaterialsdepo="", $entry_order_id, $buy_order_id, $order="type", $follow_number, $ordenesdepo, $date, $egreso, $details=array(), $detail=array(), $id_depomaterial;
    public $material_description,$deposito_delete,$amount_requested,$nombre_deposito,$amount_follow,$amount_undelivered,$set, $buyorders, $ingresa=false, $buyorderdetails, $follow, $material_code, $temporary,$permanent, $count=0, $ordenegreso, $hour, $ordenegresodatail, $ordenegresodetail, $user, $sta, $destination, $presentation, $deposits, $depo, $materials_deposit, $materials_deposits, $materials_presentation, $materials_amount, $depo_destino, $name_egress, $explora_depo, $presentations, $amounts, $total, $totals, $retiros, $ingresos, $retiro, $ensamblados_deposits, $searchensambladodepo="", $descriptiona, $assembled_id, $assembled_amount, $selection = '', $materials_assembleds, $depo_id=0, $disabled='', $reservations = array();
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $this->buyorders=BuyOrder::where('id','LIKE','%'.$this->searchorderbuy.'%')
            ->orWhere('provider_id','LIKE','%',$this->searchorderbuy.'%')
            ->orWhere('order_number','LIKE','%',$this->searchorderbuy.'%')
            ->orWhere('pucharsing_sheet_id','LIKE','%',$this->searchorderbuy.'%')
            ->orWhere('order_number','LIKE','%',$this->searchorderbuy.'%')
            ->orWhere('state','LIKE','%',$this->searchorderbuy.'%')->orderByDesc('state')->get();
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
            ->orWhere('stock_min','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('stock_max','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('stock','LIKE','%'.$this->searchmateriales.'%')->get();
        $this->depositos=Warehouse::where('id','LIKE','%'.$this->searchdeposito.'%')
            ->orWhere('name','LIKE','%'.$this->searchdeposito.'%')
            ->orWhere('location','LIKE','%'.$this->searchdeposito.'%')
            ->orWhere('description','Like','%'.$this->searchdeposito.'%')
            ->orWhere('create_date', 'LIKE','%'.$this->searchdeposito.'%')
            ->orWhere('temporary','LIKE','%'.$this->searchdeposito.'%')->orderBy($this->order)->paginate($this->paginas);
        $this->deposits = Warehouse::where('id','!=', $this->deposito_id)->where(function ($query) {
            $query->where('id','LIKE','%'.$this->searchdeposito.'%')
            ->orWhere('name','LIKE','%'.$this->searchdeposito.'%')
            ->orWhere('location','LIKE','%'.$this->searchdeposito.'%')
            ->orWhere('description','Like','%'.$this->searchdeposito.'%')
            ->orWhere('create_date', 'LIKE','%'.$this->searchdeposito.'%')
            ->orWhere('temporary','LIKE','%'.$this->searchdeposito.'%');
        })->get();
      
        if (!empty($this->depo)) {
            if ($this->depo_id != 0) {
                $this->materials_deposits = $this->depo->materials()->groupBy('material_id')->where(function ($query) {
                    $query->where('code','like','%'.$this->searchmaterialsdepo.'%')
                    ->orWhere('name','LIKE','%'.$this->searchmaterialsdepo.'%')
                    ->orWhere('family','LIKE','%'.$this->searchmaterialsdepo.'%')
                    ->orWhere('color','LIKE','%'.$this->searchmaterialsdepo.'%')
                    ->orWhere('description','LIKE','%'.$this->searchmaterialsdepo.'%')
                    ->orWhere('stock_min','LIKE','%'.$this->searchmaterialsdepo.'%')
                    ->orWhere('stock_max','LIKE','%'.$this->searchmaterialsdepo.'%')
                    ->orWhere('stock','LIKE','%'.$this->searchmaterialsdepo.'%');
                })->get();
                
                $this->ensamblados_deposits = $this->depo->assembleds()->where('is_material',0)->groupBy('id')->where(function ($query) {
                    $query->where('assembleds.id','LIKE','%'.$this->searchensambladodepo.'%')
                    ->orWhere('assembleds.description','LIKE','%'.$this->searchensambladodepo.'%');
                })->get();
              #  dd($this->ensamblados_deposits);
                $this->instalaciones = $this->depo->installations()->groupBy('id')->where(function ($query) {
                    $query->where('installations.id','LIKE','%' .$this->searchinstallation. '%')
                    ->orWhere('installations.code','LIKE','%'.$this->searchinstallation.'%')
                    ->orWhere('installations.description','LIKE','%'.$this->searchinstallation.'%');
                })->get();
            }

        #dd($this->instalaciones);
        }else{
            $this->materials_deposits = Material::where('code','like','%'.$this->searchmaterialsdepo.'%')
            ->orWhere('name','LIKE','%'.$this->searchmaterialsdepo.'%')
            ->orWhere('family','LIKE','%'.$this->searchmaterialsdepo.'%')
            ->orWhere('color','LIKE','%'.$this->searchmaterialsdepo.'%')
            ->orWhere('description','LIKE','%'.$this->searchmaterialsdepo.'%')
            ->orWhere('stock_min','LIKE','%'.$this->searchmaterialsdepo.'%')
            ->orWhere('stock_max','LIKE','%'.$this->searchmaterialsdepo.'%')
            ->orWhere('stock','LIKE','%'.$this->searchmaterialsdepo.'%')->get();
            
            $this->ensamblados_deposits = Assembled::where('id','like','%'.$this->searchensamblados.'%')
            ->orWhere('description','LIKE','%'.$this->searchensamblados.'%')->get();
            
        }
      #  dd($this->instalaciones);
        if (!empty($this->explora_depo)) {
            $this->materialesdepo=$this->explora_depo->materials()->groupBy('material_id')->paginate($this->paginasinternas);
            $this->materials_assembleds=$this->explora_depo->depositmaterials()->groupBy('is_material','material_id')->get();
            $this->instalacionesdepo=$this->explora_depo->depositinstallations()->paginate($this->paginasinternas);
           
            #dd($this->materials_assembleds);
            foreach ($this->materialesdepo as $material) {
                $this->presentations[$material->id] = $material->depositmaterials()->where('warehouse_id',
                $this->deposito_id)->where('is_material',1)->groupBy('presentation')->get();

                $this->amounts[$material->id] = $material->depositmaterials()->where('warehouse_id',
                $this->deposito_id)->where('is_material',1)->select('presentation','material_id', DB::raw('SUM(amount) as
                total'))->groupBy('presentation')->get(); 

                $workorder = Workorder::where('state', 'Actual')->orWhere('state', 'Actual con pedidos cancelados')->first();
                
               
                    foreach ($this->presentations[$material->id] as $key => $presentation) {
                        $this->reservations[$material->id][$key] = (!empty($workorder)) ? $material->reservationmaterials()->select('id', 'amount' ,'material_id', 'presentation' ,DB::raw('SUM(amount) as
                    total'))->where('workorder_id', $workorder->id)->where('presentation',$presentation->presentation)->first() : '-';
                    }

                foreach ($this->amounts[$material->id] as $index => $amount) {
                    $this->totals[$amount->material_id][$index] = $amount->presentation * $amount->total;
                }
                
            }

            $this->ensambladosdepo=$this->explora_depo->assembleds()->groupBy('id')->paginate($this->paginasinternas);
           foreach ($this->ensambladosdepo as $ensamblado) {
               $this->total[$ensamblado->id] = $ensamblado->depositmaterials()->where('warehouse_id',
               $this->deposito_id)->where('is_material',0)->select('material_id', DB::raw('SUM(amount) as
               total'))->groupBy('material_id')->get();
              
           }
        }    
        #$this->ensambladosdepo=DepositMaterial::where('is_material', false)->where('warehouse_id', $this->deposito_id)->paginate($this->paginasinternas);
        return view('livewire.depositos',[
            #$this->instalacionesdepo=DepositInstallation::where('warehouse_id', $this->deposito_id)->paginate($this->paginasinternas);
            'depositos' => $this->depositos,
            'materialesdepo' => $this->materialesdepo,
            'ensambladosdepo' => $this->ensambladosdepo,
            'instalacionesdepo' => $this->instalacionesdepo,
        ]);
        
    }
    public function create()
    {
        $this->funcion="create";
    }

    public function store()
    {
        # code...
        if($this->funcion=="create"){
            $this->validate([
                'type'=>'required|min:4',
                'name' => 'required|string|min:4|max:100',
                'location' => 'required|string|min:4|max:300',
                'descriptionw' => 'required|string|min:4|max:300',
                'create_date'=>'required',
            ],
            [
                'type.required'=>'El campo Tipo de depósito es requerido',
                'type.min'=>'El campo Tipo de depósito es requerido',
                'name.required' => 'El campo Nombre es requerido',
                'name.min' => 'El campo Nombre tiene por lo menos 4 caracteres',
                'name.max' => 'El campo Nombre tiene como maximo 100 caracteres',
                'location.required' => 'El campo Ubicación es requerido',
                'location.min' => 'El campo Ubicación tiene como minimo 4 caracteres',
                'location.max' => 'El campo Ubicación tiene como maximo 300 caracteres',
                'descriptionw.required'=>"El campo Descripción es requerido",
                'descriptionw.min' => 'El campo Descripción tiene como minimo 4 caracteres',
                'descriptionw.max' => 'El campo Descripción tiene como maximo 300 caracteres',
                'create_date.required'=>'El campo Fecha es requerido',
            ]);
            $this->deposito=new Warehouse;
            $this->deposito->name=$this->name;
            $this->deposito->location=$this->location;
            $this->deposito->state=1;
            switch($this->type){
                case "Almacén":
                    $this->deposito->type=1;
                    break;
                case "Producción":
                    $this->deposito->type=2;
                    break;
                case "Ensamblados":
                    $this->deposito->type=3;
                    break;
                case "Expedición":
                    $this->deposito->type=4;
                    break;    
            }
            $this->deposito->create_date=$this->create_date;
            $this->deposito->description=$this->descriptionw;
            if($this->temporary==null && $this->permanent==null){
                $this->deposito->temporary=0;
            }elseif($this->temporary){
                $this->deposito->temporary=1;
            }elseif($this->permanent){
                $this->deposito->temporary=0;
            }
            $this->deposito->save();
            $this->volver();
        }elseif($this->funcion=="update"){
            $this->deposito=Warehouse::find($this->deposito_id);
            $this->deposito->name=$this->name;
            $this->deposito->location=$this->location;
            $this->deposito->state=1;
            $this->deposito->description=$this->descriptionw;
            if($this->temporary==null){
                $this->temporary=false;
            }
            $this->deposito->temporary=$this->temporary;
            $this->deposito->save();
            $this->explora($this->deposito);
        }
        elseif($this->funcion=="createbo"){
            {
                $this->validate([
                    'date' => 'required',
                    'hour' => 'required',
                    'follow' => 'string|min:4|max:300',
                ],
                [
                    'date.required' => 'El campo Fecha es requerido',
                    'hour.required' => 'El campo Hora es requerido',
                    'name.max' => 'El campo Nombre tiene como maximo 100 caracteres',
                    'follow.required' => 'El campo N° de remito es requerido',
                    'follow.min' => 'El campo N° de remito tiene como minimo 4 caracteres',
                    'follow.max' => 'El campo N° de remito tiene como maximo 300 caracteres',
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
                    $this->ingreso=DepositMaterial::where('material_id',$detail[4])->where('is_material',true)->where('presentation',$detail[5])->where('warehouse_id',$this->deposito_id)->get();
                    if($this->ingreso->count()==0){
                        $this->depositm=new DepositMaterial;
                        $this->depositm->material_id=$detail[4];
                        $this->depositm->warehouse_id=$this->deposito_id;
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
                    $this->detailem->warehouse_id=$this->deposito_id;
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
            $this->amount=0;
            $this->select=false;
            $this->follow=null;
            $this->date=null;
            $this->hour=null;
            $this->date=null;
            $this->hour=null;
            $this->code=null;
            $this->description=null;
            $this->material_id=null;
            $this->count=null;
            $this->presentation=null;
            $this->amount_requested=null;
            $this->amount_follow=null;
            $this->amount_undelivered=null;
            $this->details=null;
            $this->set=null;
            $this->resetValidation();
            $this->funcion="explora";
            $this->seleccion="";
            $this->modo="";
        }  
        elseif($this->funcion=="ingreso"){
            if (empty($this->depo)) {
                $this->depo = new Warehouse;
                $this->depo->id = 0;
    
            }
            if($this->type==1||$this->type==2){
                $this->validate([
                    'date' => 'required',
                    'hour' => 'required',
                    'depo' => 'required',
                    'name_receive' => 'required',
                    'name_entry' => 'required',
                    'selection' => 'required'
                ],
                [
                    'date.required' => 'El campo Fecha es requerido',
                    'hour.required' => 'El campo Hora es requerido',
                    'name.max' => 'El campo Nombre tiene como maximo 100 caracteres',
                    'depo.required' => 'Debe seleccionar un depósito origen',
                    'name_receive.required' => 'El campo "Responsable de recibir" es requerido',
                    'name_entry.required' => 'El campo "Responsable de ingresar" es requerido',
                    'selection.required' => 'Debe seleccionar una opción del tipo de producto a ingresar'
                ]);
                if ($this->explora_depo->type == 2 && ($this->depo->type != 2 && $this->depo->id != 0)) {
                    $this->addError('depo', 'El depósito origen debe ser tipo producción');
                }elseif(($this->explora_depo->type == 1) && ($this->depo->type !=2 && $this->depo->type !=1 && $this->depo->id != 0)){
                    $this->addError('depo', 'El depósito origen debe ser tipo producción o almacen');
                }
                else{            
                        foreach($this->details as $detail){
                            $this->depositm=new DepositMaterial;
                            $this->depositm->material_id= ($this->selection == 'Materiales') ? $detail[4] : $this->material_id; 
                            $this->depositm->warehouse_id=($this->selection == 'Materiales') ? $detail[6] : $this->deposito_id; 
                            $this->depositm->warehouse2_id=($this->selection == 'Materiales') ? $detail[7] : $this->depo->id; 
                            $this->depositm->presentation=($this->selection == 'Materiales') ? $detail[5] : 1; 
                            $this->depositm->amount=($this->selection == 'Materiales') ? $detail[2] : $this->amount; 
                            $this->depositm->date_change=$this->date;
                            $this->depositm->hour=$this->hour;
                            $this->depositm->name_receive=$this->name_receive;
                            $this->depositm->name_entry=$this->name_entry;
                            $this->depositm->is_material=($this->selection == 'Materiales') ? 1 : 0;
                            $this->depositm->type=1;
                            $this->depositm->save();
                              
                    }
                
                    $this->amount=null;
                    $this->select=false;
                    $this->origen=null;
                    $this->name_receive=null;
                     $this->depo_id=0;
                    $this->name_entry=null;
                    $this->causa=null;
                    $this->selection='';
                    unset($this->details);
                    unset($this->depo);
                    $this->resetValidation();
                    $this->funcion="explora";
                    $this->modo="";
                }
                    
            }elseif($this->type==3){
                $this->validate([
                    'date' => 'required',
                    'hour' => 'required',
                    'depo' => 'required',
                    'name_receive' => 'required',
                    'name_entry' => 'required',
                    'amount' => 'required|integer|min:1|max:1000000',
                ],
                [
                    'date.required' => 'El campo Fecha es requerido',
                    'hour.required' => 'El campo Hora es requerido',
                    'name.max' => 'El campo Nombre tiene como maximo 100 caracteres',
                    'depo.required' => 'Debe seleccionar un depósito origen',
                    'name_receive.required' => 'El campo "Responsable de recibir" es requerido',
                    'name_entry.required' => 'El campo "Responsable de ingresar" es requerido',
                    'amount.required' => 'El campo Cantidad es requerido',
                    'amount.integer' => 'El campo Cantidad es entero',
                    'amount.min' => 'El campo Cantidad tiene como mínimo 1(uno)',
                    'amount.max' => 'El campo Cantidad tiene como maximo 1000000(un millon)',
                ]);
                if (($this->depo->type != 2 && $this->depo->type != 3  && $this->depo->id != 0) && ($this->explora_depo->type == 3)) {
                    $this->addError('depo', 'El depósito origen debe ser tipo producción o expedición');
                }else{
               
                    $this->ingreso=new DepositMaterial;
                    $this->ingreso->warehouse_id=$this->deposito_id;
                    $this->ingreso->material_id=$this->material_id;
                    $this->ingreso->amount=$this->amount;
                    $this->ingreso->date_change=$this->date;
                    $this->ingreso->hour=$this->hour;
                    $this->ingreso->is_material=false;
                    $this->ingreso->presentation=1;
                    $this->ingreso->warehouse2_id=$this->depo->id;
                    $this->ingreso->name_receive=$this->name_receive;
                    $this->ingreso->name_entry=$this->name_entry;
                    $this->ingreso->type=1;
                    $this->ingreso->save();
                   
                    $this->funcion="explora";    
                    $this->selection='';
                    $this->amount=0;
                    $this->select=false;
                    $this->amount=null;
                    $this->select=false;
                    $this->origen=null;
                    $this->name_receive=null;
                     $this->depo_id=0;
                    $this->name_entry=null;
                    $this->causa=null;
                    unset($this->details);
                    unset($this->depo);
                    $this->resetValidation();
            }
        }elseif($this->type==4){
             $this->validate([
                    'serial_number' => 'required|string|min:4|max:100',
                    'client_order_id' => 'required|numeric|min:0|max:1000000',
                    'number_version' => 'required|numeric|min:0|max:1000000',
                    'date' => 'required|date',
                    'hour' => 'required',
                    'name_receive' => 'required',
                    'name_entry' => 'required',
                    'depo' => 'required',
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
                    'date.required' => 'El campo Fecha es requerido',
                    'date.date' => 'El campo Fecha debe ser una fecha con formato "dd/mm/AAAA"',
                    'depo.required' => 'Debe seleccionar un depósito origen',
                    'date.required' => 'El campo Fecha es requerido',
                    'hour.required' => 'El campo Hora es requerido',
                    'name.max' => 'El campo Nombre tiene como maximo 100 caracteres',
                    'name_receive.required' => 'El campo "Responsable de recibir" es requerido',
                    'name_entry.required' => 'El campo "Responsable de ingresar" es requerido',
                   
                ]);
            if (($this->depo->type != 4 && $this->depo->id != 0) && ($this->explora_depo->type == 4)) {
                $this->addError('depo', 'El depósito origen debe ser tipo expedición');
            }else{
               
                    $this->ingreso=new DepositInstallation;
                    $this->ingreso->warehouse_id=$this->deposito_id;
                    $this->ingreso->installation_id=$this->material_id;
                    $this->ingreso->serial_number=$this->serial_number;
                    $this->ingreso->number_version=$this->number_version;
                    $this->ingreso->client_order_id=$this->client_order_id;
                    $this->ingreso->date_admission=$this->date;
                    $this->ingreso->hour=$this->hour;
                    $this->ingreso->name_receive=$this->name_receive;
                    $this->ingreso->name_entry=$this->name_entry;
                    $this->ingreso->warehouse2_id=$this->depo->id;
                    $this->ingreso->amount+=1;
                    $this->ingreso->save();

                    $this->description=null;
                    $this->funcion="explora";
                    $this->selection='';
                    $this->resetValidation(); 
                    unset($this->details);
                    unset($this->depo);
                    $this->searchinstallation = '';
                    $this->serial_number=null;
                    $this->client_order_id=null;
                    $this->name_receive=null;
                    $this->depo_id=0;
                    $this->revi=false;
                    $this->name_entry=null;
            }
        }
        }elseif($this->funcion=="egreso"){
            $this->validate([
                'date' => 'required',
                'hour' => 'required',
                'depo_destino' => 'required',
                'name_receive' => 'required',
                'name_egress' => 'required',
                'selection' => 'required',
            ],
            [
                'date.required' => 'El campo Fecha es requerido',
                'hour.required' => 'El campo Hora es requerido',
                'name.max' => 'El campo Nombre tiene como maximo 100 caracteres',
                'name_receive.required' => 'El campo "Responsable de recibir" es requerido',
                'depo_destino.required' => 'Debe seleccionar un depósito destino',
                'name_egress.required' => 'El campo "Responsable de ingresar" es requerido',
                'selection.required' => 'Debe seleccionar una opción del tipo de producto a retirar'
            ]);
            
            if ($this->type == 1 || $this->type == 2 || $this->type == 3) {
                if ($this->explora_depo->type == 2 && ($this->depo_destino->type != 2)) {
                    $this->addError('depo_destino', 'El deposito destino debe ser tipo producción');
                }elseif($this->explora_depo->type == 3 && ($this->depo_destino->type == 1 || $this->depo_destino->type == 4)){
                    $this->addError('depo_destino', 'El deposito destino debe ser tipo producción o ensamblado');
                }elseif($this->explora_depo->type == 1 && ($this->depo_destino->type == 3 || $this->depo_destino->type == 4)){
                    $this->addError('depo_destino', 'El deposito destino debe ser tipo producción o almacen');
                }else{ 
    /*  
                $this->ordenegreso=new ExpendOrder;
                $this->ordenegreso->date_time=Carbon::now();
                $this->ordenegreso->state="Nuevo";
                $this->ordenegreso->user=$this->user;
                $this->ordenegreso->save();*/

                foreach($this->details as $detail){
                    $this->depositm=new DepositMaterial;
                    $this->depositm->material_id=$detail[4];
                    $this->depositm->warehouse_id=$detail[6];
                    $this->depositm->warehouse2_id=$detail[7];
                    $this->depositm->presentation=$detail[5];
                    $this->depositm->amount=-($detail[2]);
                    $this->depositm->date_change=$this->date;
                    $this->depositm->hour=$this->hour;
                    $this->depositm->name_receive=$this->name_receive;
                    $this->depositm->name_entry=$this->name_egress;
                    $this->depositm->is_material= ($this->type == 3 || $this->selection == 'Ensamblados') ? 0 : 1;
                    $this->depositm->type=0;
                    $this->depositm->save();
                }
                $this->amount=null;
                $this->presentation=null;
                $this->sta=null;
                $this->name_receive=null;
                $this->name_egress=null;
                $this->egreso=0;
                $this->destination=null;
                unset($this->depo_destino);
                unset($this->depo);
                unset($this->details);
                $this->funcion="explora";
                $this->resetValidation(); 
                $this->selection='';
            }
            }         
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
                $this->toingreso();
            }
        $this->select=false;
    }
    public function update(Warehouse $deposito)
    {
        $this->funcion="update";
        $this->deposito_id=$deposito->id;
        $this->name=$deposito->name;
        $this->location=$deposito->location;
        $this->state=$deposito->state;
        $this->create_date=$deposito->create_date;
        $this->descriptionw=$deposito->description;
        $this->temporary=$deposito->temporary;
    }

    public function explora(Warehouse $deposito)
    {
        $this->funcion="explora";
        $this->deposito_id=$deposito->id;
        $this->type=$deposito->type;
        $this->name=$deposito->name;
        $this->location=$deposito->location;
        $this->state=$deposito->state;
        $this->create_date=$deposito->create_date;
        $this->descriptionw=$deposito->description;
        $this->temporary = $deposito->temporary;
        $this->explora_depo = $deposito;
        if ($deposito->type == 3) {
            $this->selection = 'Ensamblados';
            $this->disabled = 'disabled';
        }
       
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
    public function selectmaterial(Material $material)
    {
        $this->material_id=$material->id;
        $this->descriptionm=$material->description;;
        $this->codem=$material->code;
        if ($this->funcion != 'createassembled' && $this->depo_id!=0) {
            $this->presentationm = $material->depositmaterials()->select('presentation', 'id')->where('warehouse_id', $this->depo->id)->groupBy('presentation')->get();
        }
      #  dd($this->presentationm);
        $this->dispatchBrowserEvent('show-form');
    }
    public function addmateriald()
    {
            $this->validate([
                'amount'=>'required|integer|min:1|max:1000000',
                'presentation'=> 'required',
            ], [
                'amount.required'=>'El campo Cantidad es requerido',
                'amount.integer' => 'El campo Cantidad tiene que ser un número entero',
                'amount.min' => 'El campo Cantidad es como mínimo 1(uno)',
                'amount.max' => 'El campo Cantidad es como máximo 1000000(un millon)',
                'presentation.required'=>'El campo Presentación es requerido',
            ]);
        foreach($this->details as $detail){
            if($detail[0]==$this->codem && $detail[5]==$this->presentation && $detail[6]==$this->deposito_id){
                $this->downmateriald($detail[3]);
            }        
        }  
        $this->detail[0]=$this->codem;
        $this->detail[1]=$this->descriptionm;
        $this->detail[2]=$this->amount;
        $this->detail[3]=$this->count;
        $this->detail[4]=$this->material_id;
        $this->detail[5]=$this->presentation;
        $this->detail[6]=$this->deposito_id;
        $this->detail[7]=(!empty($this->depo)) ? $this->depo->id : 0;

        $this->details[]=$this->detail;
        $this->count=$this->count+1;
        $this->amount=0;
        $this->presentation=0;
        $this->ingresa=false;
        $this->searchmateriales="";
        $this->dispatchBrowserEvent('hide-form');
    }
    public function downmateriald($orden)
    {
        unset($this->details[$orden]);
    }
    public function retiromaterial(Material $material)
    {
        $this->select=true;
        $this->codem=$material->code;
        $this->descriptionm=$material->description;
        $this->material_id=$material->id;
        $this->materials_presentation = $material->depositmaterials()->where('warehouse_id', $this->deposito_id)->where('is_material', 1)->groupBy('presentation')->get();
        
        $this->dispatchBrowserEvent('show-form');
        
    }

    public function egresomaterial()
    {
       
            foreach($this->details as $detail){
                if($detail[0]==$this->material_id && $detail[9]==$this->presentation){
                    $this->downegreso($detail[4]);
                }
            } 
            $this->validate([
                'egreso' => 'required|integer|min:1|max:'.$this->materials_amount["total"].'',
                'depo_destino' => 'required',
            ],[
                'egreso.required' => 'El campo Egreso es requerido',
                'egreso.integer' => 'El campo Egreso es entero',
                'egreso.min' => 'El campo Egreso tiene como mínimo 1(uno)',
                'egreso.max' => 'El campo Egreso excede la cantidad disponible',
                'depo_destino.required' => 'Debe seleccionar un depósito destino',
            ]);
         
            $this->detail[0]=$this->codem;
            $this->detail[1]=$this->descriptionm; 
            $this->detail[2]=$this->egreso;
            $this->detail[3]=$this->count;
            $this->detail[4]=$this->material_id;
            $this->detail[5]=$this->presentation;
            $this->detail[6]=$this->deposito_id;
            $this->detail[7]=$this->depo_destino->id;
            $this->detail[8]=$this->destination;
            $this->detail[9]=$this->materials_amount["total"];
            $this->details[]=$this->detail;
            $this->egreso=0;
            $this->count=$this->count+1;
            $this->select=false;
            unset($this->materials_amount);
            unset($this->presentation);
            $this->dispatchBrowserEvent('hide-form');
        
    }
    

    public function downegreso(int $algo)
    {
        unset($this->details[$algo]);
    }

    public function addassembled(Assembled $material)
    {
        $this->searchensamblados="";
        $this->material_id=$material->id;
        $this->description=$material->description;
        $this->dispatchBrowserEvent('show-form');
    }

    public function addassembledd()
    {
        $this->select=true;
        $this->dispatchBrowserEvent('hide-form');
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
       # dd($revision);
        $this->revisiones=Revision::where('installation_id', $revision->installation_id)->where('number_version', $revision->number_version)->get();
        $this->number_version=$revision->number_version;
        $this->revi=true;
      
    }

    public function downrevision()
    {
       # dd($this->revisiones);
        $this->revisiones=Revision::where('installation_id', $this->material_id)->get();
        $this->revi=false;
        $this->number_version=null;
    }

    public function ingreso()
    {   
        $this->date=Carbon::now()->format('Y-m-d');
        $this->hour=Carbon::now()->format('H:m');
        $this->funcion="ingreso";
    }
    public function selectdeposit(Warehouse $deposit)
    {
        $this->searchdeposito = '';
        $this->depo_id = $deposit->id;

        if ($this->funcion=='ingreso') {
            $this->depo=$deposit; 
        }else{
            $this->depo_destino=$deposit;
        }
        if ($deposit->type == 3) {
            $this->selection = 'Ensamblados';
            $this->disabled = 'disabled';
        }
      #  $this->materials_deposits = $this->depo->materials;
    }
    public function downdeposit(){
        unset($this->depo);
        unset($this->depo_destino);
        unset($this->depo_destino);
        $this->selection='';
        $this->materials_deposits = array();
        $this->ensamblados_deposits = array();
        $this->searchmaterialsdepo='';
        $this->details = array();
        $this->material_id=null;
        $this->description='';
        $this->amount=null;
        $this->depo_id=0;
        $this->disabled='';
    }
    
    public function egreso()
    {
        $this->date=Carbon::now()->format('Y-m-d');
        $this->hour=Carbon::now()->format('H:m');
        $this->depo=Warehouse::find($this->deposito_id); 
       $this->depo_id=$this->depo->id;
       # dd($this->materials_amount);
        $this->funcion="egreso";
    }

    public function retiros()
    {
        $this->funcion="retiros";

        $this->ordenegresodatail=DepositMaterial::where('warehouse_id',$this->deposito_id)->where('type',0)->get();
        #dd($this->ordenegresodatail[0]->warehouse2->name);
    }
    public function retiro_detail(DepositMaterial $retiro)
    {
        $this->funcion="retiro_detail";
        $this->retiro = $retiro;
        $this->ingresos = DepositMaterial::where('warehouse_id',$retiro->warehouse2_id)->where('warehouse2_id',$retiro->warehouse_id)->where('type',1)->where('material_id',$retiro->material_id)->where('presentation', $retiro->presentation)->where('amount',abs($retiro->amount))->get();
      #  dd($this->ingreso);
        #$this->retiros=DepositMaterial::find($oregreso->id);
     
    }
    public function toexplora()
    {
        $this->resetValidation();
        unset($this->depo_destino);
        unset($this->depo);
        unset($this->presentationm);
        $this->selection='';
        $this->searchmaterialsdepo='';
        $this->searchinstallation = '';
        $this->serial_number=null;
        $this->client_order_id=null;
        $this->sta=null;        
        $this->user=null;
        $this->revi=false;
        $this->seleccion="";
        $this->select=false;
        $this->amount=null;
        $this->presentation=null;
        $this->name_receive=null;
        $this->name_entry=null;
        $this->name_egress=null;
        $this->egreso=0;
        $this->destination=null;
        $this->funcion="explora";
        $this->modo=null;
        $this->details=null;
        $this->depo_id=0;
    }
    public function toingreso()
    {
        $this->resetValidation();
        $this->funcion="ingreso";
    }
    public function toretiros()
    {
        $this->funcion="retiros";
    }
    public function destruirdepo(Warehouse $deposito)
    {
        $this->dispatchBrowserEvent('show-borrar'); 
        $this->deposito_delete=$deposito;
    }
    public function delete()
    {
        $this->deposito_delete->delete();
        $this->dispatchBrowserEvent('hide-borrar');
        $this->dispatchBrowserEvent('deleted');
    }

    public function createassembled()
    {
        $this->funcion="createassembled";
    }

    public function addmateriall()
    {
        foreach($this->details as $detail){
            if($detail[0]==$this->codem){
                $this->downmaterial($detail[3]);
            }        
        }
        $this->detail[0]=$this->codem;
        $this->detail[1]=$this->descriptionm;
        $this->detail[2]=$this->amount;
        $this->detail[3]=$this->count;
        $this->detail[4]=$this->material_id;
        $this->details[]=$this->detail;
        $this->count=$this->count+1;
        $this->amount=0;
        $this->dispatchBrowserEvent('hide-form');
    }

    public function downmateriall($orden)
    {
        unset($this->details[$orden]);
    }

    public function explorabuyorder(BuyOrder $order)
    {   
        $this->buy_order_id=$order->id;
        $this->buyorderdetails=BuyOrderDetail::where('buy_order_id',$this->buy_order_id)->get();
        $this->modo="Con orden de compra";
        $this->funcion="createbo";
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
    public function volver()
    {
        $this->resetValidation();
        $this->reset();
    }
    public function amount(Material $material){
        $this->materials_amount = json_decode($material->depositmaterials()->where('warehouse_id', $this->deposito_id)->where('is_material',1)->where('presentation', $this->presentation)->select('presentation','material_id', DB::raw('SUM(amount) as total'))->groupBy('presentation')->first(), true);
      
    }
    public function retiroensamblado(Assembled $assembled)
    {
        $this->select=true;
        $this->descriptiona=$assembled->description;
        $this->assembled_id=$assembled->id;
        $this->assembled_amount =$assembled->depositmaterials()->where('warehouse_id',$this->deposito_id)->where('is_material',0)->select('material_id', DB::raw('SUM(amount) as total'))->groupBy('material_id')->first()->total;
        
        $this->dispatchBrowserEvent('show-form');
    }

    public function egresoensamblado()
    {
       
            foreach($this->details as $detail){
                if($detail[0]==$this->material_id && $detail[9]==$this->presentation){
                    $this->downegreso($detail[4]);
                }
            } 
            $this->validate([
                'egreso' => 'required|integer|min:1|max:'.$this->assembled_amount,
                'depo_destino' => 'required',
            ],[
                'egreso.required' => 'El campo Egreso es requerido',
                'egreso.integer' => 'El campo Egreso es entero',
                'egreso.min' => 'El campo Egreso tiene como mínimo 1(uno)',
                'egreso.max' => 'El campo Egreso excede la cantidad disponible',
                'depo_destino.required' => 'Debe seleccionar un depósito destino',
            ]);
    

            $this->detail[0]=$this->descriptiona;
            $this->detail[1]=$this->descriptiona;
            $this->detail[2]=$this->egreso;
            $this->detail[3]=$this->count;
            $this->detail[4]=$this->assembled_id; 
            $this->detail[5]=1; 
            $this->detail[6]=$this->deposito_id;
            $this->detail[7]=$this->depo_destino->id;
            $this->detail[8]=$this->destination;
            $this->detail[9]=$this->assembled_amount;
            $this->details[]=$this->detail;
            $this->egreso=0;
            $this->count=$this->count+1;
            $this->select=false;
            unset($this->assembled_amount);
            $this->egreso=null;
            $this->dispatchBrowserEvent('hide-form');
        
    }
}
