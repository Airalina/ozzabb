<?php

namespace App\Http\Livewire;
use App\Models\Customer;
use App\Models\DomicileDelivery;
use Livewire\Component;

class Clientes extends Component
{
    public $funcion="", $idcli, $clientes, $cliente, $search, $name, $phone, $email, $domicile_admin, $contact, $post_contact, $estado=true;
    public $street, $location, $number, $province, $country, $postcode, $client_id, $explora='inactivo',$domicilios=[];
    public function render()
    {
        $this->clientes=Customer::where('name','LIKE','%' . $this->search . '%')
        ->orWhere('domicile_admin','LIKE','%'.$this->search.'%')
        ->orWhere('id','LIKE','%'.$this->search.'%')
        ->orWhere('phone','LIKE','%'.$this->search.'%')
        ->orWhere('contact','LIKE','%'.$this->search.'%')
        ->orWhere('post_contact','LIKE','%'.$this->search.'%')
        ->orWhere('email','LIKE','%'.$this->search.'%')->get();
        return view('livewire.clientes');
    }

    public function volver(){
        $this->funcion="";
        $this->explora='inactivo';
    }

    public function funcion(){
        $this->explora='inactivo';
        $this->funcion="crear";
        
    }

    public function agregadom(){
        $this->explora='inactivo';
        $this->funcion="creardom";    
    }

    public function store(){
        Customer::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone'=>$this->phone,
            'domicile_admin'=>$this->domicile_admin,
            'contact'=>$this->contact,
            'post_contact'=>$this->post_contact,
            'estado'=>$this->estado
        ]);
        $this->cliente=Customer::where('domicile_admin', ''.$this->domicile_admin.'')->get();
        foreach($this->cliente as $client){
            $this->storedir($client);
        }
        
        
    }

    public function storedir(Customer $cliente){
        
        DomicileDelivery::create([
            'street' =>$this->street,
            'number' =>$this->number,
            'location' =>$this->location,
            'province' =>$this->province,
            'country' =>$this->country,
            'postcode' =>$this->postcode,
            'client_id' =>$cliente->id
        ]);
        $this->funcion="0";
        $this->explorar($cliente);

    }

    public function explorar(Customer $cliente){
        $this->cliente=$cliente;
        $this->domicilios=DomicileDelivery::where('client_id', $this->cliente->id)->get();
        if($this->explora=='inactivo'){
            $this->explora='activo';
            $this->funcion="0";
        }
    }

    public function update(Customer $cliente)
    { 
        $this->idcli=$cliente->id;
        $this->name=$cliente->name;
        $this->phone=$cliente->phone;
        $this->contact=$cliente->contact;
        $this->post_contact=$cliente->post_contact;
        $this->email=$cliente->email;
        $this->domicile_admin=$cliente->domicile_admin;
        $this->estado=$cliente->estado;
        $this->funcion="adaptar";
        $this->explora="inactivo";
    }

    public function cancelarup(){
        $this->funcion="0";
        $this->explora="activo";
    }

    public function editar()
    {
        $cliente =Customer::find($this->idcli);
        $cliente->name=$this->name;
        $cliente->phone=$this->phone;
        $cliente->contact=$this->contact;
        $cliente->post_contact=$this->post_contact;
        $cliente->email=$this->email;
        $cliente->domicile_admin=$this->domicile_admin;
        $cliente->estado=$this->estado;
        $cliente->save();
        $this->funcion="0";
        $this->explorar($cliente);
    }

    public function destruir(Customer $cliente)
    {
            $cliente->delete();
            $this->funcion="";
            $this->explora="inactivo";
    }

    public function destruirdir(DomicileDelivery $direccion)
    {
            $direccion->delete();
            $this->funcion="0";
            $this->explorar($this->cliente);
    }

}
