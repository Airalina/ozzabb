<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Workorder;
use App\Models\ClientorderWorkorder;
use App\Models\WorkorderDetail;
use App\Models\Clientorder;
use App\Models\Material;
use App\Models\Provider;
use App\Models\DepositMaterial;
use App\Models\DepositInstallation;
use App\Models\Warehouse;
use App\Models\ReservationMaterial;
use App\Models\ReservationDeposit;
use App\Models\PucharsingSheet;
use App\Models\PucharsingSheetDetail;
use App\Models\PucharsingSheetOrder;
use App\Models\BuyOrderDetail;
use App\Models\BuyOrder;
use App\Models\Assembled;
use App\Models\AssembledDetail;
use App\Models\Installation;
use App\Models\Revision;
use App\Models\RevisionDetail;
use Carbon\Carbon;
use DB;

class WorkOrders extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $workorders;
    public $funcion='',$search='',$paginas=25;
    public $code, $start_date, $end_date, $hours, $man, $state, $searchpedido = '', $searchdeposito = '', $orders, $status, $work_man;
    public $work_hours, $clientorder, $clientorders = array(), $materialcount=0, $prueba=0, $ordenes = array();
    public $countordenes, $instalaciones = array(), $hours_man, $hours_man_avaiable, $days=5, $hours_man_required; 
    public $workorder, $clientorder_workorder, $workorder_detail, $div_order, $workorder_code, $workorder_materials = array();
    public $workorder_state, $disabled = '', $material_code, $material_description, $material_deposits = array();
    public $type_reservation = '', $material_id, $deposits = array(), $presentations = array(), $amounts = array(), $mat, $presentation_selected, $amount_presentation = array(), $amount_deposit = array(), $amount_saved = array();
    public $reservation = array(), $reservation_deposit, $material, $normal_reservation, $amount_required, $normal_deposit = array(), $type, $last, $presentation = array(), $total = array();
    public $eq_reservation, $clientworkorders, $purchasings  = array (), $providers = array(), $proveedor_selected, $provider_presentations = array(), $presentationm, $usd_price, $ars_price;
    public $amount, $unit, $subtotal = 0, $total_price, $iva = 0, $materials = array(), $searchmaterial="", $reservations = array(), $orden, $orden_id, $orden_date, $selection, $depo, $depo_id, $depo_name, $depo_description, $depo_type;
    public $searchensamblados = '', $assembleds = array(), $ensamblados = array(), $assembled, $assembled_id, $assembled_description, $assembled_date, $details = array(), $detail = array(), $count = 0, $installations = array(), $installation_id, $installation_code, $installation_description, $searchinstalaciones = '', $installation_usd_price, $installation_hours_man, $installation_date, $depo_instalacion_id, $depo_instalacion, $depo_instalacion_name, $depo_instalacion_description, $depo_instalacion_type, $depo_ensamblado_id, $depo_ensamblado, $depo_ensamblado_name, $depo_ensamblado_description, $depo_ensamblado_type, $pucharsings = array(), $pucharsing = array(), $filtro = '', $type_state, $from, $to;

    public function render()
    {
        

        if ($this->filtro == 'Estado') {
            $this->workorders=Workorder::where('state', $this->type_state)->orderBy('state')->where(function ($query) {
                $query->where('code','LIKE','%' . $this->search . '%')
                ->orWhere('state','LIKE','%'.$this->search.'%')
                ->orWhere('start_date','LIKE','%'.$this->search.'%')
                ->orWhere('end_date','LIKE','%'.$this->search.'%');
            })->paginate($this->paginas);
        }elseif ($this->filtro == 'Fechas') {
            $this->workorders=Workorder::whereBetween('start_date', [$this->from, $this->to])->where(function ($query) {
                $query->where('code','LIKE','%' . $this->search . '%')
                ->orWhere('state','LIKE','%'.$this->search.'%')
                ->orWhere('start_date','LIKE','%'.$this->search.'%')
                ->orWhere('end_date','LIKE','%'.$this->search.'%');
            })->paginate($this->paginas);
        }else{
            $this->workorders=Workorder::where('code','LIKE','%' . $this->search . '%')
            ->orWhere('state','LIKE','%'.$this->search.'%')
            ->orWhere('start_date','LIKE','%'.$this->search.'%')
            ->orWhere('end_date','LIKE','%'.$this->search.'%')
            ->paginate($this->paginas);
        }
        $this->hours_man_avaiable = (!empty($this->hours) && !empty($this->man)) ? $this->hours*$this->man : null;
        $from = (!empty($this->start_date)) ? date($this->start_date) : '';
        $to = (!empty($this->end_date)) ? date($this->end_date) : '';
        
        if (!empty($this->hours) && !empty($this->man)) {
            $workdays = ($this->hours/8);
         #   $this->end_date = date("Y-m-d",strtotime($this->start_date.'+'.$workdays.' day')); 
        }
        switch ($this->searchpedido) {
            case 'nuevo':
                $this->status = 1;
                break;
            case 'confirmado':
                $this->status = 2;
                break;
            case 'produccion':
                $this->status = 5;
                break;
            case 'deposito':
                $this->status = 6;
                break;        
        }
        $this->orders= Clientorder::whereBetween('deadline', [$this->start_date, $this->end_date])->whereNotIn('order_state',[3,4,7])->where(function ($query) {
            $query->where('id','LIKE','%'.$this->searchpedido.'%')
            ->orWhere('customer_name','LIKE','%'.$this->searchpedido.'%')
            ->orWhereYear('deadline', $this->searchpedido)
            ->orWhereMonth('deadline', $this->searchpedido)
            ->orWhere('order_state', $this->status);
        })->get();
        $this->materials = Material::where('code','like','%'.$this->searchmaterial.'%')
        ->orWhere('name','LIKE','%'.$this->searchmaterial.'%')
        ->orWhere('family','LIKE','%'.$this->searchmaterial.'%')
        ->orWhere('color','LIKE','%'.$this->searchmaterial.'%')
        ->orWhere('description','LIKE','%'.$this->searchmaterial.'%')
        ->orWhere('replace_id','LIKE','%'.$this->searchmaterial.'%')->get();
        
        if (!empty($this->material_id)) {
            $material = Material::find($this->material_id);
            $this->material_deposits = $material->depositmaterials()->where('is_material',1)->groupBy('warehouse_id')->get();
                 
            switch (strtolower($this->searchdeposito)) {
                case 'almacen':
                    $this->type = 1;
                    break;
                case 'produccion':
                    $this->type = 2;
                    break;       
            }
            $this->normal_deposit = $material->warehouses()->whereIn('warehouses.type',[1,2])->groupBy('id')->where(function ($query) {
                $query->where('warehouses.id','LIKE','%'.$this->searchdeposito.'%')
                ->orWhere('warehouses.name','LIKE','%'.$this->searchdeposito.'%')
                ->orWhereYear('warehouses.description', $this->searchdeposito)
                ->orWhereMonth('warehouses.location', $this->searchpedido)
                ->orWhere('warehouses.type', $this->type);
            })->get();
            foreach ($this->material_deposits as $materialdeposit) {
               $this->presentations[$material->id][$materialdeposit->warehouse_id] = $material->depositmaterials()->where('is_material',1)->where('warehouse_id', '=', $materialdeposit->warehouse_id)->groupBy('presentation')->get();
                $this->amounts[$material->id][$materialdeposit->warehouse_id] = $material->depositmaterials()->select('presentation','material_id', DB::raw('SUM(amount) as
                total'))->where('warehouse_id', '=', $materialdeposit->warehouse_id)->groupBy('presentation')->get(); 
            }
           
        }

        if (!empty($this->selection)) {
            if ($this->selection == 'Ensamblados') {
                $this->deposits = Warehouse::whereIn('type',[3])->where(function ($query) {
                    $query->where('id','LIKE','%'.$this->searchdeposito.'%')
                    ->orWhere('name','LIKE','%'.$this->searchdeposito.'%')
                    ->orWhereYear('description', $this->searchdeposito)
                    ->orWhereMonth('location', $this->searchpedido)
                    ->orWhere('type', $this->searchpedido);
                })->get();
                $this->ensamblados = Assembled::where('id','like','%'.$this->searchensamblados.'%')
                ->orWhere('description','LIKE','%'.$this->searchensamblados.'%')->get();
            }elseif ($this->selection == 'Instalaciones') {
                $this->deposits = Warehouse::whereIn('type',[4])->where(function ($query) {
                    $query->where('id','LIKE','%'.$this->searchdeposito.'%')
                    ->orWhere('name','LIKE','%'.$this->searchdeposito.'%')
                    ->orWhereYear('description', $this->searchdeposito)
                    ->orWhereMonth('location', $this->searchpedido)
                    ->orWhere('type', $this->searchpedido);
                })->get();
                $this->instalaciones = Installation::where('id','LIKE','%' .$this->searchinstalaciones. '%')
                ->orWhere('code','LIKE','%'.$this->searchinstalaciones.'%')
                ->orWhere('description','LIKE','%'.$this->searchinstalaciones.'%')->get();
            }
        }
            $this->total_price = $this->subtotal+($this->subtotal*($this->iva/100));
    
        return view('livewire.work-orders',[
            'workorders' => $this->workorders,
        ]);
    }

    public function create()
    {
        $this->funcion="crear";
        $this->start_date=Carbon::now()->format('Y-m-d');
    }
    
    public function addorder(Clientorder $order){
                if (!isset($this->ordenes[$order->id]) || $this->funcion == "sheet") {
                    $this->ordenes[$order->id] = $order;
                    foreach($order->orderdetails as $detailorder){
                        foreach($detailorder->installations as $installation){
                            $this->instalaciones[$installation->id]['hours_man'] = (empty($this->instalaciones[$installation->id])) ? 0 : $this->instalaciones[$installation->id]['hours_man'];  
                            $this->instalaciones[$installation->id]['hours_man']+=$installation->hours_man*$detailorder->cantidad;
                           
                            $countrevision=$installation->revisions->count()-1;
                            $revision=$installation->revisions()->orderBy('number_version','desc')->first();
                            foreach($installation->revisiondetails as $revisiondetail){
                                $material=$revisiondetail->materials;
                                
                                if (!isset($this->clientorders[$material->id])) {
                                    foreach($this->clientorders as $order){
                                        if($order[1]==$material->code)
                                        {
                                            $this->prueba=$order[5];
                                            #unset($this->clientorders[$order[0]]);
                                        }
                                    }
                                    $this->clientorder[0]=$this->materialcount;
                                    $this->clientorder[1]=$material->code;
                                    $this->clientorder[2]=$material->description;
                                    $this->clientorder[3]=$material->stock;
                                    $this->clientorder[4]=$material->stock_transit;
                                    $this->clientorder[5]=$this->prueba+$revisiondetail->amount*$detailorder->cantidad;
                                    $this->clientorder[6]=0;
                                    $this->clientorder[7]=0;
                                    $this->clientorder[8]=0;
                                    $this->clientorder[9]=0;
                                    $this->clientorder[10]="";
                                    $this->clientorder[11]=0;
                                    $this->clientorder[12]=$material->id;
                                    $this->clientorders[$material->id]=$this->clientorder;
                                    
                                    $this->materialcount++;
                                    $this->prueba=0;
                                }else{
                                  #  dd($this->clientorders);
                                    $this->clientorders[$material->id][5]+=$revisiondetail->amount*$detailorder->cantidad;
                                }
                                   
                            }
                        }
                    }  
                   $this->hours_man = array_sum(array_column($this->instalaciones, 'hours_man'));
                   
                } else {
                    $this->addError('order', 'El pedido se encuentra seleccionado');
                }
        } 
    public function save(){
        $this->validate([
            'code' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'hours' => 'required|numeric',
            'man' => 'required|integer',
            'ordenes' => 'required',
        ], [
            'code.required' => 'El campo código es requerido',
            'start_date.required' => 'El campo fecha de inicio es requerido',
            'end_date.required' => 'El campo fecha de finalización es requerido',
            'hours.required' => 'El campo horas disponibles es requerido',
            'hours.numeric' => 'El campo horas disponibles debe ser numérico',
            'man.required' => 'El campo empleados disponibles es requerido',
            'man.integer' => 'El campo empleados disponibles debe ser un número entero',
            'ordenes.required' => 'Seleccione un pedido',
        ]);
        
        $this->workorder= new Workorder;
        $this->workorder->code=$this->code;
        $this->workorder->start_date=$this->start_date;
        $this->workorder->end_date=$this->end_date;
        $this->workorder->hours=$this->hours;
        $this->workorder->man=$this->man;
        $this->workorder->hours_man_required=$this->hours_man;
        $this->workorder->state='Nueva';
        $this->workorder->save();

        foreach($this->ordenes as $orden){
            $this->clientorder_workorder= new ClientorderWorkorder;
            $this->clientorder_workorder->workorder_id=$this->workorder->id;
            $this->clientorder_workorder->clientorder_id=$orden['id'];
            $this->clientorder_workorder->save();
        }
        foreach($this->clientorders as $clientorder){
            if($clientorder[5]>0){
                $this->workorder_detail=new WorkorderDetail;
                $this->workorder_detail->workorder_id=$this->workorder->id;
                $this->workorder_detail->material_id=$clientorder[12];
                $this->workorder_detail->amount=$clientorder[5];
                $this->workorder_detail->save();
            }
        }
        $this->reset();
        $this->resetValidation();
        $this->funcion="";
    }
    public function explora(Workorder $workorder){
        
        $orders = $workorder->workorder_orders;
        $details = $workorder->workorder_details;
        $this->workorder = $workorder;
        $this->start_date = date("Y-m-d",strtotime($workorder->start_date));
        $this->end_date = date("Y-m-d",strtotime($workorder->end_date));
        $this->code = $workorder->code;
        $this->hours = $workorder->hours;
        $this->man = $workorder->man;
        $this->hours_man_avaiable =  $workorder->hours *  $workorder->man;
        $this->hours_man = $workorder->hours_man_required;
        $workorder_actual = Workorder::where('state','Actual')->orWhere('state','Actual con pedidos cancelados')->first();
    
        $this->disabled = ($workorder->state != 'Nueva' || isset($workorder_actual)) ? 'disabled' : '';

        foreach ($orders as $order) {
            $this->ordenes[$order->clientorder_id]=$order->clientorder;
        }
        foreach ($details as $detail) {
            $this->reservations = $this->workorder->reservationmaterials()->select('presentation','material_id', DB::raw('SUM(amount) as
            total'))->where('material_id',$detail->material->id)->groupBy('presentation')->get();
            foreach ($this->reservations as $index => $reservation) {
                $presentation[$detail->material->id][$reservation->presentation] = $reservation->presentation;
                $total[$detail->material->id][$reservation->presentation]= $reservation->total;
            }
         
               $this->workorder_materials[$detail->material->id]= array(
                0 => $detail->material->id,
                1 => $detail->material->code,
                2 => $detail->material->description,
                3 => $detail->material->stock,
                4 => $detail->material->stock_transit,
                5 => $detail->amount,
                6 => (!empty($presentation[$detail->material->id])) ? $presentation[$detail->material->id] : 0,
                7 => (!empty($total[$detail->material->id])) ? $total[$detail->material->id] : 0,
            );
           
            
        }
        
      #  dd($this->presentation);
       $this->funcion="explora";
     }

     public function back(){
        $this->reset();
        $this->resetValidation();
    }

    public function change_state(Workorder $workorder, $state){
        $workorder->state = ''.$state.'';
        $workorder->save();
        return $this->explora($workorder);
        #$this->emit('refreshState', $workorder);
    }

    public function reservar(Material $material){
        unset($this->type_reservation);
        $this->deposits = array();

        $this->material_code = $material->code;
        $this->material_description = $material->description;
        $this->material_id = $material->id;
        $this->material = $material;
       # $this->material_deposits = $material->depositmaterials()->where('is_material',1)->get();
        
        $this->dispatchBrowserEvent('show-form');
        #dd($this->material_deposits);
    }
    public function change_reservation(){
        $almacen = 0;
        $this->deposits = array();
        switch ($this->type_reservation) {
            case 'Normal':
                $this->normal_reservation = $this->material->depositmaterials()->select('id','warehouse_id','presentation','material_id', DB::raw('SUM(amount) as
                total'))->where('is_material',1)->groupBy('presentation','warehouse_id')->orderByDesc('total')->get();
                $this->amount_required = $this->workorder_materials[$this->material->id][5];
                $rest = $this->amount_required;
                
                foreach ($this->normal_reservation as $deposito) {
                    $almacen += $deposito->total;
                    if ($this->amount_required >= $almacen) {
                        $this->deposit = array(
                            'deposit_material' => $deposito->id,
                            'id' => $deposito->warehouse_id,
                            'name' => $deposito->warehouse->name,
                            'type' => $deposito->warehouse->type,
                            'presentation' => $deposito->presentation,
                            'amount' => $deposito->total,
                        );
                        $this->amount_deposit[$deposito->material_id][$deposito->warehouse_id][$this->deposit['presentation']] = $this->deposit['amount'];
                        $this->amount_saved[$deposito->material_id][$deposito->warehouse_id][$this->deposit['presentation']] = $this->deposit['amount'];
                        $this->deposits[$deposito->material_id][]=$this->deposit;
                        $rest -= $deposito->total;
                    }else{
                        $this->deposit = array(
                            'deposit_material' => $deposito->id,
                            'id' => $deposito->warehouse_id,
                            'name' => $deposito->warehouse->name,
                            'type' => $deposito->warehouse->type,
                            'presentation' => $deposito->presentation,
                            'amount' =>  $deposito->total,
                        );
                        $this->amount_deposit[$deposito->material_id][$deposito->warehouse_id][$this->deposit['presentation']] = $rest;
                        $this->amount_saved[$deposito->material_id][$deposito->warehouse_id][$this->deposit['presentation']] =  $deposito->total;
                        $this->deposits[$deposito->material_id][]=$this->deposit;
                        
                        break;
                    }  
                }
                
                break;
            case 'Equilibrado':
                $this->eq_reservation = $this->material->depositmaterials()->select('id','warehouse_id','presentation','material_id', DB::raw('SUM(amount) as
                total'))->where('is_material',1)->groupBy('presentation','warehouse_id')->get();
                $this->amount_required = $this->workorder_materials[$this->material->id][5];
                $total = (count($this->eq_reservation) > 0) ? round($this->amount_required/count($this->eq_reservation)) : 0;
                $contador = 0;

                foreach ($this->eq_reservation as $deposito) {
                    #$almacen += $deposito->total;
                    if ($contador < $this->amount_required) {
                        $this->deposit = array(
                            'deposit_material' => $deposito->id,
                            'id' => $deposito->warehouse_id,
                            'name' => $deposito->warehouse->name,
                            'type' => $deposito->warehouse->type,
                            'presentation' => $deposito->presentation,
                            'amount' => $deposito->total 
                        );
                        if (($contador + $total) > $this->amount_required) {
                            $rest = $this->amount_required-$contador;
                            $this->amount_deposit[$deposito->material_id][$deposito->warehouse_id][$this->deposit['presentation']] = ($deposito->total >= $rest) ? $rest : $deposito->total;
                          
                        }else{
                            $this->amount_deposit[$deposito->material_id][$deposito->warehouse_id][$this->deposit['presentation']] = ($deposito->total >= $total) ? $total : $deposito->total;
                        }
                        $this->amount_saved[$deposito->material_id][$deposito->warehouse_id][$this->deposit['presentation']] = $this->deposit['amount'];
               
                        $this->deposits[$deposito->material_id][]=$this->deposit;
                        #$rest -= $deposito->total;
                        $contador += $this->amount_deposit[$deposito->material_id][$deposito->warehouse_id][$this->deposit['presentation']];
                        #$this->amount_required -= $contador;
                    }
                }
            
               while ($contador < $this->amount_required) {
                    foreach ($this->deposits[$this->material->id] as $key => $deposito) {
                        if(($deposito['amount'] - $this->amount_deposit[$this->material->id][$deposito['id']][$deposito['presentation']]) > 0 && $contador < $this->amount_required){
                            $this->amount_deposit[$this->material->id][$deposito['id']][$deposito['presentation']]++;
                            $contador++;
                            $end = false;
                            }elseif ($contador == $deposito['amount']) {
                                $end = true;
                            }
                    }
                    if($end){
                        break;
                    }
                }
                

                break;

            case 'Personalizado':
            $this->material_deposits = $this->material->depositmaterials()->where('is_material',1)->groupBy('warehouse_id')->get();
                 
                break;
        }
    }

    public function change_amount(Material $material, Warehouse $warehouse){
       
       $presentation_select = json_decode($this->presentation_selected[$material->id][$warehouse->id]);
        
        foreach ($this->amounts[$presentation_select->material_id][$presentation_select->warehouse_id] as $amount) {
            if ($presentation_select->presentation == $amount['presentation']) {
                $this->amount_presentation[$presentation_select->material_id][$presentation_select->warehouse_id] = $amount['total'];
            }
           
        }
    }

    public function add_deposit(DepositMaterial $deposit_material){
        $count=0;
       # dd($deposit_material);
        $this->validate([
            'presentation_selected' => 'required',
            
        ], [
            'presentation_selected.required' => 'Seleccione una presentación',
        ]);

            $presentation = json_decode($this->presentation_selected[$deposit_material->material_id][$deposit_material->warehouse_id])->presentation;
            
            if(count($this->deposits)>0 && !empty($this->deposits[$this->material_id])){
                foreach ($this->deposits[$this->material_id] as $depositos) {
                    if ($depositos['deposit_material'] == $deposit_material->id && $depositos['presentation'] == $presentation) {
                        $this->addError('deposit', 'Este depósito ya está seleccionado con la presentación '. $presentation);
                        $count ++;
                    }
                }
            }

            if ($count == 0) {
                $this->deposit = array(
                    'deposit_material' => $deposit_material->id,
                    'id' => $deposit_material->warehouse_id,
                    'name' => $deposit_material->warehouse->name,
                    'type' => $deposit_material->warehouse->type,
                    'presentation' => $presentation,
                    'amount' => $this->amount_presentation[$deposit_material->material_id][$deposit_material->warehouse_id]
                );
                $this->amount_deposit[$deposit_material->material_id][$deposit_material->warehouse_id][$this->deposit['presentation']] = $this->deposit['amount'];
                $this->amount_saved[$deposit_material->material_id][$deposit_material->warehouse_id][$this->deposit['presentation']] = $this->deposit['amount'];
            #   dd($this->amount_deposit);
               $this->deposits[$deposit_material->material_id][]=$this->deposit;
            }
            
            
           
            
    }

    public function addreservation(){
        #dd($this->amount_deposit);
        if(count($this->deposits)>0){
            //solo validación para el material en cada deposito
            foreach ($this->deposits[$this->material_id] as $depositos) {
                #dd($this->amount_deposit);
                foreach ($this->amount_deposit[$this->material_id][$depositos['id']] as $presentation => $amount) {
                    $this->validate([
                        'amount_deposit.'.$this->material_id.'.'.$depositos['id'].'.'.$presentation.'' => 'integer|min:0|max:'.$this->amount_saved[$this->material_id][$depositos['id']][$presentation],
                        
                    ], [
                        'amount_deposit.'.$this->material_id.'.'.$depositos['id'].'.'.$presentation.'.max' => 'El valor máximo disponible para el depósito '.$depositos['name'].' para la presentación '.$presentation.' es de: '.$this->amount_saved[$this->material_id][$depositos['id']][$presentation],
                    ]);
                }
           
            }
            //si pasa la validación, guarda
           
            foreach ($this->deposits[$this->material_id] as $deposito) {
                if ($this->amount_deposit[$this->material_id][$deposito['id']][$deposito['presentation']] > 0) {
                    $this->reservation = new ReservationMaterial;
                    $this->reservation->material_id=$this->material_id;
                    $this->reservation->workorder_id=$this->workorder->id;
                    $this->reservation->presentation=$deposito['presentation'];
                    $this->reservation->amount=$this->amount_deposit[$this->material_id][$deposito['id']][$deposito['presentation']];
                    $this->reservation->save();
    
                    //borrando del stock materiales
                    $material_up = Material::find($this->material_id);
                    $material_up->stock -= $this->amount_deposit[$this->material_id][$deposito['id']][$deposito['presentation']];
                    $material_up->save();
                    //borrando del deposito
                    $depositm=new DepositMaterial;
                    $depositm->material_id=$this->material_id;
                    $depositm->warehouse_id=$deposito['id'];
                    $depositm->warehouse2_id=0;
                    $depositm->presentation=$deposito['presentation'];
                    $depositm->amount=-($this->amount_deposit[$this->material_id][$deposito['id']][$deposito['presentation']]);
                    $depositm->date_change=Carbon::now()->format('Y-m-d');
                    $depositm->hour=Carbon::now()->format('H:i:s');
                    $depositm->name_receive='';
                    $depositm->name_entry='';
                    $depositm->is_material= 1;
                    $depositm->type=0;
                    $depositm->save();
    
                    $this->reservation_deposit = new ReservationDeposit;
                    $this->reservation_deposit->reservation_material_id=$this->reservation->id;
                    $this->reservation_deposit->deposit_id=$deposito['id'];
                    $this->reservation_deposit->save();
                }
            }
            
        $this->resetValidation();
        $this->dispatchBrowserEvent('hide-form');
            unset($this->deposits[$this->material_id]);
            return $this->explora($this->workorder);
        }
        
        #dd($this->amount_deposit);
    }

    public function down_deposit($index = 0){
            unset($this->deposits[$this->material_id][$index]);
    }
    public function explora_reservation(Material $material){
        $this->material_id = $material->id;
        $this->material_code = $material->code;
        $this->material_description = $material->description;
        $this->reservation = $this->workorder->reservationmaterials()->where('material_id',$material->id)->get();
       
        $this->dispatchBrowserEvent('show-form-reservation');
    }

    public function comprar(){
        #dd($this->workorder->workorder_orders);
        $this->funcion="sheet";
        $this->clientworkorders = $this->workorder->workorder_orders;
        foreach ($this->clientworkorders as $clientworkorder) {
            $this->addorder($clientworkorder->clientorder);
        }
        
    }

    public function buy(Material $material)
    {
        $this->material_id=$material->id;
        $this->material_code=$material->code;
        $this->material_description=$material->description;
        $this->material = $material;
        $this->providers = $material->provider_prices()->groupBy('provider_id')->get();
        
        $this->dispatchBrowserEvent('show-form-material');
    }

    public function change_presentation(){
        $proveedor = Provider::find($this->proveedor_selected);
        $this->provider_presentations = $this->material->provider_prices()->where('provider_id', $proveedor->id)->get();
    }
    public function change_price(){
      
        $obj_price = json_decode($this->presentationm);
        $this->presentation = $obj_price->presentation;
        $this->unit = $obj_price->unit;
        $seleccion = $this->material->provider_prices()->where('provider_id', $this->proveedor_selected)->where('unit', $this->unit)->where('presentation', $this->presentation)->first();
        
        $this->usd_price = $seleccion->usd_price;
        $this->ars_price = $seleccion->ars_price;
        
    }
    public function buy_confirm()
    {
        $this->validate([
            'presentationm' => 'required',
            'proveedor_selected' => 'required',
        ], [
            'proveedor_selected.required' => 'Seleccione un proveedor',
            'presentationm.required' => 'Seleccione una presentación',
        ]);

        foreach($this->clientorders as $clientorder){
            
            if($clientorder[12]==$this->material_id){
                $this->clientorder[0]=$clientorder[0];
                $this->clientorder[1]=$clientorder[1];
                $this->clientorder[2]=$clientorder[2];
                $this->clientorder[3]=$clientorder[3];
                $this->clientorder[4]=$clientorder[4];
                $this->clientorder[5]=$clientorder[5];
                $this->clientorder[6]=$this->unit;
                $this->clientorder[7]=$this->amount;
                $this->clientorder[8]=$this->unit*$this->amount;
                $this->clientorder[9]=$this->usd_price;
                $this->clientorder[10]=$this->proveedor_selected;
                $this->clientorder[11]=$this->usd_price*$this->amount;
                $this->clientorder[12]=$clientorder[12];
                $this->clientorders[$this->material_id]=$this->clientorder;             
            }
        }
        $this->subtotal=0;
        foreach($this->clientorders as $clientorder){
            $this->subtotal+=$clientorder[11];
        }
        $this->dispatchBrowserEvent('hide-form-material');
        $this->provider_presentations = [];
        $this->proveedor_selected = null;
        $this->unit=null;
        $this->amount=null;
        unset($this->presentationm);
        $this->usd_price = null;
        $this->ars_price = null;
        $this->resetValidation();
    }
    
    public function save_pucharsing(){
        
        $date=Carbon::now();
        $plantilla= new PucharsingSheet;
        $plantilla->date=$date;
        $plantilla->usd_subtotal_price=$this->subtotal;
        $plantilla->iva=$this->iva;
        $plantilla->work_order_id=$this->workorder->id;
        $plantilla->usd_total_price=$this->total_price;
        $plantilla->save();
        
        foreach($this->clientworkorders as $orden){
            $plantilla_orden= new PucharsingSheetOrder;
            $plantilla_orden->pucharsing_sheet_id=$plantilla->id;
            $plantilla_orden->clientorder_id=$orden->clientorder_id;
            $plantilla_orden->save();
            $clientorder=Clientorder::find($orden->clientorder_id);
            $clientorder->buys=2;
            $clientorder->save();
        }
        foreach($this->clientorders as $purchasing){
            if($purchasing[7]>0){
                $plantilla_detail=new PucharsingSheetDetail;
                $plantilla_detail->pucharsing_sheet_id=$plantilla->id;
                $plantilla_detail->material_id=$purchasing[12];
                $plantilla_detail->amount=$purchasing[7];
                $plantilla_detail->presentation=$purchasing[6];
                $plantilla_detail->usd_price=$purchasing[11];
                $plantilla_detail->provider_id=$purchasing[10];
                $plantilla_detail->save();
            }
        }
        $plantilla_ordenes=$plantilla->purchasing_sheet_details()->orderBy('provider_id')->get();
       
        foreach($plantilla_ordenes as $ordenes){
                $proveedor_id=$ordenes->provider_id;
                $ordenes_de_compra=new BuyOrder;
                $ordenes_de_compra->buy_date=$date;
                $ordenes_de_compra->provider_id=$ordenes->provider_id;
                $ordenes_de_compra->total_price+=$ordenes->usd_price*$ordenes->amount;
                $ordenes_de_compra->purchasing_sheet_id=$ordenes->id;
                $ordenes_de_compra->state=1;
                $ordenes_de_compra->save();
                $ordenes_de_compra_detalle= new BuyOrderDetail;
                $ordenes_de_compra_detalle->material_id=$ordenes->material_id;
                $ordenes_de_compra_detalle->presentation=$ordenes->presentation;
                $ordenes_de_compra_detalle->buy_order_id=$ordenes_de_compra->id;
                $ordenes_de_compra_detalle->amount=$ordenes->amount;
                $ordenes_de_compra_detalle->presentation_price=$ordenes->usd_price;
                $ordenes_de_compra_detalle->total_price=$ordenes->usd_price*$ordenes->amount;
                $ordenes_de_compra_detalle->save();
                
            }
        $ordenes_de_compra->save();
        $this->provider_presentations = [];
        $this->proveedor_selected = null;
        $this->unit=null;
        $this->amount=null;
        unset($this->presentationm);
        $this->usd_price = null;
        $this->ars_price = null;
        $this->iva = 0;
        $this->clientworkorders=[];
        $this->clientorders=[];
        $this->subtotal = 0;
        $this->total_price = 0;
        $this->funcion='explora';
    }

    public function backexpl(){
        return $this->funcion='explora';
    }

    public function buscamaterial()
    {   $this->searchmaterial='';
        $this->dispatchBrowserEvent('show-form-addmaterial');
    }
    public function addmaterialsinorden(Material $material)
    {
            $this->clientorder[0]=$this->materialcount;
            $this->clientorder[1]=$material->code;
            $this->clientorder[2]=$material->description;
            $this->clientorder[3]=$material->stock;
            $this->clientorder[4]=$material->stock_transit;
            $this->clientorder[5]=0;
            $this->clientorder[6]=0;
            $this->clientorder[7]=0;
            $this->clientorder[8]=0;
            $this->clientorder[9]=0;
            $this->clientorder[10]="";
            $this->clientorder[11]=0;
            $this->clientorder[12]=$material->id;
            $this->clientorders[$material->id]=$this->clientorder;
            $this->materialcount+=1;
            $this->prueba=0;
        $this->dispatchBrowserEvent('hide-form-addmaterial');
    }

    public function backmodal(){
        $this->resetValidation();
        $this->amount=null;
        $this->searchmaterial='';
        $this->searchdeposito='';
    }

    public function cancelar(Clientorder $order){
        $this->funcion="cancelar";
        $this->orden = $order;
        $this->orden_id = $order->id;
        $this->orden_date = $order->date;

        unset($this->depo);
        unset($this->depo_instalacion);
        unset($this->depo_ensamblado);
        $this->installations = array();
        $this->assembleds = array();
        $this->selection = null;
        $this->searchdeposito = '';
        $this->searchensamblados = '';
        $this->searchinstalaciones = '';
    }


    public function selectdeposit(Warehouse $deposit)
    {
        $this->searchdeposito = '';

        if ($this->selection == 'Ensamblados') {
        $this->depo_ensamblado_id = $deposit->id;
        $this->depo_ensamblado_name = $deposit->name;
        $this->depo_ensamblado_description = $deposit->description;
        $this->depo_ensamblado_type = $deposit->type;
        $this->depo_ensamblado=$deposit; 
        } else {
            $this->depo_instalacion_id = $deposit->id;
            $this->depo_instalacion_name = $deposit->name;
            $this->depo_instalacion_description = $deposit->description;
            $this->depo_instalacion_type = $deposit->type;
            $this->depo_instalacion=$deposit; 
        }
        
    }

    public function downdeposit(){
        unset($this->depo);
        $this->depo_id = null;
        $this->depo_name = null;
        $this->depo_description = null;
        $this->depo_type = null;
    }

    public function createproduct(){
        $this->funcion="createproduct";

        if ($this->selection == 'Ensamblados') {
            $this->assembled_description='';
            $this->searchensamblados="";
        }else{
            $this->installation_description='';
            $this->installation_code='';
            $this->searchinstalaciones="";
        }
        
    }
    
    public function selectproduct($id = 0){
        if ($this->selection == 'Ensamblados') {
            $assembled = Assembled::find($id);
            $this->searchensamblados="";
            $this->assembled_id=$assembled->id;
            $this->assembled_description=$assembled->description;
        }else{ 
            $installation = Installation::find($id);
            $this->searchinstalaciones="";
            $this->installation_id=$installation->id;
            $this->installation_code=$installation->code;
            $this->installation_description=$installation->description;
        }
        
  
        $this->dispatchBrowserEvent('show-form-product');
    }

    public function addproduct()
    {
       if ($this->selection == 'Ensamblados') {
        $assembled[0]=$this->assembled_id;
        $assembled[1]=$this->assembled_description;
        $assembled[2]=$this->amount;
        $this->assembleds[$this->assembled_id]=$assembled;
       }elseif($this->selection == 'Instalaciones'){
        $installation[0]=$this->installation_id;
        $installation[1]=$this->installation_code;
        $installation[2]=$this->installation_description;
        $installation[3]=$this->amount;
        $this->installations[$this->installation_id]=$installation;
       }
        
        $this->amount=0;
       
        $this->dispatchBrowserEvent('hide-form-product');
    }
    
    public function selectmaterial(Material $material)
    {
        $this->material_id=$material->id;
        $this->material_description=$material->description;;
        $this->material_code=$material->code;
      #  dd($this->presentationm);
        $this->dispatchBrowserEvent('show-form-addproduct');
    }

    public function addmateriall()
    {
       
        $this->detail[0]=$this->material_code;
        $this->detail[1]=$this->material_description;
        $this->detail[2]=$this->amount;
        $this->detail[3]=$this->count;
        $this->detail[4]=$this->material_id;
        $this->details[$this->material_id]=$this->detail;
        $this->count=$this->count+1;
        $this->amount=0;
        $this->dispatchBrowserEvent('hide-form-addproduct');
    }

    public function store_product(){
        if ($this->selection == 'Ensamblados') {
            $this->validate([
                'assembled_description' => 'required|string|min:5|max:200'
            ],[
                'assembled_description.required' => 'El campo Descripción es requerido',
                'assembled_description.min' => 'El campo Descripción tiene como mínimo 5 caracteres',
                'assembled_description.max' => 'El campo Descripción tiene como máximo 200 caracteres'
            ]);
            $assembled=new Assembled;
            $assembled->description=$this->assembled_description;
            $assembled->create_date=$this->assembled_date;
            $assembled->save();
            foreach($this->details as $detail){
                $assembleddetail=new AssembledDetail;
                $assembleddetail->assembled_id=$assembled->id;
                $assembleddetail->material_id=$detail[0];
                $assembleddetail->amount=$detail[2];
                $assembleddetail->save();
                }
        }else{
            $this->validate([
                'installation_code'=>'required|integer|min:1|max:100000000',
                'installation_description'=>'required|string|min:5|max:300',
                'installation_date'=>'required|date',
                'installation_usd_price'=>'required|numeric|min:0|max:1000000',
                'installation_hours_man'=>'required|numeric|min:0|max:1000000',
            ],[
                'installation_date.required' => 'El campo Fecha es requerido',
                'installation_code.required' => 'El campo Código es requerido',
                'installation_code.integer' => 'El camppo Código debe ser un número entero',
                'installation_code.min' => 'El campo Código debe ser igual o mayor a 1(uno)',
                'installation_code.max' => 'El campo Código debe ser menor o igual a 10000000(diez millones)',
                'installation_description.required' => 'El campo Descripción es requerido',
                'installation_description.min' => 'El campo Descripción tiene al menos 5 caracteres',
                'installation_description.max' => 'El campo Descripción tiene como máximo 300 caracteres',
                'installation_date.requred' => 'El campo Fecha es requerido',
                'installation_usd_price.required' => 'El campo Precio U$D es requerido',
                'installation_usd_price.numeric' => 'El campo Precio U$D es numérico',
                'installation_usd_price.max' => 'El campo precio U$D tiene como maximo 1000000(un millon)',
                'installation_hours_man.required' => 'El campo Horas/Hombre es requerido',
                'installation_hours_man.numeric' => 'El campo Horas/Hombre es numérico',
                'installation_hours_man.max' => 'El campo Horas/Hombre tiene como maximo 1000000(un millon)',
           ]);
           $instalacion= new Installation;
           $instalacion->code=$this->installation_code;
           $instalacion->description=$this->installation_description;
           $instalacion->date_admission=$this->installation_date;
           $instalacion->usd_price=$this->installation_usd_price;
           $instalacion->hours_man=$this->installation_hours_man;
           $instalacion->save();
           
           $revision=new Revision;
           $revision->installation_id=$instalacion->id;
           $revision->number_version=0;
           $revision->create_date=$this->installation_date;
          
           $revision->reason="Modelo base";
           $revision->save();
           foreach($this->details as $detail)
           {
               $newdetail=new Revisiondetail;
               $newdetail->installation_id=$instalacion->id;
               $newdetail->number_version=$revision->number_version;
               $newdetail->material_id=$detail[4];
               $newdetail->amount=$detail[2];
               $newdetail->save(); 
           }
            $installation[0]=$instalacion->id;
            $installation[1]=$instalacion->code;
            $installation[2]=$instalacion->description;
            $installation[3]=0;
            $this->installations[$instalacion->id]=$installation;
        }
       
            
            $this->funcion='cancelar';
            $this->amount=0;
            $this->details = array();
            $this->assembled_description = '';
            $this->assembled_date = null;
            $this->installation_date = null;
            $this->installation_code = '';
            $this->installation_usd_price = '';
            $this->installation_hours_man = '';
            $this->installation_description = '';
            $this->searchmaterial = '';
            $this->resetValidation();
    }

    public function downproduct($index = 0){
        if ($this->selection == 'Ensamblados') {
            unset($this->assembleds[$index]);
        }elseif($this->selection == 'Instalaciones'){
            unset($this->installations[$index]);
        }
    }

    public function downmaterial($index = 0){
        unset($this->details[$index]);
    }

    public function backcancel(){
        $this->funcion = 'cancelar';
        $this->amount=0;
        $this->details = array();
        $this->assembled_description = '';
        $this->assembled_date = null;
        $this->installation_date = null;
        $this->installation_code = '';
        $this->installation_usd_price = '';
        $this->installation_hours_man = '';
        $this->installation_description = '';
        $this->searchmaterial = '';
        $this->resetValidation();
    }

    public function store_cancelar(){
      
        if (count($this->assembleds) > 0) {

            $this->validate([
                'depo_ensamblado'=>'required',
            ],[
                'depo_ensamblado.required' => 'Seleccione un depósito para almacenar',
            ]);
      
            foreach($this->assembleds as $assembled){
                $ingreso = new DepositMaterial;
                $ingreso->warehouse_id=$this->depo_ensamblado_id;
                $ingreso->material_id = $assembled[0];
                $ingreso->amount = $assembled[2];
                $ingreso->date_change = Carbon::now()->format('Y-m-d');
                $ingreso->hour = Carbon::now()->format('H:i:s');
                $ingreso->is_material = false;
                $ingreso->presentation = 1;
                $ingreso->warehouse2_id = 0;
                $ingreso->name_receive = 'Orden de trabajo';
                $ingreso->name_entry = 'Orden de trabajo';
                $ingreso->type = 1;
                $ingreso->save();
                }
                
        }
        if (count($this->installations) > 0) {
            $this->validate([
                'depo_instalacion'=>'required',
            ],[
                'depo_instalacion.required' => 'Seleccione un depósito para almacenar',
            ]);

            foreach($this->installations as $installation){
                
                $ingreso = new DepositInstallation;
                $ingreso->warehouse_id=$this->depo_instalacion_id;
                $ingreso->installation_id = $installation[0];
                $ingreso->serial_number = 0;
                $ingreso->number_version = 0;
                $ingreso->client_order_id = $this->orden->id;
                $ingreso->date_admission = Carbon::now()->format('Y-m-d');
                $ingreso->hour = Carbon::now()->format('H:i:s');
                $ingreso->name_receive = 'Orden de trabajo';
                $ingreso->name_entry = 'Orden de trabajo';
                $ingreso->warehouse2_id = 0;
                $ingreso->save();
                }
         
        }
        if (!empty($ingreso)) {
            $this->workorder->state = 'Actual con pedidos cancelados';
            $this->workorder->save();
            $this->orden->order_state = 7;
            $this->orden->save();  
            /* Eliminar de reservar, esta por ver 
            foreach($this->orden->orderdetails as $detailorder){
                foreach($detailorder->installations as $installation){ 
                    $countrevision=$installation->revisions->count()-1;
                    $revision=$installation->revisions()->orderBy('number_version','desc')->first();
                    foreach($installation->revisiondetails as $revisiondetail){
                        $material=$revisiondetail->materials;
                        
                        if (!isset($this->pucharsings[$material->id])) {
                            foreach($this->pucharsings as $order){
                                if($order[1]==$material->code)
                                {
                                    $this->prueba=$order[5];
                                    #unset($this->pucharsings[$order[0]]);
                                }
                            }
                            $reservaciones = $material->reservationmaterials()->select('presentation','material_id', DB::raw('SUM(amount) as
                            total'))->where('workorder_id', $this->workorder->id)->groupBy('presentation')->get();
                           
                            foreach ($reservaciones as $key => $reservacion) {
                                $reservation = new ReservationMaterial;
                                $reservation->material_id=$reservacion->material_id;
                                $reservation->workorder_id=$this->workorder->id;
                                $reservation->presentation=$reservacion->presentation;
                                $reservation->amount=$reservacion->total-($revisiondetail->amount*$detailorder->cantidad);
                                $reservation->save();
                            }
                            
                            $this->prueba=0;
                        }
                           
                    }
                }
            }  */
            $this->resetValidation();
            $this->funcion = 'explora';
            return $this->ordenes[$this->orden->id]['order_state'] = 7;
        }

      
    }

    public function update(Workorder $workorder)
    {
        $this->funcion = "actualizar";
        $this->code = $workorder->code;
        $this->start_date = date("Y-m-d",strtotime($workorder->start_date));
        $this->end_date = $workorder->end_date;
        $this->hours = $workorder->hours;
        $this->man = $workorder->man;
        $this->hours_man_avaiable = $workorder->hours * $workorder->man;
        $this->hours_man = $workorder->hours_man_required;
        $this->workorder = $workorder;
        $orders = $workorder->workorder_orders;
        $details = $workorder->workorder_details;
        foreach ($orders as $order) {
            $this->ordenes[$order->clientorder_id]=$order->clientorder;
        }
        
        foreach ($details as $detail) {
              $this->clientorders[$detail->material->id]= array(
                0 => $detail->material->id,
                1 => $detail->material->code,
                2 => $detail->material->description,
                3 => $detail->material->stock,
                4 => $detail->material->stock_transit,
                5 => $detail->amount,
                6 => 0,
                7 => 0,
                8 => 0,
                9 => 0,
                10 => "",
                11 => 0,
                12 => $detail->material->id,
            );
        }
    }
    
    public function editar(){
        $this->validate([
            'code' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'hours' => 'required|numeric',
            'man' => 'required|integer',
            'ordenes' => 'required',
        ], [
            'code.required' => 'El campo código es requerido',
            'start_date.required' => 'El campo fecha de inicio es requerido',
            'end_date.required' => 'El campo fecha de finalización es requerido',
            'hours.required' => 'El campo horas disponibles es requerido',
            'hours.numeric' => 'El campo horas disponibles debe ser numérico',
            'man.required' => 'El campo empleados disponibles es requerido',
            'man.integer' => 'El campo empleados disponibles debe ser un número entero',
            'ordenes.required' => 'Seleccione un pedido',
        ]);
        
        $this->workorder->code=$this->code;
        $this->workorder->start_date=$this->start_date;
        $this->workorder->end_date=$this->end_date;
        $this->workorder->hours=$this->hours;
        $this->workorder->man=$this->man;
        $this->workorder->hours_man_required=$this->hours_man;
        $this->workorder->state='Nueva';
        $this->workorder->save();

#dd($this->workorder->workorder_orders);
        foreach ($this->workorder->workorder_orders as $key => $order) {
            $orden_ind[$order->clientorder_id] = $order->clientorder_id;
            
        }
        
        foreach($this->ordenes as $ind => $orden){
                if (!isset($orden_ind[$ind])) {
                    $this->clientorder_workorder= new ClientorderWorkorder;
                    $this->clientorder_workorder->workorder_id=$this->workorder->id;
                    $this->clientorder_workorder->clientorder_id=$orden['id'];
                    $this->clientorder_workorder->save();
                }
           
        }
       
        foreach ($this->workorder->workorder_details as $key => $detail) {
            $material_ind[0] = $detail->material_id;
            $material_ind[1] = $detail;
        }
       
        foreach($this->clientorders as $key => $clientorder){
            if($clientorder[5]>0){
                $this->workorder_detail = ($material_ind[0] == $key) ?  $material_ind[1] : new WorkorderDetail;
                $this->workorder_detail->workorder_id=$this->workorder->id;
                $this->workorder_detail->material_id=$clientorder[12];
                $this->workorder_detail->amount=$clientorder[5];
                $this->workorder_detail->save();
            }
        }
        $this->reset();
        $this->resetValidation();
        $this->funcion="";
    }

   
}
