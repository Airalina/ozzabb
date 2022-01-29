<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Clientorder;
use App\Models\Orderdetail;
use App\Models\Installation;
use App\Models\Revision;
use App\Models\Revisiondetail;
use App\Models\Material;
use App\Models\DepositMaterial;
use App\Models\ProviderPrice;
use App\Models\Provider;
use App\Models\PucharsingSheet;
use App\Models\PucharsingSheetDetail;
use App\Models\PucharsingSheetOrder;
use App\Models\BuyOrderDetail;
use App\Models\BuyOrder;
use App\Jobs\SendBuyEmail;
use Carbon\Carbon;
use Livewire\WithPagination;

class PurchasingSheet extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $purchasing_sheets;
    public $prueba=0, $paginas=25 ,$compras = array();
    public $funcion="", $sheet, $ord, $searchMounth='', $explora, $pedidos = false, $detail = array(), $count=0,$date, $provider_price_unit, $provider_price_price, $provider_id, $i = 0, $x = 0, $orderC, $total = [], $mats = [], $material = [], $present = [], $orders, $ottPlatform = '', $search = '', $clientOrders, $clientorders = [], $order = [], $order_detail = [], $installations, $installation, $installation_code = [[]], $revision_detail = [], $total_amount = [], $buys = [], $deposit_material = [], $total_material = [], $div = false, $select = false, $presentation = [], $stock, $suma = [], $block = true, $selection = false, $providers = [], $provider, $in_transit = [], $transit = [], $transits, $requirements = [], $requirement = [], $req = [], $amount, $provider_price = [], $provider_presentation = [], $comprar = [], $iva, $subtotal, $total_price, $select_present, $m_comprar = [], $searchP, $searchmateriales, $months, $cantidad, $msg, $msg_error, $selection_provider, $provider_selected, $mate, $orders_amount;
    private $select_presentation = [], $select_provider = [];
    public  $providerprice=array(),$providerprices=array(), $purchasing=array(), $purchasings=array(), $materialcount=0;
    public $ordenes=array(), $ordercount=0;
    public $ordenes_ingreso, $stock_transito=0, $ordenrep=false, $materialrep=false; 
    public $codem, $descriptionm, $proveedorm, $proveedormm, $proveedoresm=array(), $proveedorrep=false, $provcount=0, $presentationm,$presentationsm, $pricem, $clavem, $amountm;
    public $proveedor_name, $material_id, $precio, $subtotalxmaterial;
    public $plantilla, $plantilla_orden, $plantilla_detalle, $clientorder, $stmaterial;
    public $collectionmaterial=array(),$exceptmaterial,$exceptmaterials, $countmaterial=0, $materialessinorden=array(),$materialsinorden=false;
    public $ordenes_de_compra, $materials, $buy_orders, $buy_order_details,$to_order, $searchmaterial="", $ordenes_de_compra_detalle, $plantilla_ordenes, $id_proveedor=null, $proveedor_id=0, $pucharsing_sheets_materials, $order_list = 'id';
    public function render()
    {    $this->months = [1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril', 5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto', 9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre' ]; 
        foreach ($this->months as $number_month => $month) {
           if($this->search == $month){
            $this->searchMounth =  $number_month;
           } 
        }

        $array = explode('-',$this->searchP);
        $year = (!empty($array[2])) ? $array[2] : '';
        $month =  (!empty($array[1])) ? $array[1] : '';
        $day =  (!empty($array[0])) ? $array[0] : '';
        $fecha = $year.'-'.$month.'-'.$day;

        $code = explode('/',$this->search);

        $this->orders = Clientorder::where('id','LIKE','%'.$code[0].'%')
        ->orWhere('customer_name','LIKE','%'.$this->search.'%')
        ->orWhereMonth('date', $this->searchMounth)
        ->orWhereDay('date',  $this->search)
        ->get();
        $this->materials = Material::where('code','like','%'.$this->search.'%')
        ->orWhere('name','LIKE','%'.$this->search.'%')
        ->orWhere('family','LIKE','%'.$this->search.'%')
        ->orWhere('color','LIKE','%'.$this->search.'%')
        ->orWhere('description','LIKE','%'.$this->search.'%')
        ->orWhere('replace_id','LIKE','%'.$this->search.'%')->get();
        $this->purchasing_sheets = PucharsingSheet::where('id','LIKE','%'.$this->searchP.'%')
        ->orWhere('date','LIKE','%'.$fecha.'%')
        ->orWhereDay('date','LIKE','%'.$this->searchP.'%')
        ->orWhereMonth('date','LIKE','%'.$this->searchP.'%')
        ->orWhereYear('date','LIKE','%'.$this->searchP.'%')
        ->orWhere('usd_total_price','LIKE','%'.$this->searchP.'%')
        ->orderBy($this->order_list)
        ->paginate($this->paginas);
        $this->proveedorm=Provider::where('name', $this->proveedor_name)->first();
     
        if(!empty($this->proveedorm)){
            $this->presentationsm=ProviderPrice::where('provider_id', $this->proveedorm->id)->where('material_id',$this->material_id)->groupBy('unit')->get();
        } 
        if(!empty($this->presentationm))
        {
        $this->precio=ProviderPrice::where('provider_id', $this->proveedorm->id)->where('material_id',$this->material_id)->where('unit',$this->presentationm)->first();
        }
        if($this->iva==""){
            $this->iva=0;
        }
        $this->total_price = $this->subtotal+($this->subtotal*($this->iva/100));
        return view('livewire.purchasing-sheet',[
            'purchasing_sheets' => $this->purchasing_sheets,
        ]); 
    }

    public function addorder(Clientorder $order){
        if(count($this->ordenes)==0){
                $this->ordenes[$this->ordercount]=$order;
                $this->ordercount+=1;
                foreach($order->orderdetails as $detailorder){
                        $countrevision=$detailorder->installations->revisions->count()-1;
                        $revision=$detailorder->installations->revisions()->orderBy('number_version','desc')->first();
                        foreach($revision->revisiondetails->where('number_version',$countrevision) as $revisiondetail){
                                $material=$revisiondetail->materials;
                                
                                if (!empty($material->code)) {
                                    foreach( $this->purchasings as $purchasing){
                                        if($purchasing[1]==$material->code)
                                        {
                                            $this->prueba=$purchasing[5];
                                            unset($this->purchasings[$purchasing[0]]);
                                        }
                                    }
                                    $this->purchasing[0]=$this->materialcount;
                                    $this->purchasing[1]=$material->code;
                                    $this->purchasing[2]=$material->description;
                                    $this->purchasing[3]=$material->stock;
                                    $this->purchasing[4]=$material->stock_transit;
                                    $this->purchasing[5]=$this->prueba+$revisiondetail->amount*$detailorder->cantidad;
                                    $this->purchasing[6]=0;
                                    $this->purchasing[7]=0;
                                    $this->purchasing[8]=0;
                                    $this->purchasing[9]=0;
                                    $this->purchasing[10]="";
                                    $this->purchasing[11]=0;
                                    $this->purchasing[12]=$material->id;
                                    $this->purchasings[$material->id]=$this->purchasing;
                                    $this->materialcount+=1;
                                    $this->prueba=0;
                                }
                                
                        }
                    
                }  
        }else{
            foreach($this->ordenes as $orden){
                if($orden['id']==$order->id){
                    $this->ordenrep=true;
                }        
            }
            if($this->ordenrep==false){
                $this->ordenes[$this->ordercount]=$order;
                $this->ordercount+=1;
                foreach($order->orderdetails as $detailorder){
                        $countrevision=$detailorder->installations->revisions->count()-1;
                        $revision=$detailorder->installations->revisions()->orderBy('number_version','desc')->first();
                        foreach($revision->revisiondetails->where('number_version',$countrevision) as $revisiondetail){
                                $material=$revisiondetail->materials;
                            if(!empty($material->id)){
                                foreach( $this->purchasings as $purchasing){
                                    if($purchasing[1]==$material->code)
                                    {
                                        $this->materialrep=true;
                                        $this->prueba=$purchasing[0];
                                    }
                                }
                                if($this->materialrep==false)
                                {
                                    $this->purchasing[0]=$this->materialcount;
                                    $this->purchasing[1]=$material->code;
                                    $this->purchasing[2]=$material->description;
                                    $this->purchasing[3]=$material->stock;
                                    $this->purchasing[4]=$material->stock_transit;
                                    $this->purchasing[5]=$revisiondetail->amount*$detailorder->cantidad;
                                    $this->purchasing[6]=0;
                                    $this->purchasing[7]=0;
                                    $this->purchasing[8]=0;
                                    $this->purchasing[9]=0;
                                    $this->purchasing[10]="";
                                    $this->purchasing[11]=0;
                                    $this->purchasing[12]=$material->id;
                                    $this->purchasings[$material->id]=$this->purchasing;
                                    $this->materialcount+=1; 
                                    $this->prueba=0;
                                }else{
                                    $this->purchasing[0]=$this->purchasings[$this->prueba][0];
                                    $this->purchasing[1]=$this->purchasings[$this->prueba][1];
                                    $this->purchasing[2]=$this->purchasings[$this->prueba][2];
                                    $this->purchasing[3]=$this->purchasings[$this->prueba][3];
                                    $this->purchasing[4]=$this->purchasings[$this->prueba][4];
                                    $this->purchasing[5]=$this->purchasings[$this->prueba][5]+$revisiondetail->amount*$detailorder->cantidad;;
                                    $this->purchasing[6]=$this->purchasings[$this->prueba][6];
                                    $this->purchasing[7]=$this->purchasings[$this->prueba][7];
                                    $this->purchasing[8]=$this->purchasings[$this->prueba][8];
                                    $this->purchasing[9]=$this->purchasings[$this->prueba][9];
                                    $this->purchasing[10]=$this->purchasings[$this->prueba][10];
                                    $this->purchasing[11]=$this->purchasings[$this->prueba][11];
                                    $this->purchasing[12]=$this->purchasings[$this->prueba][12];
                                    $this->purchasings[$this->prueba]=$this->purchasing; 
                                    $this->materialrep=false;

                                }   
                            }                       
                        }
                }   
            }
        }
        $this->ordenrep=false;
        $this->materialrep=false;
        $this->search="";   
    }
    public function addmaterial(Material $material)
    {     
            $this->purchasing[0]=$this->materialcount;
            $this->purchasing[1]=$material->code;
            $this->purchasing[2]=$material->description;
            $this->purchasing[3]=$material->stock;
            $this->purchasing[4]=$material->stock_transit;
            $this->purchasing[5]=0;
            $this->purchasing[6]=0;
            $this->purchasing[7]=0;
            $this->purchasing[8]=0;
            $this->purchasing[9]=0;
            $this->purchasing[10]="";
            $this->purchasing[11]=0;
            $this->purchasing[12]=$material->id;
            $this->purchasings[$material->id]=$this->purchasing;
            $this->materialcount+=1;
            $this->prueba=0;
            $this->materialsinorden=false;

    }
    public function buy(string $code)
    {
        $this->proveedoresm = array();
        $this->material=Material::where('code', $code)->first();
        $this->material_id=$this->material->id;
        $this->codem=$this->material->code;
        $this->descriptionm=$this->material->description;
        foreach($this->material->provider_prices as $mat){
            if(count($this->proveedoresm)==0){
            $this->proveedoresm[$mat->provider_id]=Provider::find($mat->provider_id);
            $this->provcount+=1;
            }else{
                foreach($this->proveedoresm as $prov){
                    if($prov['id']==$mat->provider_id){
                        
                    }else{
                        $this->proveedoresm[$mat->provider_id]=Provider::find($mat->provider_id);
                        $this->provcount+=1;
                    }
                }
            }
        }
        $this->dispatchBrowserEvent('show-form');
    }
    public function buy_confirm()
    {
        $this->validate([
            'presentationm'=>'required',
            'amount'=>'required|numeric|min:1',
            'proveedor_name'=>'required',
        ], [
            'presentationm.required'=>'Debe seleccionar una presentación',
            'amount.required'=>'Debe ingresar una cantidad',
            'amount.numeric'=>'El campo cantidad debe ser numérico',
            'amount.min'=>'El campo cantidad debe ser mayor a cero',
            'proveedor_name.required'=>'Debe seleccionar un proveedor',
        ]);
      
        foreach($this->purchasings as $purchasing){
            if($purchasing[1]==$this->codem){
                $compra[0]=$purchasing[0];
                $compra[1]=$purchasing[1];
                $compra[2]=$purchasing[2];
                $compra[3]=$purchasing[3];
                $compra[4]=$purchasing[4];
                $compra[5]=$purchasing[5];
                $compra[6]=$this->presentationm;
                $compra[7]=$this->amount;
                $compra[8]=$this->presentationm*$this->amount;
                $compra[9]=$this->precio->usd_price;
                $compra[10]=$this->proveedor_name;
                $compra[11]=$this->precio->usd_price*$this->amount;
                $compra[12]=$purchasing[12];
                $this->compras[$this->material_id]=$compra;           
            }
        }
        $this->subtotal=0;
        foreach($this->compras as $compra){
            $this->subtotal+=$compra[11];
        }
        $this->dispatchBrowserEvent('hide-form');
        $this->provcount=0;
        $this->proveedoresm=[];
        $this->proveedor_name=null;
        $this->presentationm=null;
        $this->amount=null;
        $this->resetValidation();
    }
    public function funcion()
    {
        $this->reset();
        $this->funcion="crear";
    }
    public function buscamaterial()
    {
        $this->dispatchBrowserEvent('show-formmaterial');
    }
    public function addmaterialsinorden(Material $material)
    {
        $this->addmaterial($material);
        $this->dispatchBrowserEvent('hide-formmaterial');
    }
    public function save(){

        $this->validate([
            'ordenes'=>'required',
            'iva'=>'numeric|min:0',
            'compras'=>'min:1',
            'purchasings.*.7'=>'numeric|min:0',
            'purchasings.*.6'=>'numeric|min:0',
            
        ], [
            'ordenes.required'=>'Debe seleccionar al menos un pedido',
            'iva.required'=>'El campo IVA es requerido',
            'iva.numeric'=>'El campo IVA es numérico',
            'iva.min'=>'El campo IVA es mayor a 0',
            'compras.min'=>'Debe comprar al menos un material',
            'purchasings.*.7.required'=>'Debe rellenar el campo cantidad para el material ',
            'purchasings.*.6.required'=>'Debe seleccionar el campo presentación para el material ',
            'purchasings.*.7.numeric'=>'El campo cantidad debe ser numérico ',
            'purchasings.*.6.numeric'=>'El campo presentación debe ser numérico ',
            'purchasings.*.7.min'=>'El campo cantidad debe ser mayor a cero ',
            'purchasings.*.6.min'=>'El campo presentación debe ser mayor a cero',
            'purchasings.*.10.required'=>'Debe rellenar el campo proveedor, presentación y cantidad para los materiales ',
    
        ]);
 
        $this->date=Carbon::now();
        $this->plantilla= new PucharsingSheet;
        $this->plantilla->date=$this->date;
        $this->plantilla->usd_subtotal_price=(!empty($this->subtotal)) ? $this->subtotal : 0;
        $this->plantilla->iva=$this->iva;
        $this->plantilla->usd_total_price=(!empty($this->total_price)) ? $this->total_price : 0; 
        $this->plantilla->save();
        foreach($this->ordenes as $orden){
            $this->plantilla_orden= new PucharsingSheetOrder;
            $this->plantilla_orden->pucharsing_sheet_id=$this->plantilla->id;
            $this->plantilla_orden->clientorder_id=$orden['id'];
            $this->plantilla_orden->save();
            $this->clientorder=Clientorder::find($orden['id']);
            $this->clientorder->buys=2;
            $this->clientorder->save();
        }
        foreach($this->compras as $compra){
            if($compra[7]>0){
                $this->plantilla_detail=new PucharsingSheetDetail;
                $this->plantilla_detail->pucharsing_sheet_id=$this->plantilla->id;
                $this->plantilla_detail->material_id=$compra[12];
                $this->plantilla_detail->amount=$compra[7];
                $this->plantilla_detail->presentation=$compra[6];
                $this->plantilla_detail->usd_price=$compra[11];
                $this->plantilla_detail->provider_id=Provider::where('name',$compra[10])->first()->id;
                $this->plantilla_detail->save();
            }
        }
        $this->plantilla_ordenes=$this->plantilla->purchasing_sheet_details()->orderBy('provider_id')->get();
        
        foreach($this->plantilla_ordenes as $ordenes){
            if($this->proveedor_id==0){
                $this->proveedor_id=$ordenes->provider_id;
                $this->ordenes_de_compra=new BuyOrder;
                $this->ordenes_de_compra->buy_date=$this->date;
                $this->ordenes_de_compra->provider_id=$ordenes->provider_id;
                $this->ordenes_de_compra->total_price+=$ordenes->usd_price;
                $this->ordenes_de_compra->pucharsing_sheet_id=$this->plantilla->id;
                $this->ordenes_de_compra->state=1;
                $this->ordenes_de_compra->save();
                $this->ordenes_de_compra->order_number=$this->ordenes_de_compra->id."/".date('Y', strtotime($this->date));
                $this->ordenes_de_compra->save();
                $this->ordenes_de_compra_detalle= new BuyOrderDetail;
                $this->ordenes_de_compra_detalle->material_id=$ordenes->material_id;
                $this->ordenes_de_compra_detalle->presentation=$ordenes->presentation;
                $this->ordenes_de_compra_detalle->buy_order_id=$this->ordenes_de_compra->id;
                $this->ordenes_de_compra_detalle->amount=$ordenes->amount;
                $this->ordenes_de_compra_detalle->presentation_price=$ordenes->usd_price/$ordenes->amount; //Revisar codigo (Los valores no son traidos de forma correcta)
                $this->ordenes_de_compra_detalle->total_price=$ordenes->usd_price;//Revisar codigo (Los valores no son traidos de forma correcta)
                $this->ordenes_de_compra_detalle->save();
                $this->stmaterial=Material::find($ordenes->material_id);
                $this->stmaterial->stock_transit+=$ordenes->presentation*$ordenes->amount;
                $this->stmaterial->save();
                
            }elseif($this->proveedor_id!=$ordenes->provider_id){
                $this->proveedor_id=$ordenes->provider_id;
                $this->ordenes_de_compra=new BuyOrder;
                $this->ordenes_de_compra->buy_date=$this->date;
                $this->ordenes_de_compra->provider_id=$ordenes->provider_id;
                $this->ordenes_de_compra->total_price+=$ordenes->usd_price;
                $this->ordenes_de_compra->pucharsing_sheet_id=$this->plantilla->id;
                $this->ordenes_de_compra->state=1;
                $this->ordenes_de_compra->save();
                $this->ordenes_de_compra->order_number=$this->ordenes_de_compra->id."/".date('Y', strtotime($this->date));
                $this->ordenes_de_compra->save();
                $this->ordenes_de_compra_detalle=new BuyOrderDetail;
                $this->ordenes_de_compra_detalle->material_id=$ordenes->material_id;
                $this->ordenes_de_compra_detalle->presentation=$ordenes->presentation;
                $this->ordenes_de_compra_detalle->buy_order_id=$this->ordenes_de_compra->id;
                $this->ordenes_de_compra_detalle->amount=$ordenes->amount;
                $this->ordenes_de_compra_detalle->presentation_price=$ordenes->usd_price/$ordenes->amount; //Revisar codigo (Los valores no son traidos de forma correcta)
                $this->ordenes_de_compra_detalle->total_price=$ordenes->usd_price;//Revisar codigo (Los valores no son traidos de forma correcta)
                $this->ordenes_de_compra_detalle->save();
                $this->stmaterial=Material::find($ordenes->material_id);
                $this->stmaterial->stock_transit+=$ordenes->presentation*$ordenes->amount;
                $this->stmaterial->save();
            }else{
                $this->ordenes_de_compra->total_price+=$ordenes->usd_price;
                $this->ordenes_de_compra->save();
                $this->ordenes_de_compra_detalle=new BuyOrderDetail;
                $this->ordenes_de_compra_detalle->material_id=$ordenes->material_id;
                $this->ordenes_de_compra_detalle->presentation=$ordenes->presentation;
                $this->ordenes_de_compra_detalle->buy_order_id=$this->ordenes_de_compra->id;
                $this->ordenes_de_compra_detalle->amount=$ordenes->amount;
                $this->ordenes_de_compra_detalle->presentation_price=$ordenes->usd_price/$ordenes->amount; //Revisar codigo (Los valores no son traidos de forma correcta)
                $this->ordenes_de_compra_detalle->total_price=$ordenes->usd_price;//Revisar codigo (Los valores no son traidos de forma correcta)
                $this->ordenes_de_compra_detalle->save();
                $this->stmaterial=Material::find($ordenes->material_id);
                $this->stmaterial->stock_transit+=$ordenes->presentation*$ordenes->amount;
                $this->stmaterial->save();
            }
        }
        if (!empty($this->ordenes_de_compra)) {
            $this->ordenes_de_compra->save();
        }
        $this->reset();
     }
     public function view_detail(PucharsingSheet $purchasing)
     {
        $this->funcion="viewdetail";
        $this->purchasing=$purchasing;
        $this->purchasings=$purchasing->purchasing_sheet_details()->orderBy('provider_id')->get();;

     }
     public function backlist()
     {
        $this->reset();
     }                        

     public function explora(PucharsingSheet $sheet){
        #$this->sheet = $sheet;
        $orders = $sheet->purchasing_sheet_orders;
        $details = $sheet->purchasing_sheet_details;
        foreach ($orders as $order) {
            $this->ordenes[]=$order->clientorder;
        }
        foreach ($details as $detail) {
            $provider_price = ProviderPrice::where('material_id', $detail->material->id)->where('provider_id', $detail->provider->id)->first();
            $this->pucharsing_sheets_materials[]= array(
                0 => $detail->material,
                1 => $detail->provider,
                2 => $detail->presentation,
                3 => $detail->amount,
                4 => $provider_price->usd_price,
                5 => $detail->usd_price,
            );
            
        }
        $this->subtotal = $sheet->usd_subtotal_price;
        $this->iva = $sheet->iva;
        $this->total_price = $sheet->usd_total_price;
       #dd($this->pucharsing_sheets_materials);
        $this->funcion="explora";
       #dd($this->ordenes);
     }
     public function buy_orders(PucharsingSheet $sheet){
        $this->to_order=$sheet->id;
        $this->buy_orders=$sheet->buyorders;
        $this->funcion="ordenes";
        
     }
     public function go_to_orders(PucharsingSheet $sheet){
        $this->funcion="ordenes";
     }
     public function exploraorder(BuyOrder $order){
        $this->buy_order_details=$order->buyorderdetails;
        $this->funcion="ordenes_explora";   
     }
     public function change_provider(){
         unset($this->presentationm);
         unset($this->amount);
     }
     public function backmodal(){
        $this->proveedor_name = '';
        $this->presentationm = null;
        $this->amount = null;
     }
}
