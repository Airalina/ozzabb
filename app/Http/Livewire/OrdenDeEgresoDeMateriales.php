<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Material;
use App\Models\Assembled;
use App\Models\Installation;
use App\Models\Warehouse;
use App\Models\MaterialReleaseOrder;
use App\Models\MaterialReleaseOrderDetail;
use App\Models\DepositMaterial;
use App\Models\DepositInstallation;
use Livewire\WithPagination;
use Carbon\Carbon;
use DB;

class OrdenDeEgresoDeMateriales extends Component
{
    use WithPagination;
   
    protected $paginationTheme = 'bootstrap';
    protected $orders, $paginas_internas=10;
    public $funcion = '', $paginas=25, $search='', $order='code', $modo = 'Sin pedido', $searchdeposito = '', $depo, $depo_id, $selection, $disabled='', $deposits, $searchensamblados = '', $searchinstalaciones = '', $installation;
    public $date, $hour, $destination, $products, $responsible, $materials = array(), $details = array(), $detail = array(), $product, $searchmateriales = '', $searchassembleds = '', $searchinstallations = '', $amount, $amounts = array(), $presentations = array(); 
    public $id_m, $code_m, $description_m, $presentation_m, $material, $depositmaterials, $material_count = 0, $assembled_count = 0, $installation_count = 0, $amount_units = 0, $product_select, $product_type, $material_release_order_id, $material_release_order;

