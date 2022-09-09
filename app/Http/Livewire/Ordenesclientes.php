<?php

namespace App\Http\Livewire;
use App\Models\Orderdetail;
use App\Models\Installation;
use App\Models\Clientorder;
use App\Models\DomicileDelivery;
use App\Models\Customer;
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;
use App\Models\Dollar;

class Ordenesclientes extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $orders;
    public $order, $idp, $funcion="list", $namecust, $codei, $descriptioni, $usd_price_i, $paginas=25, $customer_id, $date, $deadline, $deadline1, $start_date, $buys, $order_state, $order_job, $usd_price, $arp_price, $search;
    public $codinstall, $upusd, $installid=false, $cant, $cantidad=0, $total=0, $newdetail, $explora="inactivo", $searchclient="", $custormers, $searchinstallation="", $installations;
    public  $customer, $customers, $usd=180, $count=0, $address, $address_id, $countaddress, $selectcustomer=false, $update=false, $addaddress=false, $selectaddress=false, $newaddress;
    Public $street, $number, $newtotal=0, $location, $province, $country, $postcode, $detailcollect, $order_id, $detail_id, $nuevafecha=false;
    public $detail=array(), $detailup, $estado,$dolar,$ar_price;
    public $details=array();
    protected $listeners =[
        'newOrder'
        ];
    protected $dates = ['deadline', 'date', 'start_date'];
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function newOrder(Customer $client)
    {
        $this->customer=$client;
        $this->funcion="ordernew";
        $this->namecust=$client->name;
        $this->customer_id=$client->id;
        $this->selectaddress($client);
    }

    public function render()
    {
        $this->dolar=Dollar::where('id',1)->first();
        $this->ar_price=$this->dolar->arp_price;
        $this->installations=Installation::where('id','LIKE','%' .$this->searchinstallation. '%')
        ->orWhere('code','LIKE','%'.$this->searchinstallation.'%')
        ->orWhere('description','LIKE','%'.$this->searchinstallation.'%')->get();
        $this->customers=Customer::where('name','LIKE','%' . $this->searchclient.'%')
        ->orWhere('domicile_admin','LIKE','%'.$this->searchclient.'%')
        ->orWhere('id','LIKE','%'.$this->searchclient.'%')
        ->orWhere('phone','LIKE','%'.$this->searchclient.'%')
        ->orWhere('contact','LIKE','%'.$this->searchclient.'%')
        ->orWhere('post_contact','LIKE','%'.$this->searchclient.'%')
        ->orWhere('email','LIKE','%'.$this->searchclient.'%')->get();

        $array = explode('/',$this->search);
        $year = (!empty($array[2])) ? $array[2] : '';
        $month =  (!empty($array[1])) ? $array[1] : '';
        $day =  (!empty($array[0])) ? $array[0] : '';
        $fecha = $year.'-'.$month.'-'.$day;
      
        switch (strtolower($this->search)) {
            case 'nuevo':
                $this->estado = 1;
                break;
            case 'confirmado':
                $this->estado = 2;
                break;
            case 'rechazado':
                $this->estado = 3;
                break;
            case 'demorado':
                $this->estado = 4;
                break; 
            case 'produccion':
                $this->estado = 5;
                break; 
            case 'deposito':
                $this->estado = 6;
                break; 
            default:
                    $this->estado = $this->search;
                break;                 
        }
        $this->orders=Clientorder::where('id','LIKE','%' . $this->search . '%')
        ->orWhere('customer_id','LIKE','%'.$this->search.'%')
        ->orWhere('customer_name','LIKE','%'.$this->search.'%')
        ->orWhere('date','LIKE','%'.$fecha.'%')
        ->orWhere('usd_price','LIKE','%'.$this->search.'%')
        ->orWhere('arp_price','LIKE','%'.$this->search.'%')
        ->orWhere('deadline','LIKE','%'.$fecha.'%')
        ->orWhere('order_state','LIKE','%'.$this->estado.'%')
        ->orWhere('start_date','LIKE','%'.$fecha.'%')
        ->orWhere('buys','LIKE','%'.$this->search.'%')
        ->orWhere('order_job','LIKE','%'.$this->search.'%')->paginate($this->paginas);
        return view('livewire.ordenesclientes',[
            'orders' => $this->orders,
        ]);
    }

    

    public function storepedido()
    {
        $this->validate([
            'details'=>'required'],[
            'details.required' =>'Es necesario agregar al menos un producto'
            ]);
        if($this->addaddress){
            $this->validate([
                'street' => 'required|string|min:4|max:30',
                'number' => 'required|integer|min:1|max:10000',
                'location' => 'required|string|min:4|max:30',
                'province' => 'required|string|min:4|max:30',
                'country' => 'required|string|min:3|max:30',
                'postcode' => 'required|integer|min:1|max:100000',
            ],[
                'street.required' => 'El campo "Calle" es requerido',
                'street.min' => 'El campo "Calle" tiene como mínimo 4(cuatro) caracteres',
                'location.required' => 'El campo "Localidad" es requerido',
                'location.min' => 'El campo "Localidad" tiene como mínimo 4(cuatro) caracteres',
                'province.required' => 'El campo "Provincia" es requerido',
                'province.min' => 'El campo "Provincia" tiene como mínimo 4(cuatro) caracteres',
                'country.required' => 'El campo "País" es requerido',
                'country.min' => 'El campo "País" tiene como mínimo 3(tres) caracteres',
                'number.required' => 'El campo "Número" es requerido',
                'number.integer' => 'El campo "Número" es un número entero',
                'number.min' => 'El campo "Número" es como mínimo 1(uno)',
                'postcode.required' => 'El campo "Código Postal" es requerido',
                'postcode.integer' => 'El campo "Código Postal" es un número entero',
                'postcode.min' => 'El campo "Código Postal" es como mínimo 1(uno)', 
            ]);
            $this->newaddress=new Domiciledelivery;
            $this->newaddress->street=$this->street;
            $this->newaddress->number=$this->number;
            $this->newaddress->location=$this->location;
            $this->newaddress->province=$this->province;
            $this->newaddress->country=$this->country;
            $this->newaddress->postcode=$this->postcode;
            $this->newaddress->client_id=$this->customer_id;
            $this->newaddress->save();
        }
        $this->validate([
            'deadline' => 'required|date|after:today',
            'customer_id' => 'required',
        ],[
            'deadline.required' => 'El campo "Fecha estimada de entrega" es requerido',
            'deadline.date' => 'El campo "Fecha estimada de entrega" debe ser una fecha',
            'deadline.after' => 'El campo "Fecha estimada de entrega" debe ser una fecha después de hoy',
            'customer_id.required' => 'Por favor seleccione un cliente'
        ]);
        $this->usd_price=$this->total;
        $this->arp_price=$this->total*$this->ar_price;
        $this->date=Carbon::now();
        $this->order=new Clientorder;
        $this->order->customer_id = $this->customer_id;
        $this->order->customer_name = $this->namecust;
        $this->order->date = $this->date;
        $this->order->deadline = $this->deadline;
        $this->order->order_state = 1;
        $this->order->buys=1;
        $this->order->usd_price = $this->usd_price;
        $this->order->arp_price = $this->arp_price;
        if($this->addaddress==true){
            $this->order->deliverydomicile_id=$this->newaddress->id;
            $this->order->save();
            $this->addadress=false;
        }else{
            if($this->address_id==null){
            $this->order->deliverydomicile_id=$this->address->first()->id;
            $this->order->save();
            }else{
            $this->order->deliverydomicile_id=$this->address->id;
            $this->order->save();
            }
        }
        if($this->details){
            foreach($this->details as $detail){
                $this->cantidad=$detail[2];
                $this->validate([
                    'cantidad' => 'required|integer|min:0',
                ],[
                    'cantidad.required' => 'El campo "Cantidad" es requerido',
                    'cantidad.integer' => 'El campo "Cantidad" debe ser un entero',
                    'cantidad.min' => 'El campo "Cantidad" debe ser como mínimo 1(Uno)',
                    'cantidad.max' => 'El campo "Cantidad" debe ser como máximo 1000000(Un millon)',
                ]);
                $this->newdetail=new Orderdetail;
                $this->newdetail->clientorder_id=$this->order->id;
                $this->newdetail->installation_id=$detail[0];
                $this->newdetail->unit_price_usd=$detail[1];
                $this->newdetail->cantidad=$this->cantidad;
                $this->newdetail->save();
            }
        }
        $this->cantidad=0;
        if($this->funcion=="ordernew"){
            $this->emit('explorar', $this->customer_id);
        }else{
            $this->funcion="list";
            $this->reset();
        }
        
    }
    public function selectinstallation(Installation $install)
    {
        $this->codei=$install->code;
        $this->descriptioni=$install->description;
        $this->usd_price_i=$install->usd_price;
        $this->dispatchBrowserEvent('show-form');
    }
    public function addinstallation()
    {
        $this->validate([
            'cant' => 'required|integer|min:1|max:1000000'
        ],[
            'cant.required' => 'El campo "Cantidad" es requerido',
            'cant.integer' => 'El campo "Cantidad" debe ser un entero',
            'cant.min' => 'El campo "Cantidad" debe ser como mínimo 1(Uno)',
            'cant.max' => 'El campo "Cantidad" debe ser como máximo 1000000(Un millon)',
        ]);
        foreach($this->details as $detail){
            if($detail[0]==$this->codei){
                $this->downinstallation($detail[3],$detail[1],$detail[2]);
            }        
        }
        $this->detail[0]=$this->codei;
        $this->detail[1]=$this->usd_price_i;
        $this->detail[2]=$this->cant;
        $this->detail[3]=$this->count;
        $this->details[$this->count]=$this->detail;
        $this->total=$this->total+$this->detail[1]*$this->detail[2];
        $this->count=$this->count+1;
        $this->cant=0;
        $this->dispatchBrowserEvent('hide-form');
    }
    public function addinstallationup()
    {
        $this->validate([
            'cant' => 'required|integer|min:1|max:1000000'
        ],[
            'cant.required' => 'El campo "Cantidad" es requerido',
            'cant.integer' => 'El campo "Cantidad" debe ser un entero',
            'cant.min' => 'El campo "Cantidad" debe ser como mínimo 1(Uno)',
            'cant.max' => 'El campo "Cantidad" debe ser como máximo 1000000(Un millon)',
        ]);
        foreach($this->details as $detail){
            if($detail[0]==$this->codei){
                $this->downinstallation($detail[3],$detail[1],$detail[2]);
            }        
        }
        $this->detail[0]=$this->codei;
        $this->detail[1]=$this->usd_price_i;
        $this->detail[2]=$this->cant;
        $this->detail[3]=$this->count;
        $this->details[$this->count]=$this->detail;
        $this->total=$this->total+$this->detail[1]*$this->detail[2];
        round($this->total,2);
        $this->count=$this->count+1;
        $this->cant=0;
        $this->dispatchBrowserEvent('hide-form');
    }

    public function downinstallation($algo,$detailpu,$detailcant)
    {
        $this->total=$this->total-$detailcant*$detailpu; 
        unset($this->details[$algo]);
        if($this->funcion!="ordernew" && empty($this->details)){
            $this->total=0;
        } 
    }

    public function explora(Clientorder $clientorder)
    {
        $this->order=$clientorder;
        $this->details=Orderdetail::where('clientorder_id', $clientorder->id)->get();
        if($this->explora=='inactivo'){
            $this->explora='activo';
            $this->funcion="0";
        }
        $this->customer=Customer::find($clientorder->customer_id);
        $this->address=DomicileDelivery::find($clientorder->deliverydomicile_id);
    }

    public function volver()
    {
        $this->funcion="list";
        $this->explora='inactivo';
        $this->reset();
    }

    public function funcion()
    {
        $this->funcion="orderfromorder";
    }

    public function selectcustomer(Customer $client)
    {
        if($this->selectcustomer==false){
            $this->selectcustomer=true;
            $this->customer=$client;
            $this->namecust=$client->name;
            $this->customer_id=$client->id;
            $this->selectaddress($client);
        }else{
            $this->selectcustomer=false;
            $this->customer=null;
            $this->namecust=null;
            $this->customer_id=null;
        }
    }

    public function selectaddress(Customer $client)
    {
        $this->address=DomicileDelivery::where('client_id',$client->id)->get();
    }

    public function selectadd(DomicileDelivery $address)
    {
        $this->selectaddress=true;
        $this->address_id=$address->id;
        $this->address=DomicileDelivery::find($this->address_id);
    }

    public function cancelaradd(Customer $client)
    {
        $this->address=DomicileDelivery::where('client_id',$client->id)->get();
        $this->selectaddress=false;
    }

    public function addaddress()
    {
        $this->addaddress=true;
    }
    public function destruir(Clientorder $order)
    {
            $this->dispatchBrowserEvent('show-borrar');
            $this->order=$order;
    }
    public function delete()
    {
        $this->order->delete();
        $this->dispatchBrowserEvent('deleted');
        return redirect()->to('pedidos');
    }

    public function addinstallationtoorder(Clientorder $order)
    {
            unset($this->details[0]);
            $this->count=0;
            $this->order=$order;
            $this->funcion="addinstallationtoorder";
            $this->explora="inactivo";
    }

    public function volverorder()
    {
        $this->explora($this->order);
    }

    public function update(Clientorder $order)
    {
        if($order->order_state==1){
            $this->order_id=$order->id;
            $this->deadline = $order->deadline;
            $this->total=$order->usd_price;
            $this->address=DomicileDelivery::find($order->deliverydomicile_id);
            $this->detailcollect=Orderdetail::where('clientorder_id', $order->id)->get();
            $this->customer=Customer::find($order->customer_id);
            if($this->customer){
                $this->namecust=$this->customer->name;
            }
            $this->update =true;
            $this->funcion="ordernew";
        }
            $this->selectaddress=true;
            $this->installid=false;
    }

    public function updatecantidad(Orderdetail $detail)
    {
        $this->installid=true;
        $this->detailup=$detail;
        $this->upusd=$detail->unit_price_usd;
        $this->codinstall=$detail->installation_id;
        $this->detail_id=$detail->id;
        $this->cantidad=$detail->cantidad;
        $this->dispatchBrowserEvent('show-form');
    }

    public function nuevacantidad(Orderdetail $detail)
    {
            $this->validate([
                'cantidad' => 'required|integer|min:1|max:1000000',
            ],[
                'cantidad.required' => 'El campo "Cantidad" es requerido',
                'cantidad.integer' => 'El campo "Cantidad" debe ser un entero',
                'cantidad.min' => 'El campo "Cantidad" debe ser como mínimo 1(Uno)',
                'cantidad.max' => 'El campo "Cantidad" debe ser como máximo 1000000(Un millon)',
            ]);
        $this->newdetail=Orderdetail::find($detail->id);
        $this->newdetail->cantidad=$this->cantidad;
        $this->newdetail->save();
        $this->newtotal=0;
        $this->order=Clientorder::find($detail->clientorder_id);
        $details=Orderdetail::where("clientorder_id", $this->order->id)->get();
        foreach($details as $detail){
            $this->newtotal=$this->newtotal+$detail->unit_price_usd*$detail->cantidad;
        }
        $this->usd_price=$this->newtotal;
        $this->arp_price=$this->newtotal*$this->ar_price;
        $this->validate([
            'usd_price' => 'required|numeric|min:0|max:100000000',
            'arp_price' => 'required|numeric|min:0|max:100000000',
        ],[
            'usd_price.required' => 'El campo "Precio U$D" es requerido',
            'arp_price.required' => 'El campo "Precio AR$" es requerido',
            'usd_price.numeric' => 'El campo "Precio U$D" es numérico',
            'arp_price.numeric' => 'El campo "Precio AR$" es numérico',
            'usd_price.min' => 'El campo "Precio U$D" es como mínimo 0(cero)',
            'arp_price.min' => 'El campo "Precio AR$" es como mínimo 0(cero)',
            'usd_price.max' => 'El campo "Precio U$D" es como máximo 100000000(cien millones)',
            'arp_price.max' => 'El campo "Precio AR$" es como máximo 100000000(cien millones)',
        ]);
        $this->order->usd_price=$this->usd_price;
        $this->order->arp_price=$this->arp_price;
        $this->order->save();
        $this->update($this->order);
        $this->dispatchBrowserEvent('hide-form');
    }

    public function editar(int $detail)
    {
        $this->order=Clientorder::find($detail);
        if($this->nuevafecha==true){
            $this->order->deadline = $this->deadline1;
        }
        if($this->addaddress==true){
            $this->validate([
                'street' => 'required|string|min:4',
                'number' => 'required|numeric|min:1',
                'location' => 'required|string|min:4',
                'province' => 'required|string|min:4',
                'country' => 'required|string|min:3',
                'postcode' => 'required|numeric|min:1',
            ],[
                'street.required' => 'El campo "Calle" es requerido',
                'street.min' => 'El campo "Calle" tiene como mínimo 4(cuatro) caracteres',
                'location.required' => 'El campo "Localidad" es requerido',
                'location.min' => 'El campo "Localidad" tiene como mínimo 4(cuatro) caracteres',
                'province.required' => 'El campo "Provincia" es requerido',
                'province.min' => 'El campo "Provincia" tiene como mínimo 4(cuatro) caracteres',
                'country.required' => 'El campo "País" es requerido',
                'country.min' => 'El campo "País" tiene como mínimo 3(tres) caracteres',
                'number.required' => 'El campo "Número" es requerido',
                'number.integer' => 'El campo "Número" es numérico',
                'number.min' => 'El campo "Número" es como mínimo 1(uno)',
                'postcode.required' => 'El campo "Código Postal" es requerido',
                'postcode.integer' => 'El campo "Código Postal" es numérico',
                'postcode.min' => 'El campo "Código Postal" es como mínimo 1(uno)', 
            ]);
            $this->newaddress=new Domiciledelivery;
            $this->newaddress->street=$this->street;
            $this->newaddress->number=$this->number;
            $this->newaddress->location=$this->location;
            $this->newaddress->province=$this->province;
            $this->newaddress->country=$this->country;
            $this->newaddress->postcode=$this->postcode;
            $this->newaddress->client_id=$this->order->customer_id;
            $this->newaddress->save();
            $this->order->deliverydomicile_id=$this->newaddress->id;
            $this->addadress=false;
        }else{
        $this->order->deliverydomicile_id=$this->address->id;
        }
        $this->usd_price= $this->total;
        $this->arp_price= $this->total*$this->ar_price;
        $this->validate([
            'usd_price' => 'required|numeric|min:0|max:100000000',
            'arp_price' => 'required|numeric|min:0|max:100000000',
        ],[
            'usd_price.required' => 'El campo "Precio U$D" es requerido',
            'arp_price.required' => 'El campo "Precio AR$" es requerido',
            'usd_price.numeric' => 'El campo "Precio U$D" es numérico',
            'arp_price.numeric' => 'El campo "Precio AR$" es numérico',
            'usd_price.min' => 'El campo "Precio U$D" es como mínimo 0(cero)',
            'arp_price.min' => 'El campo "Precio AR$" es como mínimo 0(cero)',
            'usd_price.max' => 'El campo "Precio U$D" es como máximo 100000000(cien millones)',
            'arp_price.max' => 'El campo "Precio AR$" es como máximo 100000000(cien millones)',
        ]);
        $this->order->usd_price=$this->usd_price;
        $this->order->arp_price=$this->arp_price;
        $this->order->save();
        foreach($this->details as $detail){
            $this->cantidad=$detail[2];
            $this->validate([
                'cantidad' => 'required|integer|min:1|max:100000000',
            ],[
                'cantidad.required' => 'El campo "Cantidad" es requerido',
                'cantidad.integer' => 'El campo "Cantidad" debe ser un entero',
                'cantidad.min' => 'El campo "Cantidad" debe ser como mínimo 1(Uno)',
                'cantidad.max' => 'El campo "Cantidad" debe ser como máximo 1000000(Un millon)',
            ]);
            $this->newdetail=new Orderdetail;
            $this->newdetail->clientorder_id=$this->order->id;
            $this->newdetail->installation_id=$detail[0];
            $this->newdetail->unit_price_usd=$detail[1];
            $this->newdetail->cantidad=$this->cantidad;
            $this->newdetail->save();
        }
            $this->funcion="list";
            $this->reset();
    }

    public function cancelarfecha(){
        $this->nuevafecha=false;
    }
    public function nuevafecha()
    {
        $this->nuevafecha=true;
    }
    public function cancelarnewadd()
    {
        $this->addaddress=false;
    }
    public function cancelacantidad()
    {
        $this->installid=false;
    }
}
