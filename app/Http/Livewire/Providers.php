<?php

namespace App\Http\Livewire;
use App\Models\Provider;
use App\Models\Material;
use App\Models\Price;
use App\Models\ProviderPrice;
use Livewire\Component;


class Providers extends Component
{
    public $funcion="", $mat_n,$id_provider, $idu, $providers, $provider, $search, $name, $address, $phone, $email, $contact_name, $point_contact, $site_url, $status=1, $explora='inactivo',  $order='name', $materials;
    public $code, $validar, $amount, $name_material, $material, $id_material, $material_up, $stock, $unit, $presentation, $usd_price, $ars_price, $prices, $price, $info_mat, $provider_prices, $id_provider_price;

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
        $this->explora='inactivo';   
    }

    public function explorar(Provider $provider_id){
        $this->provider_id=$provider_id;
        $this->provider=Provider::where('id', $this->provider_id->id)->first();
        $this->provider_prices=ProviderPrice::where('provider_id', $this->provider->id)->get();
        $this->prices=Price::where('provider_id', $this->provider->id)->get();
        
        
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

    public function agregamat(Provider $provider){
       
        $this->amount=null;
        $this->unit=null;
        $this->presentation=null;
        $this->material=null;
        $this->usd_price=null;
        $this->ars_price=null;
        $this->info_mat = Material::all();
        $this->mat_n = null;

        $this->explora='inactivo';
        $this->funcion="crearmat";    
    }

    public function storemat(Provider $provider){
        
        $this->validar= $this->validate([
            'amount' => 'required|numeric|integer',
            'unit' => 'required|numeric',
            'presentation' => 'required',
            'usd_price' => 'required|numeric',
            'ars_price' => 'required|numeric',
            'material' => 'required|numeric',
        ], [
            'amount.required' => 'El campo cantidad es requerido',
            'amount.numeric' => 'El campo cantidad debe ser numérico',
            'amount.required' => 'El campo cantidad debe ser un número entero',
            'unit.required' => 'El campo unidad es requerido',
            'unit.numeric' => 'El campo unidad debe ser numérico',
            'presentation.required' => 'Seleccione una opción para el campo de la unidad de presentación',
            'usd_price.required' => 'El campo precio U$D es requerido',
            'usd_price.numeric' => 'El campo precio U$D debe ser numérico',
            'ars_price.required' => 'El campo precio AR$ es requerido',
            'ars_price.numeric' => 'El campo precio AR$ es numérico',
            'material.required' => 'Seleccione una opción para el campo de materiales',
            'material.numeric' => 'Seleccione una opción para el campo de materiales',
       
        ]);

        
       $provider_price= ProviderPrice::create([
            'provider_id' =>$provider->id,
            'material_id' =>$this->material,
            'amount' =>$this->amount,
            'unit' =>$this->unit,
            'presentation' =>$this->presentation,
            'usd_price' =>$this->usd_price,
            'ars_price' =>$this->ars_price,
            
        ]);
        $price= Price::create([
             'date' => date("d-m-Y"),
             'provider_price_id' => $provider_price->id,
             'provider_id' =>$provider->id,
             'price' =>$this->usd_price,
        ]);
        
        $this->funcion="0";
        $this->explorar($provider);

    }
    public function destruirmat(Material $material)
    {
            $material->delete();
            $this->funcion="0";
            $this->explorar($this->provider);
    }
    public function updatemat(ProviderPrice $provider_price)
    {   ;
       
        $this->id_provider_price = $provider_price->id;
        $this->material=$provider_price->material_id;
        $this->id_provider=$provider_price->provider_id;
        $this->amount=$provider_price->amount;
        $this->unit=$provider_price->unit;
        $this->presentation=$provider_price->presentation;
        $this->usd_price=$provider_price->usd_price;
        $this->ars_price=$provider_price->ars_price;;
        $this->mat_n = $provider_price->material;
        $this->info_mat = Material::all();
        $this->explora= 'inactivo';
        $this->funcion="actualizarmat";
    }

    public function editarmat(){
        
      $this->validar=  $this->validate([
            'amount' => 'required|numeric|integer',
            'unit' => 'required|numeric',
            'presentation' => 'required',
            'usd_price' => 'required|numeric',
            'ars_price' => 'required|numeric',
        ], [
            'amount.required' => 'El campo cantidad es requerido',
            'amount.numeric' => 'El campo cantidad debe ser numérico',
            'amount.integer' => 'El campo cantidad debe ser un número entero',
            'unit.required' => 'El campo unidad es requerido',
            'unit.numeric' => 'El campo unidad debe ser numérico',
            'presentation.required' => 'Seleccione una opción para el campo de la unidad de presentación',
            'usd_price.required' => 'El campo precio U$D es requerido',
            'usd_price.numeric' => 'El campo precio U$D debe ser numérico',
            'ars_price.required' => 'El campo precio AR$ es requerido',
            'ars_price.numeric' => 'El campo precio AR$ es numérico',
            'material.numeric' => 'Seleccione una opción para el campo de materiales',
        ]);
        $provider =Provider::find($this->id_provider);
        $material_up =ProviderPrice::find($this->id_provider_price);
        $material_up->amount=$this->amount; 
        $material_up->material_id=$this->material;
        $material_up->provider_id=$this->id_provider;
        $material_up->unit=$this->unit;
        $material_up->presentation=$this->presentation;
        $material_up->ars_price=$this->ars_price;
       if($material_up->usd_price != $this->usd_price){
            $price= Price::create([
                'date' => date("d-m-Y"),
                'provider_price_id' => $this->id_provider_price,
                'provider_id' =>$this->id_provider,
                'price' =>$this->usd_price,
            ]);
       }
       $material_up->usd_price = $this->usd_price;
        $material_up->save();
        $this->funcion="0";
        $this->explorar($provider);
    }
    public function backmat(){
        $this->funcion="0";
        $this->explora='activo';   
    }

}