    public function render()
    {
        $type = ($this->order == 'date') ? 'desc' : 'asc';
        $fecha = date('Y-m-d', strtotime($this->search));
        
        $this->orders=MaterialReleaseOrder::where('code','LIKE','%' . $this->search . '%')
        ->orWhere('date','LIKE','%'.$fecha.'%')
        ->orWhere('hour','LIKE','%'.$this->search.'%')
        ->orWhere('destination','LIKE','%'.$this->search.'%')
        ->orWhere('responsible','LIKE','%'.$this->search.'%')
        ->orWhere('products','LIKE','%'.$this->search.'%')
        ->orWhere('units','LIKE','%'.$this->search.'%')
        ->orWhere('status','LIKE','%'.$this->search.'%')
        ->orderBy($this->order, $type)->paginate($this->paginas);

        /*$this->deposits=Warehouse::where('id','LIKE','%'.$this->searchdeposito.'%')
        ->orWhere('name','LIKE','%'.$this->searchdeposito.'%')
        ->orWhere('location','LIKE','%'.$this->searchdeposito.'%')
        ->orWhere('description','Like','%'.$this->searchdeposito.'%')
        ->orWhere('create_date', 'LIKE','%'.$this->searchdeposito.'%')
        ->orWhere('temporary','LIKE','%'.$this->searchdeposito.'%')->get();*/


        switch ($this->selection) {
            case 'Materiales':
                $this->product = 'materiales';
                $this->products = Material::where('code','like','%'.$this->searchmateriales.'%')
                ->orWhere('name','LIKE','%'.$this->searchmateriales.'%')
                ->orWhere('family','LIKE','%'.$this->searchmateriales.'%')
                ->orWhere('color','LIKE','%'.$this->searchmateriales.'%')
                ->orWhere('description','LIKE','%'.$this->searchmateriales.'%')
                ->orWhere('stock_min','LIKE','%'.$this->searchmateriales.'%')
                ->orWhere('stock_max','LIKE','%'.$this->searchmateriales.'%')
                ->orWhere('stock','LIKE','%'.$this->searchmateriales.'%')->get();
                break;
            case 'Ensamblados':
                $this->product = 'ensamblados';
                $this->products =Assembled::where('id','like','%'.$this->searchensamblados.'%')
                ->orWhere('description','LIKE','%'.$this->searchensamblados.'%')->get();
                break;
            case 'Instalaciones':
                $this->product = 'instalaciones';
                $this->products =Installation::where('id','LIKE','%' .$this->searchinstalaciones. '%')
                ->orWhere('code','LIKE','%'.$this->searchinstalaciones.'%')
                ->orWhere('description','LIKE','%'.$this->searchinstalaciones.'%')->get();
                break;
        }



        if (!empty($this->depo)) {
          
            /*  $this->materials = $this->depo->materials()->where('is_material',1)->groupBy('id')->where(function ($query) {
                  $query->where('code','like','%'.$this->searchmateriales.'%')
                  ->orWhere('name','LIKE','%'.$this->searchmateriales.'%')
                  ->orWhere('family','LIKE','%'.$this->searchmateriales.'%')
                  ->orWhere('color','LIKE','%'.$this->searchmateriales.'%')
                  ->orWhere('description','LIKE','%'.$this->searchmateriales.'%')
                  ->orWhere('stock_min','LIKE','%'.$this->searchmateriales.'%')
                  ->orWhere('stock_max','LIKE','%'.$this->searchmateriales.'%')
                  ->orWhere('stock','LIKE','%'.$this->searchmateriales.'%');
              })->get();*/
             # $depositmaterials = $this->material->depositmaterials()->where('is_material', 1)->where('warehouse_id', $this->depo->id)->groupBy('presentation')->get();
             if ($this->product == 'instalaciones') {
                $this->amounts[1] = $this->product_select->depositinstallations()->where('warehouse_id', $this->depo->id)->first()->amount;
            } else {
                $ismmaterial = ($this->product == 'materiales') ? 1 : 0;

                $this->depositmaterials =  $this->product_select->depositmaterials()->where('is_material',$ismmaterial)->select('id','presentation','material_id', DB::raw('SUM(amount) as
                total'))->where('warehouse_id', $this->depo->id)->groupBy('presentation')->get();
    
                foreach ($this->depositmaterials as $depositmaterial) {
                    $this->presentations[$depositmaterial->presentation] = $depositmaterial->presentation;
                    $this->amounts[$depositmaterial->presentation] = $depositmaterial->total;
                }
            }
            

          }



        return view('livewire.orden-de-egreso-de-materiales',[
            'orders' => $this->orders,
        ]);
    }

    public function create()
    {   
        $this->date=Carbon::now()->format('Y-m-d');
        $this->hour=Carbon::now()->format('H:m');
        $this->funcion="create";
    }
    public function updating(){
        if (!empty($this->product_select)) {
            if ($this->selection == 'Instalaciones') {
                    $this->deposits=$this->product_select->warehouses()->groupBy('id')->where(function ($query) {
                        $query->where('warehouses.id','LIKE','%'.$this->searchdeposito.'%')
                        ->orWhere('warehouses.name','LIKE','%'.$this->searchdeposito.'%')
                        ->orWhere('warehouses.location','LIKE','%'.$this->searchdeposito.'%')
                        ->orWhere('warehouses.description','Like','%'.$this->searchdeposito.'%')
                        ->orWhere('warehouses.create_date', 'LIKE','%'.$this->searchdeposito.'%')
                        ->orWhere('warehouses.temporary','LIKE','%'.$this->searchdeposito.'%');
                    })->get();
            }else{
                $ismmaterial = ($this->product == 'materiales') ? 1 : 0;
                $this->deposits=$this->product_select->warehouses()->where('is_material', $ismmaterial)->groupBy('id')->where(function ($query) {
                    $query->where('warehouses.id','LIKE','%'.$this->searchdeposito.'%')
                    ->orWhere('warehouses.name','LIKE','%'.$this->searchdeposito.'%')
                    ->orWhere('warehouses.location','LIKE','%'.$this->searchdeposito.'%')
                    ->orWhere('warehouses.description','Like','%'.$this->searchdeposito.'%')
                    ->orWhere('warehouses.create_date', 'LIKE','%'.$this->searchdeposito.'%')
                    ->orWhere('warehouses.temporary','LIKE','%'.$this->searchdeposito.'%');
                })->get();
            }

        }
    }
    public function selectdeposit(Warehouse $deposit)
    {
        $this->searchdeposito = '';
        $this->depo_id = $deposit->id;
        $this->depo = $deposit;
        /*$depositmaterials = $this->material->depositmaterials()->where('is_material', 1)->where('is_material', 1)->groupBy('presentation')->get();
        
        foreach ($depositmaterials as $depositmaterial) {
            $this->presentations[] = $depositmaterial->presentation;
        }*/

      #  $this->materials_deposits = $this->depo->materials;
    }
    public function downdeposit(){
        unset($this->depo);
        $this->selection='';

        $this->presentations = array();
        $this->presentation_m = '';
       /* $this->materials_deposits = array();
        $this->ensamblados_deposits = array();
        $this->searchmaterialsdepo='';
        $this->details = array();
        $this->material_id=null;
        $this->description='';
        $this->amount=null;
        $this->depo_id=0;*/
        $this->disabled='';
    }

    public function selectensamblados(Assembled $assembled){

        $this->id_m = $assembled->id;
        $this->code_m=$assembled->id;
        $this->description_m=$assembled->description;
        $this->product_select = $assembled;
        $this->resetValidation();
        $this->dispatchBrowserEvent('show-form');
    }

    public function selectinstalaciones(Installation $installation){

        $this->id_m = $installation->id;
        $this->code_m=$installation->code;
        $this->description_m=$installation->description;
        $this->product_select = $installation;
        $this->installation = $installation;
        $this->resetValidation();
        $this->dispatchBrowserEvent('show-form');
    }

    public function selectmateriales(Material $material){
        $this->id_m = $material->id;
        $this->code_m=$material->code;
        $this->description_m=$material->description;
        $this->product_select = $material;
        $this->resetValidation();
        $this->dispatchBrowserEvent('show-form');
    }

    public function change_amount(){
     
    foreach ($this->depositmaterials as $depositmaterial) {
       $this->amounts[$depositmaterial->presentation] = $depositmaterial->total;
    }

    }
    public function addproduct()
    {
         $val = ($this->product == 'materiales') ? 'required' : 'nullable';
         $this->validate([
            'presentation_m' =>  $val.'|integer|min:1|max:1000000',
            'depo' => 'required'
        ],[
            'presentation_m.required' => 'Seleccione una opción del campo "Presentación"',
            'depo.required' => 'Seleccione una opción del campo "Deposito"'
        ]);

         $type = ($this->product == 'materiales') ? 'Material' : ($this->product == 'ensamblados' ? 'Ensamblado' : 'Instalación');
         $max = (!empty($this->amounts)) ? (($this->product == 'materiales') ? $this->amounts[$this->presentation_m] : $this->amounts[1]) : '';

           $this->validate([
                'amount' => 'required|integer|min:1|max:'.$max,
            ],[
                'amount.required' => 'El campo "Cantidad" es requerido',
                'amount.integer' => 'El campo "Cantidad" debe ser un entero',
                'amount.min' => 'El campo "Cantidad" debe ser como mínimo 1(Uno)',
                'amount.max' => 'El campo "Cantidad" excede la cantidad disponible de '.$max,
            ]);
          
            $this->detail['id']=$this->product_select->id;
            $this->detail['warehouse_id']=$this->depo->id;
            $this->detail['amount']=$this->amount;
            $this->detail['presentation']=$this->presentation_m;
            $this->detail['code']=(!empty($this->product_select->code)) ? $this->product_select->code : $this->product_select->id;
            $this->detail['description']=$this->product_select->description;
            $this->detail['warehouse_name']=$this->depo->name;
            $this->detail['type']=$type;

            $this->details[$this->product][$this->product_select->id]=$this->detail;
            
            switch ($this->product) {
                case 'materiales':
                    $this->material_count++;
                    $this->amount_units += $this->amount * $this->presentation_m;
                    break;
                case 'ensamblados':
                    $this->assembled_count++;
                    $this->amount_units += $this->amount;
                    break;
                case 'instalaciones':
                    $this->installation_count++;
                    $this->amount_units += $this->amount;
                    break;        
                
            }

            $this->presentations = array();
            $this->deposits = array();
            unset($this->depo);
            $this->amount = 0;
            $this->searchdeposito='';
            $this->searchensamblados='';
            $this->searchmateriales='';
            $this->searchinstalaciones='';
            $this->presentation_m = '';
            unset($this->product_select);
            $this->amounts = array(); 
            $this->resetValidation();
            $this->dispatchBrowserEvent('hide-form');
    }

    public function backmodal(){
        $this->presentations = array();
        $this->amounts = array(); 
        $this->deposits = array();
        unset($this->depo);
        $this->amount = 0;
        $this->searchdeposito='';
        $this->searchensamblados='';
        $this->searchmateriales='';
        $this->searchinstalaciones='';
        $this->presentation_m = '';
        unset($this->product_select);
        $this->dispatchBrowserEvent('hide-form');
    }

    public function downproduct($index,$type ,$amount)
    {
        unset($this->details[$type][$index]);

        switch ($type) {
            case 'materiales':
                $this->material_count--;
                break;
            case 'ensamblados':
                $this->assembled_count--;
                break;
            case 'ensamblados':
                $this->installation_count--;
                break;        
            
        }
        $this->amount_units -= $amount;
    }


    public function store()
    {
        $this->validate([
            'destination'=>'required',
            'responsible'=>'required',
            'date'=>'required',
            'hour'=>'required',
            'details'=>'required',
        ], [
            'destination.required'=>'El campo "Destino" es requerido',
            'responsible.required'=>'El campo "Responsable" es requerido',
            'date.required'=>'El campo "Fecha" es requerido',
            'hour.required'=>'El campo "Hora" es requerido',
            'details.required'=>'Debe agregar por lo menos un (1) producto',
        ]);

        if($this->modo=="Sin pedido"){
 
            $products  =  $this->material_count +  $this->assembled_count +  $this->installation_count;
            $orden=new MaterialReleaseOrder;
            $orden->destination=$this->destination;
            $orden->hour=$this->hour;
            $orden->responsible=$this->responsible;
            $orden->date=$this->date;
            $orden->status=1;
            $orden->products = $products;
            $orden->units=$this->amount_units;
            $orden->save();
            $orden->code=$orden->id."/".date('Y', strtotime($this->date));
            $orden->save();

            foreach($this->details as $type => $product_type){
                foreach ($product_type as $detail) {
                    
                    if ($type == 'instalaciones') {
                        $depositm=DepositInstallation::where('installation_id',$detail['id'])->where('warehouse_id', $detail['warehouse_id'])->first();
                     
                        $depositm->warehouse_id=$detail['warehouse_id'];
                        $depositm->name_receive='orden de egreso';
                        $depositm->name_entry='orden de egreso';
                        $depositm->amount-=1;
                        $depositm->save();
                    }else{
                        $depositm=new DepositMaterial;
                        $depositm->material_id= $detail['id']; 
                        $depositm->warehouse_id=$detail['warehouse_id']; 
                        $depositm->warehouse2_id=0; 
                        $depositm->presentation= ($type == 'materiales') ? $detail['presentation'] : 1; 
                        $depositm->amount=-($detail['amount']); 
                        $depositm->date_change=$this->date;
                        $depositm->hour=$this->hour;
                        $depositm->name_receive=$this->responsible;
                        $depositm->name_entry='orden de egreso';
                        $depositm->is_material=($type == 'materiales') ? 1 : 0; 
                        $depositm->type=0;
                        $depositm->save();
                    }
                    
                    $detailem=new MaterialReleaseOrderDetail;
                    $detailem->material_release_order_id=$orden->id;
                    $detailem->product_id=$detail['id'];
                    $detailem->warehouse_id=$detail['warehouse_id'];
                    $detailem->presentation=($type == 'materiales') ? $detail['presentation'] : 0;
                    $detailem->amount=$detail['amount'];
                    $detailem->type=$detail['type'];
                    $detailem->save();
                    
                    if ($detailem->type == 'materiales') {
                        $smaterial=Material::where('id', $detailem->product_id)->first();
                        $smaterial->stock-=$detailem->amount*$detailem->presentation;
                        $smaterial->save();
                    }
                   
                }
            }      
        }
        $this->modo="";
        $this->funcion="";
        $this->function="";
        $this->resetValidation();
        
        return redirect()->to('/ordenes-de-egreso-de-materiales');
    }

    public function volver(){
        $this->reset();
        $this->resetValidation();
    }

    public function explora(MaterialReleaseOrder $order)
    {  
        $this->material_release_order_id= $order->id;
        #$this->entry_order_type=$order->origin;
        $this->destination=$order->destination;
        $this->responsible=$order->responsible;
        $this->follow=$order->follow_number;
        $this->status=$order->status;
        $this->date=date("Y-m-d",strtotime($order->date));
        $this->hour=$order->hour;
        $this->code=$order->code;
        
        foreach ($order->materialreleaseorderdetails as $productdetail) {

            if ($productdetail->type == 'Material') {
                $type = 'material';
                $prod = 'Material';
            } elseif($productdetail->type == 'Ensamblado') {
                $type = 'assembled';
                $prod = 'Ensamblado';
            }else{
                $type = 'installation';
                $prod = 'Insalación';
            }
            if (isset($productdetail->$type->id) && isset($productdetail->warehouse->id)) {
                $this->detail['id']=$productdetail->product_id;
                $this->detail['warehouse_id']=$productdetail->warehouse_id;
                $this->detail['amount']=$productdetail->amount;
                $this->detail['presentation']=(empty($productdetail->presentation)) ? null : $productdetail->presentation;
                $this->detail['code']=($productdetail->type == 'Ensamblado') ? $productdetail->product_id : $productdetail->$type->code;
                $this->detail['description']=$productdetail->$type->description;
                $this->detail['warehouse_name']=$productdetail->warehouse->name;
                $this->detail['type']=$prod;
    
                $this->details[$productdetail->type][$productdetail->product_id]=$this->detail;
            }

        }

        $this->funcion="explora";
    }

    public function aviso(MaterialReleaseOrder $order){
        $this->material_release_order=$order;
        $this->dispatchBrowserEvent('show-cancel');
    }

    public function cancelar(){
      
            $this->material_release_order->status=0;
            $this->material_release_order->save();

        foreach($this->material_release_order->materialreleaseorderdetails as $detail){        
                
                if ($detail->type == 'Instalación') {
                    $depositm=DepositInstallation::find($detail->product_id);
                    $depositm->amount+=1;
                    $depositm->save();
                }else{
                    $depositm=new DepositMaterial;
                    $depositm->material_id= $detail->product_id; 
                    $depositm->warehouse_id=$detail->warehouse_id; 
                    $depositm->warehouse2_id=0; 
                    $depositm->presentation= ($detail->type == 'Material') ? $detail->presentation : 1; 
                    $depositm->amount=$detail->amount; 
                    $depositm->date_change=Carbon::now()->format('Y-m-d');
                    $depositm->hour=Carbon::now()->format('H:i:s');
                    $depositm->name_receive=$this->material_release_order->responsible;
                    $depositm->name_entry='orden de egreso';
                    $depositm->is_material=($detail->type == 'Material') ? 1 : 0; 
                    $depositm->type=1;
                    $depositm->save();
                }
            }

            $this->dispatchBrowserEvent('hide-cancel');
            $this->dispatchBrowserEvent('cancel');
          
        }

}
