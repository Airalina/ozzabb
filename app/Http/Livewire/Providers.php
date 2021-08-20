<?php

namespace App\Http\Livewire;
use App\Models\Provider;
use Livewire\Component;

class Providers extends Component
{
    public $funcion="", $id_provider, $idu, $providers, $provider, $search, $name, $address, $phone, $email, $contact_name, $point_contact, $site_url, $status=1, $explora='inactivo',  $order='name';
    
    public function render()
    {
         
        $this->providers = Provider::where('name','LIKE','%'.$this->search.'%')
        ->orWhere('address','LIKE','%'.$this->search.'%')
        ->orWhere('phone','LIKE','%'.$this->search.'%')
        ->orWhere('email','LIKE','%'.$this->search.'%')
        ->orWhere('contact_name','LIKE','%'.$this->search.'%')
        ->orWhere('point_contact','LIKE','%'.$this->search.'%')
        ->orWhere('site_url','LIKE','%'.$this->search.'%')
        ->orderBy($this->order)->get();

    return view('livewire.providers');
    }

    public function funcion()
    {
        $this->funcion="crear";
        $this->id_provider=null;
        $this->name=null;
        $this->address=null;
        $this->phone=null;
        $this->email=null;
        $this->contact_name=null;
        $this->point_contact=null;
        $this->site_url=null;
    }

    public function store(){
        
        
        $this->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'email' => 'required|unique:providers,email|email',
        ]);
        Provider::create([
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'contact_name'=>$this->contact_name,
            'point_contact'=>$this->point_contact,
            'site_url'=>$this->site_url,
            'status'=>$this->status
        ]);
        $this->funcion="";
    }

    public function back(){
        $this->funcion="";    
    }

    public function explorar(Provider $provider_id){
        $this->provider_id=$provider_id;
        $this->provider=Provider::where('id', $this->provider_id->id)->first();
        if($this->explora=='inactivo'){
            $this->explora='activo';
            $this->funcion=" ";
        }
    }

    public function update(Provider $provider)
    { 
        $this->idu=$provider->id;
        $this->name=$provider->name;
        $this->address=$provider->address;
        $this->phone=$provider->phone;
        $this->email=$provider->email;
        $this->contact_name=$provider->contact_name;
        $this->point_contact=$provider->point_contact;
        $this->site_url=$provider->site_url;
        $this->status=$provider->status;
        $this->funcion="actualizar";
        $this->explora="inactivo";
    }

    public function editar(){
        
        $this->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'email' => ['required', 'email', 'unique:providers,email,'.$this->idu.''],
        ]);
        
        $provider_up =Provider::find($this->idu);
        $provider_up->name=$this->name;
        $provider_up->address=$this->address;
        $provider_up->phone=$this->phone;
        $provider_up->email=$this->email;
        $provider_up->contact_name=$this->contact_name;
        $provider_up->point_contact=$this->point_contact;
        $provider_up->site_url=$this->site_url;
        $provider_up->status=$this->status;

        $provider_up->save();
        $this->funcion="";
    }
    
    public function destruir(Provider $provider)
    {
        if (auth()->user()->cannot('delete', auth()->user())) {
            abort(403);
        }else
        {
            $provider->delete();
            $this->funcion="";
            $this->explora="inactivo";
        }
    }
}
