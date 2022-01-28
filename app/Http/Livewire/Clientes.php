<?php

namespace App\Http\Livewire;
use App\Models\Customer;
use App\Models\DomicileDelivery;
use App\Models\Clientorder;
use Livewire\Component;
use Livewire\WithPagination;

class Clientes extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $clientes;
    public $funcion="", $idcli, $cliente, $paginas=25, $search, $name, $phone, $email, $domicile_admin, $contact, $post_contact, $estado=true;
    public $street, $location, $number, $province, $country, $postcode, $client_id, $historial, $explora='inactivo',$domicilios, $cuit, $order="name";
    protected $listeners =[
        'explorar'
        ];
    protected $dates = ['deadline', 'date', 'start_date'];
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $this->clientes=Customer::where('name','LIKE','%' . $this->search . '%')
        ->orWhere('domicile_admin','LIKE','%'.$this->search.'%')
        ->orWhere('id','LIKE','%'.$this->search.'%')
        ->orWhere('phone','LIKE','%'.$this->search.'%')
        ->orWhere('contact','LIKE','%'.$this->search.'%')
        ->orWhere('post_contact','LIKE','%'.$this->search.'%')
        ->orWhere('cuit','LIKE','%'.$this->search.'%')
        ->orWhere('email','LIKE','%'.$this->search.'%')->orderBy($this->order)->paginate($this->paginas);
        return view('livewire.clientes',[
            'clientes' => $this->clientes,
        ]);
    }

    public function volver(){
        $this->funcion="";
        $this->explora='inactivo';
    }

    public function funcion(){
        $this->resetValidation();
        $this->name=null;
        $this->email=null;
        $this->phone=null;
        $this->domicile_admin=null;
        $this->contact=null;
        $this->post_contact=null;
        $this->estado=null;
        $this->street=null;
        $this->number=null;
        $this->cuit=null;
        $this->province=null;
        $this->country=null;
        $this->postcode=null;
        $this->explora='inactivo';
        $this->funcion="crear";
        
    }

    public function agregadom(){
        $this->street=null;
        $this->number=null;
        $this->location=null;
        $this->province=null;
        $this->country=null;
        $this->postcode=null;
        $this->explora='inactivo';
        $this->funcion="creardom";    
    }

    public function store(){
        $this->validate([
            'name' => 'required|string|min:5',
            'email' => 'required|unique:customers,email|email',
            'contact' => 'required|string|min:6',
            'phone' => 'required|integer|min:1000000000',
            'post_contact' => 'required|string|min:3',
            'domicile_admin' => 'required|string|min:5',
            'street' => 'required|string|min:4',
            'number' => 'required|integer|min:1',
            'location' => 'required|string|min:4',
            'province' => 'required|string|min:4',
            'country' => 'required|string|min:3',
            'postcode' => 'required|integer|min:1',
            'cuit' => 'required|integer|min:10000000000|max:99999999999',
        ],[
            'name.required' => 'El campo "Nombre" es requerido',
            'name.min' => 'El campo "Nombre" tiene como mínimo 5(cinco) caracteres',
            'email.required' => 'El campo "Email" es requerido',
            'email.unique' => 'Ya existe un cliente con esta direccion de email',
            'email.emial' => 'El email ingresado es incorrecto, verifique',
            'contact.required' => 'El campo "Contacto" es requerido',
            'contact.min' => 'El campo "Contacto" tiene como mínimo 6(seis) caracteres',
            'phone.required' => 'El campo "Teléfono" es requerido',
            'phone.integer' => 'El campo "Teléfono" es numérico',
            'phone.min' => 'El campo "Telefono" está incompleto',
            'post_contact.required' => 'El campo "Puesto/Cargo de contacto" es requerido',
            'post_contact.min' => 'El campo "Puesto/Cargo de contacto" tiene como mínimo 3(tres) caracteres',
            'domicile_admin.required' => 'El campo "Domicilio Administrativo" es requerido',
            'domicile_admin.min' => 'El campo "Domicilio Administrativo" tiene como mínimo 5(cinco) caracteres',
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
            'cuit.required' => 'El campo "C.U.I.T." es requerido',
            'cuit.integer' => 'El campo "C.U.I.T." debe ser entero',
            'cuit.min'=>'El valor ingresado en el campo "C.U.I.T." es incorrecto ej.:70498765431',
            'cuit.max'=>'El valor ingresado en el campo "C.U.I.T." es incorrecto ej.:70498765431'
        ]);
        Customer::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone'=>$this->phone,
            'domicile_admin'=>$this->domicile_admin,
            'contact'=>$this->contact,
            'post_contact'=>$this->post_contact,
            'estado'=>$this->estado,
            'cuit' => $this->cuit,
        ]);
        $this->cliente=Customer::where('domicile_admin', ''.$this->domicile_admin.'')->get();
        foreach($this->cliente as $client){
            $this->storedir($client);
        }
        
        
    }

    public function storedir(Customer $cliente){
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
        $this->historial=Clientorder::where('customer_id', $this->cliente->id)->latest()->take(10)->get();
        $this->cuit=$cliente->cuit;
        if($this->explora=='inactivo'){
            $this->explora='activo';
            $this->funcion="0";
        }
    }

    public function orderdetail(Clientorder $order){
        $this->historial=$order->orderdetails;
        $this->explora='inactivo';
        $this->funcion="exploraorder";
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
        $this->cuit=$cliente->cuit;
        if($this->explora=='inactivo')
        $this->funcion="adaptar";
        $this->explora="inactivo";
    }

    public function cancelarup(){
        $this->funcion="0";
        $this->explora="activo";
    }

    public function editar(){   
        $this->validate([
        'name' => 'required|string|min:5',
        'email' => ['required', 'email', 'max:255', 'unique:customers,email,'.$this->idcli.''],
        'contact' => 'required|string|min:6',
        'phone' => 'required|numeric|min:1000000000',
        'post_contact' => 'required|string|min:3',
        'domicile_admin' => 'required|string|min:5',
        'cuit' => 'required'
    ],[
        'name.required' => 'El campo "Nombre" es requerido',
        'name.min' => 'El campo "Nombre" tiene como mínimo 5(cinco) caracteres',
        'email.required' => 'El campo "Email" es requerido',
        'email.unique' => 'Ya existe un cliente con esta direccion de email',
        'email.emial' => 'El email ingresado es incorrecto, verifique',
        'contact.required' => 'El campo "Contacto" es requerido',
        'contact.min' => 'El campo "Contacto" tiene como mínimo 6(seis) caracteres',
        'phone.required' => 'El campo "Teléfono" es requerido',
        'phone.integer' => 'El campo "Teléfono" es numérico',
        'phone.min' => 'El campo "Telefono" está incompleto',
        'post_contact.required' => 'El campo "Puesto/Cargo de contacto" es requerido',
        'post_contact.min' => 'El campo "Puesto/Cargo de contacto" tiene como mínimo 3(tres) caracteres',
        'domicile_admin.required' => 'El campo "Domicilio Administrativo" es requerido',
        'domicile_admin.min' => 'El campo "Domicilio Administrativo" tiene como mínimo 5(cinco) caracteres',
        'cuit.required' => 'El campo cuit es requerido',
    ]);
        $cliente =Customer::find($this->idcli);
        $cliente->name=$this->name;
        $cliente->phone=$this->phone;
        $cliente->contact=$this->contact;
        $cliente->post_contact=$this->post_contact;
        $cliente->email=$this->email;
        $cliente->domicile_admin=$this->domicile_admin;
        $cliente->estado=$this->estado;
        $cliente->cuit=$this->cuit;
        $cliente->save();
        $this->funcion="0";
        $this->explorar($cliente);
    }

    public function destruir(Customer $cliente)
    {
            $this->dispatchBrowserEvent('show-borrar');
            $this->cliente=$cliente;
    }
    public function delete()
    {
        if($this->funcion=="" && $this->explora=="inactivo"){
            $this->cliente->delete();
            $this->funcion="";
            $this->explora="inactivo";
        }elseif($this->explora=="activo"){
            $this->direccion->delete();
            $this->funcion="0";
            $this->explorar($this->cliente);
        }
        $this->dispatchBrowserEvent('hide-borrar');
    }
    public function destruirdir(DomicileDelivery $direccion)
    {
        $this->dispatchBrowserEvent('show-borrar'); 
        $this->direccion=$direccion;
    }

    public function goOrder(Customer $client)
    {
        $this->emit('newOrder', $client->id);
        $this->funcion="neworder";
        $this->explora="inactivo";
    }

    public function volverexplora()
    {
        $this->explora='activo';
        $this->funcion="0";
    }
}
