<?php

namespace App\Http\Livewire;
use App\Models\Orderdetail;
use App\Models\Installation;
use App\Models\Clientorder;
use App\Models\DomicileDelivery;
use App\Models\Customer;
use Livewire\Component;
use Carbon\Carbon;

class Ordenesclientes extends Component
{
    public $orders, $order, $idp, $funcion="list", $namecust, $customer_id, $date, $deadline, $deadline1, $start_date, $buys, $order_state, $order_job, $usd_price, $arp_price, $search;
    public $codinstall, $upusd, $installid=false, $cant, $cantidad=0, $total=0, $newdetail, $explora="inactivo", $searchclient="", $custormers, $searchinstallation="", $installations;
    public  $customer, $customers, $usd=180, $count=0, $address, $address_id, $countaddress, $selectcustomer=false, $update=false, $addaddress=false, $selectaddress=false, $newaddress;
    Public $street, $number, $newtotal=0, $location, $province, $country, $postcode, $detailcollect, $order_id, $detail_id, $nuevafecha=false;
    public $detail=array(), $detailup;
    public $details=array();
    protected $listeners =[
        'newOrder'
        ];
    protected $dates = ['deadline'];

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
        $this->orders=Clientorder::where('id','LIKE','%' . $this->search . '%')
        ->orWhere('customer_id','LIKE','%'.$this->search.'%')
        ->orWhere('customer_name','LIKE','%'.$this->search.'%')
        ->orWhere('date','LIKE','%'.$this->search.'%')
        ->orWhere('deadline','LIKE','%'.$this->search.'%')
        ->orWhere('start_date','LIKE','%'.$this->search.'%')
        ->orWhere('buys','LIKE','%'.$this->search.'%')
        ->orWhere('order_job','LIKE','%'.$this->search.'%')->orderBy('order_state')->get();
        return view('livewire.ordenesclientes');
    }

    

    public function storepedido()
    {
       
        $this->usd_price=$this->total;
        $this->arp_price=$this->total*$this->usd;
        $this->validate([
            'usd_price' => 'required|numeric|min:0',
            'arp_price' => 'required|numeric|min:0',
        ]);
        $this->date=Carbon::now();
        $this->order=new Clientorder;
        $this->order->customer_id = $this->customer_id;
        $this->order->customer_name = $this->namecust;
        $this->order->date = $this->date;
        $this->order->deadline = $this->deadline;
        $this->order->order_state = 1;
        $this->order->usd_price = $this->usd_price;
        $this->order->arp_price = $this->arp_price;
        $this->order->save();
        foreach($this->details as $detail){
            $this->cantidad=$detail[2];
            $this->validate([
                'cantidad' => 'required|integer|min:0',
            ]);
            $this->newdetail=new Orderdetail;
            $this->newdetail->clientorder_id=$this->order->id;
            $this->newdetail->material_id=$detail[0];
            $this->newdetail->unit_price_usd=$detail[1];
            $this->newdetail->cantidad=$this->cantidad;
            $this->newdetail->save();
        }
        if($this->addaddress==true){
            $this->validate([
                'street' => 'required|string|min:4',
                'number' => 'required|numeric|min:0',
                'location' => 'required|string|min:4',
                'province' => 'required|string|min:4',
                'country' => 'required|string|min:3',
                'postcode' => 'required|numeric|min:0',
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
            $this->addadress=false;
            $this->order->deliverydomicile_id=$this->newaddress->id;
            $this->order->save();
        }else{
            $this->order->deliverydomicile_id=$this->address_id;
            $this->order->save();
        }
        $this->cantidad=0;
        return redirect()->to('/pedidos');

    }

    public function addinstallation(Installation $install)
    {
        $this->detail[0]=$install->code;
        $this->detail[1]=$install->usd_price;
        $this->detail[2]=$this->cant;
        $this->detail[3]=$this->count;
        $this->details[]=$this->detail;
        $this->total=$this->total+$this->detail[1]*$this->detail[2];
        $this->count=$this->count+1;
        $this->cant=0;
    }

    public function downinstallation($algo,$detailpu,$detailcant)
    {
        $this->count=$this->count-1;
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
        $this->address=DomicileDelivery::find($this->order->deliverydomicile_id);
    }

    public function volver()
    {
        $this->funcion="list";
        $this->explora='inactivo';
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
        $this->address=DomicileDelivery::find($address->id);
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

    public function deleteorder(Clientorder $order)
    {
        $order->delete();
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
        $this->customer=Customer::find($order->customer_id);
        $this->namecust=$this->customer->name;
        $this->deadline = $order->deadline;
        $this->total=$order->usd_price;
        $this->address=DomicileDelivery::find($order->deliverydomicile_id);
        $this->detailcollect=Orderdetail::where('clientorder_id', $order->id)->get();
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
        $this->codinstall=$detail->material_id;
        $this->detail_id=$detail->id;
        $this->cantidad=$detail->cantidad;
    }

    public function nuevacantidad(Orderdetail $detail)
    {
            $this->validate([
                'cantidad' => 'required|integer|min:0',
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
        $this->arp_price=$this->newtotal*$this->usd;
        $this->validate([
            'usd_price' => 'required|numeric|min:0',
            'arp_price' => 'required|numeric|min:0',
        ]);
        $this->order->usd_price=$this->usd_price;
        $this->order->arp_price=$this->arp_price;
        $this->order->save();
        $this->update($this->order);

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
                'number' => 'required|numeric|min:0',
                'location' => 'required|string|min:4',
                'province' => 'required|string|min:4',
                'country' => 'required|string|min:3',
                'postcode' => 'required|numeric|min:0',
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
        $this->arp_price= $this->total*$this->usd;
        $this->validate([
            'usd_price' => 'required|numeric|min:0',
            'arp_price' => 'required|numeric|min:0',
        ]);
        $this->order->usd_price=$this->usd_price;
        $this->order->arp_price=$this->arp_price;
        $this->order->save();
        foreach($this->details as $detail){
            $this->cantidad=$detail[2];
            $this->validate([
                'cantidad' => 'required|integer|min:0',
            ]);
            $this->newdetail=new Orderdetail;
            $this->newdetail->clientorder_id=$this->order->id;
            $this->newdetail->material_id=$detail[0];
            $this->newdetail->unit_price_usd=$detail[1];
            $this->newdetail->cantidad=$this->cantidad;
            $this->newdetail->save();
        }

    }

    public function cancelarfecha(){
        $this->nuevafecha=false;
    }
    public function nuevafecha()
    {
        $this->nuevafecha=true;
    }
    public function cancelacantidad()
    {
        $this->installid=false;
    }
}
