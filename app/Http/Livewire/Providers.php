<?php

namespace App\Http\Livewire;
use App\Models\Provider;
use App\Models\Material;
use App\Models\Line;
use App\Models\Usage;
use App\Models\Terminal;
use App\Models\Seal;
use App\Models\Connector;
use App\Models\Cable;
use App\Models\Price;
use App\Models\ProviderPrice;
use Livewire\Component;


class Providers extends Component
{
    public $funcion="", $mat_n,$id_provider, $idu, $providers, $provider, $search, $name, $address, $phone, $email, $contact_name, $point_contact, $site_url, $status=1, $explora='inactivo',  $order='name', $materials;
    public $validar, $amount, $material, $id_material, $material_up, $unit, $presentation, $usd_price, $ars_price, $prices, $price, $info_mat, $provider_prices, $id_provider_price, $regex, $addMaterial;
    public $code, $name_material, $family, $terminal, $connector, $seal ,$color, $line_id, $usage_id, $replace_id, $stock_min, $stock, $line, $usage, $replace, $info_line, $info_usage, $info_term, $info_sell, $div, $info_con, $number_of_ways, $type, $size, $minimum_section, $maximum_section, $material_family, $material_replace;

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
        
        $regex = '/^((?:www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)$/'; 

        $this->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'email' => 'required|unique:providers,email|email',
            'phone' => 'numeric|nullable',
            'contact_name' => 'string|nullable',
            'site_url' => 'nullable|regex: '.$regex
        ], [
            'name.required' => 'El campo nombre es requerido',
            'name.string' => 'El campo nombre no debe tener números ni carácteres',
            'address.required' => 'El campo dirección es requerido',
            'email.required' => 'El campo correo electrónico para ventas es requerido',
            'email.unique' => 'El email correo electrónico para ventas ya se encuentra registrado',
            'email.email' => 'El campo correo electrónico para ventas debe ser un email',
            'phone.numeric' => 'El campo teléfono debe ser numérico',
            'contact_name' => 'El campo nombre de contacto no debe tener números ni carácteres',
            'site_url.regex' => 'El formato correcto para la url es: www.tupagina.com',
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
        
        $regex = '/^((?:www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)$/'; 

        $this->validate([
            'name' => 'required',
            'address' => 'required',
            'email' => ['required', 'email', 'unique:providers,email,'.$this->idu.''],
            'phone' => 'numeric',
            'site_url' => 'nullable|regex: '.$regex
        ], [
            'name.required' => 'El campo nombre es requerido',
            'name.string' => 'El campo nombre no debe tener números ni carácteres',
            'address.required' => 'El campo dirección es requerido',
            'email.required' => 'El campo correo electrónico para ventas es requerido',
            'email.unique' => 'El email correo electrónico para ventas ya se encuentra registrado',
            'email.email' => 'El campo correo electrónico para ventas debe ser un email',
            'phone.numeric' => 'El campo teléfono debe ser numérico',
            'contact_name' => 'El campo nombre de contacto no debe tener números ni carácteres',
            'site_url.regex' =>  'El formato correcto para la url es: www.tupagina.com',
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
        $this->code=null;
        $this->name_material=null;
        $this->family=null;
        $this->color=null;
        $this->replace=null;
        $this->stock_min=null;
        $this->stock=null;
        $this->usage=null;
        $this->terminal=null;
        $this->seal=null;
        $this->line=null;
        $this->number_of_ways=null;
        $this->type=null;
        $this->connector=null;
        $this->size=null;
        $this->minimum_section=null;
        $this->maximum_section=null;
        $this->usage_id=null;
        $this->line_id=null;
        $this->conn = null;
        $this->conn_id=null;
        $this->terminal_id=null;
        $this->seal_id=null;
        $this->connector_id=null;
        $this->term=null;
        $this->term_id=null;
        $this->size=null;
        $this->minimum_section=null;
        $this->maximum_section=null;
        $this->rplce = null;
        $this->images = null;
        $this->info_line=Line::all();
        $this->info_usage=Usage::all();
        $this->info_term=Terminal::all();
        $this->info_sell=Seal::all();
        $this->info_con=Connector::all();

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
          ]);

        if($this->addMaterial){
            
            $this->validate([
                'code' => 'required',
                'name_material' => 'required',
                'family' => 'required',
                'color' => 'required',
                'line' => 'required',
                'usage' => 'required',
                'replace' => 'nullable',
                'stock_min' => 'numeric|required',
                'stock' => 'numeric|required',
            ],[
                'code.required' => 'El campo código es requerido',
                'name_material.required' => 'El campo nombre es requerido',
                'family.required' => 'El campo familia es requerido',
                'color.required' => 'El campo color es requerido',
                'line.required' => 'Seleccione una opción para el campo de línea',
                'usage.required' => 'Seleccione una opción para el campo de uso',
                'stock_min.required' => 'El campo stock mínimo es requerido',
                'stock_min.numeric' => 'El campo stock mínimo es numérico',
                'stock.required' => 'El campo stock es requerido',
                'stock.numeric' => 'El campo stock es numérico',
            ]);
        
            if($this->family == 'Conectores'){
                $this->validate([
                    'terminal' => 'nullable',
                    'seal' => 'nullable',
                    'number_of_ways' => 'numeric|integer|digits:2|required',
                    'type' => 'required',
                    'connector' =>'nullable'
                ], [
                    'number_of_ways.numeric' => 'El campo cantidad de vías es numérico',
                    'number_of_ways.integer' => 'El campo cantidad de vías es un número natural',
                    'number_of_ways.digits' => 'El campo cantidad de vías debe ser un número natural de dos cifras',
                    'number_of_ways.required' => 'El campo cantidad de vías es requerido',
                    'type.required' => 'El campo tipo es requerido',
                ]);
                $this->material=Material::create([
                    'code' => $this->code,
                    'name' => $this->name_material,
                    'family' => $this->family,
                    'color' => $this->color,
                    'line_id'=>$this->line,
                    'usage_id'=>$this->usage,
                    'replace_id'=>$this->replace,
                    'stock_min'=>$this->stock_min,
                    'stock' => $this->stock,
                ]);
                
                Connector::create([
                    'material_id' => $this->material->id,
                    'terminal_id' => $this->terminal,
                    'seal_id' => $this->seal,
                    'number_of_ways' => $this->number_of_ways,
                    'type' => $this->type,
                    'connector_id' => $this->connector,
                ]);
            
                $this->material = $this->material->id;
            }elseif($this->family == 'Terminales'){
                $this->validate([
                    'size' => 'numeric|required',
                    'minimum_section' => 'numeric|nullable',
                    'maximum_section' => 'numeric|nullable',
                ], [
                    'size.numeric' => 'El campo tamaño es numérico',
                    'size.required' => 'El campo tamaño es requerido',
                    'minimum_section.numeric' => 'El campo sección mínima es numérico',
                    'maximum_section.numeric' => 'El campo sección máxima es numérico',
                ]);
                $this->material=Material::create([
                    'code' => $this->code,
                    'name' => $this->name_material,
                    'family' => $this->family,
                    'color' => $this->color,
                    'line_id'=>$this->line,
                    'usage_id'=>$this->usage,
                    'replace_id'=>$this->replace,
                    'stock_min'=>$this->stock_min,
                    'stock' => $this->stock,
                ]);
                Terminal::create([
                    'material_id' => $this->material->id,
                    'size' => $this->size,
                    'minimum_section' => $this->minimum_section,
                    'maximum_section' => $this->maximum_section,
                ]);
                
                $this->material = $this->material->id;
            }elseif($this->family == 'Cables'){
            
                $this->validate([
                    'size' => 'numeric|required',
                    'minimum_section' => 'numeric|nullable',
                    'maximum_section' => 'numeric|nullable',
                ],[
                    'size.numeric' => 'El campo tamaño es numérico',
                    'size.required' => 'El campo tamaño es requerido',
                    'minimum_section.numeric' => 'El campo sección mínima es numérico',
                    'maximum_section.numeric' => 'El campo sección máxima es numérico',
                ]);
                $this->material=Material::create([
                    'code' => $this->code,
                    'name' => $this->name_material,
                    'family' => $this->family,
                    'color' => $this->color,
                    'line_id'=>$this->line,
                    'usage_id'=>$this->usage,
                    'replace_id'=>$this->replace,
                    'stock_min'=>$this->stock_min,
                    'stock' => $this->stock,
                ]);
                Cable::create([
                    'material_id' => $this->material->id,
                    'size' => $this->size,
                    'minimum_section' => $this->minimum_section,
                    'maximum_section' => $this->maximum_section,
                ]);
            
                $this->material = $this->material->id;
            }else{
                $this->material=Material::create([
                    'code' => $this->code,
                    'name' => $this->name_material,
                    'family' => $this->family,
                    'color' => $this->color,
                    'line_id'=>$this->line,
                    'usage_id'=>$this->usage,
                    'replace_id'=>$this->replace,
                    'stock_min'=>$this->stock_min,
                    'stock' => $this->stock,
                ]);
                Seal::create([
                    'material_id' => $this->material->id,
                ]);
                $this->material = $this->material->id;
        }
    }else{
        $this->validar= $this->validate([
            'material' => 'required|numeric',
        ], [
            'material.required' => 'Seleccione una opción para el campo de material',
            'material.numeric' => 'Seleccione una opción para el campo de material',
        ]);
    }
        
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
        $this->div=null;
        $this->addMaterial = false;
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
    {   
       
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
        $this->code=null;
        $this->name_material=null;
        $this->family=null;
        $this->color=null;
        $this->replace=null;
        $this->stock_min=null;
        $this->stock=null;
        $this->usage=null;
        $this->terminal=null;
        $this->seal=null;
        $this->line=null;
        $this->number_of_ways=null;
        $this->type=null;
        $this->connector=null;
        $this->size=null;
        $this->minimum_section=null;
        $this->maximum_section=null;
        $this->usage_id=null;
        $this->line_id=null;
        $this->conn = null;
        $this->conn_id=null;
        $this->terminal_id=null;
        $this->seal_id=null;
        $this->connector_id=null;
        $this->term=null;
        $this->term_id=null;
        $this->size=null;
        $this->minimum_section=null;
        $this->maximum_section=null;
        $this->rplce = null;
        $this->images = null;
        $this->info_line=Line::all();
        $this->info_usage=Usage::all();
        $this->info_term=Terminal::all();
        $this->info_sell=Seal::all();
        $this->info_con=Connector::all();
        $this->addMaterial = false;
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
        if($this->addMaterial){
            
            $this->validate([
                'code' => 'required',
                'name_material' => 'required',
                'family' => 'required',
                'color' => 'required',
                'line' => 'required',
                'usage' => 'required',
                'replace' => 'nullable',
                'stock_min' => 'numeric|required',
                'stock' => 'numeric|required',
            ],[
                'code.required' => 'El campo código es requerido',
                'name_material' => 'El campo nombre es requerido',
                'family.required' => 'El campo familia es requerido',
                'color.required' => 'El campo color es requerido',
                'line.required' => 'Seleccione una opción para el campo de línea',
                'usage.required' => 'Seleccione una opción para el campo de uso',
                'stock_min.required' => 'El campo stock mínimo es requerido',
                'stock_min.numeric' => 'El campo stock mínimo es numérico',
                'stock.required' => 'El campo stock es requerido',
                'stock.numeric' => 'El campo stock es numérico',
            ]);
        
            if($this->family == 'Conectores'){
                $this->validate([
                    'terminal' => 'nullable',
                    'seal' => 'nullable',
                    'number_of_ways' => 'numeric|integer|digits:2|required',
                    'type' => 'required',
                    'connector' =>'nullable'
                ], [
                    'number_of_ways.numeric' => 'El campo cantidad de vías es numérico',
                    'number_of_ways.integer' => 'El campo cantidad de vías es un número natural',
                    'number_of_ways.digits' => 'El campo cantidad de vías debe ser un número natural de dos cifras',
                    'number_of_ways.required' => 'El campo cantidad de vías es requerido',
                    'type.required' => 'El campo tipo es requerido',
                ]);
                $this->material=Material::create([
                    'code' => $this->code,
                    'name' => $this->name_material,
                    'family' => $this->family,
                    'color' => $this->color,
                    'line_id'=>$this->line,
                    'usage_id'=>$this->usage,
                    'replace_id'=>$this->replace,
                    'stock_min'=>$this->stock_min,
                    'stock' => $this->stock,
                ]);
                
                Connector::create([
                    'material_id' => $this->material->id,
                    'terminal_id' => $this->terminal,
                    'seal_id' => $this->seal,
                    'number_of_ways' => $this->number_of_ways,
                    'type' => $this->type,
                    'connector_id' => $this->connector,
                ]);
            
                $this->material = $this->material->id;
            }elseif($this->family == 'Terminales'){
                $this->validate([
                    'size' => 'numeric|required',
                    'minimum_section' => 'numeric|nullable',
                    'maximum_section' => 'numeric|nullable',
                ], [
                    'size.numeric' => 'El campo tamaño es numérico',
                    'size.required' => 'El campo tamaño es requerido',
                    'minimum_section.numeric' => 'El campo sección mínima es numérico',
                    'maximum_section.numeric' => 'El campo sección máxima es numérico',
                ]);
                $this->material=Material::create([
                    'code' => $this->code,
                    'name' => $this->name_material,
                    'family' => $this->family,
                    'color' => $this->color,
                    'line_id'=>$this->line,
                    'usage_id'=>$this->usage,
                    'replace_id'=>$this->replace,
                    'stock_min'=>$this->stock_min,
                    'stock' => $this->stock,
                ]);
                Terminal::create([
                    'material_id' => $this->material->id,
                    'size' => $this->size,
                    'minimum_section' => $this->minimum_section,
                    'maximum_section' => $this->maximum_section,
                ]);
                
                $this->material = $this->material->id;
            }elseif($this->family == 'Cables'){
            
                $this->validate([
                    'size' => 'numeric|required',
                    'minimum_section' => 'numeric|nullable',
                    'maximum_section' => 'numeric|nullable',
                ],[
                    'size.numeric' => 'El campo tamaño es numérico',
                    'size.required' => 'El campo tamaño es requerido',
                    'minimum_section.numeric' => 'El campo sección mínima es numérico',
                    'maximum_section.numeric' => 'El campo sección máxima es numérico',
                ]);
                $this->material=Material::create([
                    'code' => $this->code,
                    'name' => $this->name_material,
                    'family' => $this->family,
                    'color' => $this->color,
                    'line_id'=>$this->line,
                    'usage_id'=>$this->usage,
                    'replace_id'=>$this->replace,
                    'stock_min'=>$this->stock_min,
                    'stock' => $this->stock,
                ]);
                Cable::create([
                    'material_id' => $this->material->id,
                    'size' => $this->size,
                    'minimum_section' => $this->minimum_section,
                    'maximum_section' => $this->maximum_section,
                ]);
            
                $this->material = $this->material->id;
            }else{
                $this->material=Material::create([
                    'code' => $this->code,
                    'name' => $this->name_material,
                    'family' => $this->family,
                    'color' => $this->color,
                    'line_id'=>$this->line,
                    'usage_id'=>$this->usage,
                    'replace_id'=>$this->replace,
                    'stock_min'=>$this->stock_min,
                    'stock' => $this->stock,
                ]);
                Seal::create([
                    'material_id' => $this->material->id,
                ]);
                $this->material = $this->material->id;
        }
    }else{
        $this->validar= $this->validate([
            'material' => 'required|numeric',
        ], [
            'material.required' => 'Seleccione una opción para el campo de material',
            'material.numeric' => 'Seleccione una opción para el campo de material',
        ]);
    }

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
        $this->div=null;
        $this->addMaterial = false;
        $this->explora='activo';   
    }
    public function addMaterial(){
        $this->addMaterial = true;
    }
    public function con(){
        $this->div=$this->family;
        #dd($this->div);
        $this->material_family=Material::where('family','LIKE','%'.$this->div.'%')->get();
        
   }
}
