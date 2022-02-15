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
use App\Models\Tube;
use App\Models\Accessory;
use App\Models\Clip;
use App\Models\ProviderPrice;
use Livewire\Component;
use Livewire\WithPagination;

class Providers extends Component
{  
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $providers;
    public $funcion="",  $paginas=25, $mat_n,$id_provider, $idu, $provider, $search, $name, $address, $phone, $email, $contact_name, $point_contact, $site_url, $status=1, $explora='inactivo',  $order='name', $materials;
    public $validar, $amount, $material, $id_material, $material_up, $unit, $presentation, $usd_price, $ars_price, $prices, $price, $info_mat, $provider_prices, $id_provider_price, $regex, $addMaterial;
    public $code, $name_material, $family, $terminal, $connector, $provider_material_code, $seal ,$color, $line, $usage, $replace_id, $stock_min, $stock_max, $stock, $replace, $info_line, $info_usage, $info_term, $info_sell, $div, $info_con, $number_of_ways, $type, $size, $minimum_section, $maximum_section, $material_family, $material_replace, $idexplora, $searchmateriales, $materiales, $material_id, $description, $codem, $detail, $details, $watertight, $section, $base_color, $line_color, $braid_configuration, $norm, $number_of_unipolar, $mesh_type, $operating_temperature, $term_material, $term_type, $minimum_diameter, $maximum_diameter, $seal_type, $tube_type, $tube_diameter, $wall_thickness, $contracted_diameter, $minimum_temperature, $maximum_temperature, $accesory_type, $clip_type, $long, $width, $hole_diameter, $material_new, $material_name, $cuit, $term_size, $lock, $cover, $div_tube=false;

    public function render()
    {
         
        $this->providers = Provider::where('name','LIKE','%'.$this->search.'%')
        ->orWhere('address','LIKE','%'.$this->search.'%')
        ->orWhere('phone','LIKE','%'.$this->search.'%')
        ->orWhere('email','LIKE','%'.$this->search.'%')
        ->orWhere('contact_name','LIKE','%'.$this->search.'%')
        ->orWhere('point_contact','LIKE','%'.$this->search.'%')
        ->orWhere('site_url','LIKE','%'.$this->search.'%')
        ->orWhere('cuit','LIKE','%'.$this->search.'%')
        ->orderBy($this->order)->paginate($this->paginas);
        $this->materiales = Material::where('code','like','%'.$this->searchmateriales.'%')
            ->orWhere('name','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('family','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('color','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('description','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('stock_min','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('stock_max','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('stock','LIKE','%'.$this->searchmateriales.'%')->get();

            if(isset($this->usd_price) && $this->usd_price > 0){
                $this->ars_price = $this->usd_price*180;
            }

        return view('livewire.providers', [
            'providers' => $this->providers,
        ]);
    }

    public function funcion()
    {
        $this->funcion="crear";
        $this->id_provider=null;
        $this->name=null;
        $this->address=null;
        $this->phone=null;
        $this->email=null;
        $this->cuit=null;
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
            'site_url' => 'nullable|regex: '.$regex,
            'cuit' => 'required',
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
            'cuit.required' => 'El campo cuit es requerido',
        ]);
        Provider::create([
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'contact_name'=>$this->contact_name,
            'point_contact'=>$this->point_contact,
            'site_url'=>$this->site_url,
            'status'=>$this->status,
            'cuit' => $this->cuit,
        ]);
        $this->funcion="";
    }

    public function back(){
        $this->funcion="";
        $this->explora='inactivo';
        $this->resetValidation();   
    }

    public function explorar(Provider $provider_id){
        $this->idexplora=$provider_id->id;
        $this->name=$provider_id->name;
        $this->address=$provider_id->address;
        $this->phone=$provider_id->phone;
        $this->email=$provider_id->email;
        $this->contact_name=$provider_id->contact_name;
        $this->point_contact=$provider_id->point_contact;
        $this->site_url=$provider_id->site_url;
        $this->status=$provider_id->status;
        $this->cuit=$provider_id->cuit;

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
        $this->cuit=$provider->cuit;
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
            'site_url' => 'nullable|regex: '.$regex,
            'cuit' => 'required'
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
            'cuit.required' => 'El campo cuit es requerido',
        ]);

        
        $provider_up =Provider::find($this->idu);
        $provider_up->name=$this->name;
        $provider_up->address=$this->address;
        $provider_up->phone=$this->phone;
        $provider_up->email=$this->email;
        $provider_up->contact_name=$this->contact_name;
        $provider_up->point_contact=$this->point_contact;
        $provider_up->site_url=$this->site_url;
        $provider_up->cuit=$this->cuit;
        $provider_up->status=$this->status;

        $provider_up->save();
        $this->funcion="";
    }
    
    public function destruir(Provider $provider)
    {
        $this->dispatchBrowserEvent('show-borrar');
        $this->provider=$provider;
    }

    public function delete()
    {
        if (auth()->user()->cannot('delete', auth()->user()))
        {
            abort(403);
        } else {
            if(!empty($this->provider->provider_prices)){
                foreach ($this->provider->provider_prices as $provider_price) {
                    if (!empty($provider_price->price)) {
                        foreach ($provider_price->price as $price) {
                            $price->delete();
                        }
                    }
                    $provider_price->delete();
                }
            }
            $this->provider->delete();
            $this->funcion="";
            $this->explora="inactivo";
        }
        $this->dispatchBrowserEvent('hide-borrar');
        $this->dispatchBrowserEvent('deleted');
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
        $this->name=null;
        $this->family=null;
        $this->color=null;
        $this->description=null;
        $this->replace=null;
        $this->stock_min=null;
        $this->stock_max=null;
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
        $this->conn = null;
        $this->conn_id=null;
        $this->lock=null;
        $this->cover=null;
        $this->term_size=null;
        $this->terminal_id=null;
        $this->seal_id=null;
        $this->connector_id=null ;
        $this->term=null; 
        $this->term_id=null;
        $this->size=null;
        $this->minimum_section=null;
        $this->maximum_section=null;
        $this->sl=null;
        $this->cab=null;
        $this->rplce = null;
        $this->termi = null;
        $this->seli = null;
        $this->connect = null;
        $this->watertight=null;
        $this->section=null;
        $this->base_color=null;
        $this->line_color=null;
        $this->braid_configuration=null;
        $this->norm=null;
        $this->number_of_unipolar=null;
        $this->mesh_type=null;
        $this->operating_temperature=null;
        $this->term_material=null;
        $this->term_type=null;
        $this->minimum_diameter=null;
        $this->maximum_diameter=null;
        $this->seal_type=null;
        $this->tube_type=null;
        $this->tube_diameter=null;
        $this->wall_thickness=null;
        $this->contracted_diameter=null;
        $this->minimum_temperature=null;
        $this->maximum_temperature=null;
        $this->accesory_type=null;
        $this->clip_type=null;
        $this->long=null;
        $this->width=null;
        $this->hole_diameter=null;
        $this->name_material=null;
        $this->material_new = null;
        $this->info_line=Line::all();
        $this->info_usage=Usage::all();
        $this->info_term = Terminal::whereExists(function ($query) {
            $query->select('id')
                  ->from('materials')
                  ->where('family','Terminales')
                  ->whereColumn('terminals.material_id', 'materials.id');
        })
        ->get();
        $this->info_sell=Seal::whereExists(function ($query) {
            $query->select('id')
                  ->from('materials')
                  ->where('family','Sellos')
                  ->whereColumn('seals.material_id', 'materials.id');
        })
        ->get();
        $this->info_con=Connector::all();
        $this->addMaterial = true;
        $this->explora='inactivo';
        $this->funcion="crearmat";    
    }

    public function storemat(Provider $provider){
        
        $this->validar= $this->validate([
            'amount' => 'nullable|numeric|min:0',
            'unit' => 'required|numeric|min:0',
            'presentation' => 'required',
            'provider_material_code' => 'required|string|min:1|max:50',
            'usd_price' => 'required|numeric|min:0',
            'ars_price' => 'required|numeric|min:0',
          ], [
            'amount.numeric' => 'El campo cantidad debe ser numérico (decimales separados por punto)',
            'amount.min' => 'El campo cantidad debe ser mayor a cero (0)',
            'unit.required' => 'El campo unidad es requerido',
            'unit.numeric' => 'El campo unidad debe ser numérico (decimales separados por punto)',
            'unit.min' => 'El campo unidad debe ser mayor a cero (0)',
            'presentation.required' => 'Seleccione una opción para el campo de la unidad de presentación',
            'provider_material_code.required' => 'El código de material interno del proveedor es requerido',
            'provider_material_code.string' => 'El código de material interno del proveedor es requerido',
            'provider_material_code.min'=>'El código de material interno del proveedor tiene como mínimo un caracter',
            'provider_material_code.max'=>'El código de material interno del proveedor tiene como máximo cincuenta caracteres',
            'usd_price.required' => 'El campo precio U$D es requerido',
            'usd_price.numeric' => 'El campo precio U$D debe ser numérico (decimales separados por punto)',
            'usd_price.min' => 'El campo  U$D  debe ser mayor a cero (0)',
            'ars_price.required' => 'El campo precio AR$ es requerido',
            'ars_price.numeric' => 'El campo precio AR$ es numérico (decimales separados por punto)',
            'ars_price.min' => 'El campo  AR$  debe ser mayor a cero (0)',
          ]);
      
       $provider_price= ProviderPrice::create([
            'provider_id' =>$provider->id,
            'material_id' =>$this->material_new->id,
            'amount' =>$this->amount,
            'unit' =>$this->unit,
            'presentation' =>$this->presentation,
            'provider_code' => $this->provider_material_code,
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
        $this->provider_material_code=null;
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
        $this->material_name=$provider_price->material->name;
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
        $this->usage=null;
        $this->line=null;
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
        $this->material_new = Material::where('id', $provider_price->material_id)->first();
        $this->info_line=Line::all();
        $this->info_usage=Usage::all();
        $this->info_term = Terminal::whereExists(function ($query) {
            $query->select('id')
                  ->from('materials')
                  ->where('family','Terminales')
                  ->whereColumn('terminals.material_id', 'materials.id');
        })
        ->get();
        $this->info_sell=Seal::whereExists(function ($query) {
            $query->select('id')
                  ->from('materials')
                  ->where('family','Sellos')
                  ->whereColumn('seals.material_id', 'materials.id');
        })
        ->get();
        $this->info_con=Connector::all();
        $this->addMaterial = false;
        $this->explora= 'inactivo';
        $this->funcion="actualizarmat";
    }

    public function editarmat(){
       
      $this->validar=  $this->validate([
            'amount' => 'nullable|numeric|min:0',
            'unit' => 'required|numeric|min:0',
            'presentation' => 'required',
            'provider_material_code' => 'required|string|min:1|max:50',
            'usd_price' => 'required|numeric|min:0',
            'ars_price' => 'required|numeric|min:0',
          ], [
            'amount.numeric' => 'El campo cantidad debe ser numérico (decimales separados por punto)',
            'amount.min' => 'El campo cantidad debe ser mayor a cero (0)',
            'unit.required' => 'El campo unidad es requerido',
            'unit.numeric' => 'El campo unidad debe ser numérico (decimales separados por punto)',
            'unit.min' => 'El campo unidad debe ser mayor a cero (0)',
            'presentation.required' => 'Seleccione una opción para el campo de la unidad de presentación',
            'provider_material_code.required' => 'El código de material interno del proveedor es requerido',
            'provider_material_code.string' => 'El código de material interno del proveedor es requerido',
            'provider_material_code.min'=>'El código de material interno del proveedor tiene como mínimo un caracter',
            'provider_material_code.max'=>'El código de material interno del proveedor tiene como máximo cincuenta caracteres',
            'usd_price.required' => 'El campo precio U$D es requerido',
            'usd_price.numeric' => 'El campo precio U$D debe ser numérico (decimales separados por punto)',
            'usd_price.min' => 'El campo  U$D  debe ser mayor a cero (0)',
            'ars_price.required' => 'El campo precio AR$ es requerido',
            'ars_price.numeric' => 'El campo precio AR$ es numérico (decimales separados por punto)',
            'ars_price.min' => 'El campo  AR$  debe ser mayor a cero (0)',
        ]);
        
        $provider =Provider::find($this->id_provider);
        $material_up =ProviderPrice::find($this->id_provider_price);
        $material_up->amount=$this->amount; 
        $material_up->material_id=$this->material_new->id;
        $material_up->provider_id=$this->id_provider;
        $material_up->unit=$this->unit;
        $material_up->presentation=$this->presentation;
        $material_up->provider_code=$this->provider_material_code;
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
        $this->provider_material_code=null;
        $this->explorar($provider);
    }
    public function backmat(){
        $this->funcion="0";
        $this->div=null;
        $this->addMaterial = false;
        $this->explora='activo';   
    }
    public function addMaterial(){
        $this->code=null;
        $this->name=null;
        $this->family=null;
        $this->color=null;
        $this->description=null;
        $this->replace=null;
        $this->stock_min=null;
        $this->stock_max=null;
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
        $this->sl=null;
        $this->cab=null;
        $this->rplce = null;
        $this->termi = null;
        $this->seli = null;
        $this->connect = null;
        $this->watertight=null;
        $this->section=null;
        $this->base_color=null;
        $this->line_color=null;
        $this->braid_configuration=null;
        $this->norm=null;
        $this->number_of_unipolar=null;
        $this->mesh_type=null;
        $this->operating_temperature=null;
        $this->term_material=null;
        $this->term_type=null;
        $this->minimum_diameter=null;
        $this->maximum_diameter=null;
        $this->seal_type=null;
        $this->tube_type=null;
        $this->tube_diameter=null;
        $this->wall_thickness=null;
        $this->contracted_diameter=null;
        $this->minimum_temperature=null;
        $this->maximum_temperature=null;
        $this->accesory_type=null;
        $this->clip_type=null;
        $this->long=null;
        $this->width=null;
        $this->hole_diameter=null;
        $this->name_material=null;
        $this->material_new = null;
        $this->info_line=Line::all();
        $this->info_usage=Usage::all();
        $this->info_term = Terminal::whereExists(function ($query) {
            $query->select('id')
                  ->from('materials')
                  ->where('family','Terminales')
                  ->whereColumn('terminals.material_id', 'materials.id');
        })
        ->get();
        $this->info_sell=Seal::whereExists(function ($query) {
            $query->select('id')
                  ->from('materials')
                  ->where('family','Sellos')
                  ->whereColumn('seals.material_id', 'materials.id');
        })
        ->get();
        $this->info_con=Connector::all();
        $this->dispatchBrowserEvent('show-form');
        $this->searchmateriales="";
    }
    public function addmaterialprice()
    {
        $this->validate([
            'code' => 'required',
            'name_material' => 'required',
            'family' => 'required',
            'description' => 'max:500|nullable',
            'line' => 'nullable',
            'usage' => 'required',
            'replace' => 'nullable',
            'stock_min' => 'numeric|required|digits_between:1,6',
            'stock_max' => 'numeric|nullable|digits_between:1,6',
        ],[
            'code.required' => 'El campo código es requerido',
            'name_material.required' => 'El campo nombre es requerido',
            'family.required' => 'El campo familia es requerido',
            'description.max' => 'El campo descripción no debe superar 500 carácteres',
            'usage.required' => 'Seleccione una opción para el campo de uso',
            'stock_min.required' => 'El campo stock mínimo es requerido',
            'stock_min.numeric' => 'El campo stock mínimo es numérico (decimales separados por punto)',
            'stock_min.max' => 'El campo stock mínimo es inferior a 6 digitos',
            'stock_max.numeric' => 'El campo stock máximo es numérico (decimales separados por punto)',
            'stock_max.max' => 'El campo stock máximo es inferior a 6 digitos',
        ]);
    
        if($this->family == 'Cables'){
            $this->validate([
                'color' => 'nullable',
            ]);
        }else{
            $this->validate([
                'color' => 'required',
            ], [
                'color.required' => 'El campo color es requerido',
            ]);
        }
        
            if($this->family == 'Conectores'){
                $this->validate([
                    'terminal' => 'nullable',
                    'seal' => 'nullable',
                    'number_of_ways' => 'numeric|integer|digits:1|required',
                    'type' => 'required',
                    'connector' =>'nullable',
                    'watertight' =>'required|boolean',
                    'lock' =>'required|boolean',
                    'cover' =>'required|boolean'
                ], [
                    'number_of_ways.numeric' => 'El campo cantidad de vías es numérico',
                    'number_of_ways.integer' => 'El campo cantidad de vías es un número natural',
                    'number_of_ways.digits' => 'El campo cantidad de vías debe ser un número natural de 1 digito',
                    'number_of_ways.required' => 'El campo cantidad de vías es requerido',
                    'type.required' => 'El campo tipo es requerido',
                    'watertight.required' => 'Seleccione una opción para el campo estanco',
                    'lock.required' => 'Seleccione una opción para el campo traba secundaria',
                    'cover.required' => 'Seleccione una opción para el campo tapa',
                    'watertight.boolean' => 'El campo estanco debe ser sí o no',
                    'lock.boolean' => 'El campo traba secundaria debe ser sí o no',
                    'cover.boolean' => 'El campo tapa debe ser sí o no',
                ]);
                $this->material=Material::create([
                    'code' => $this->code,
                    'name' => $this->name_material,
                    'family' => $this->family,
                    'color' => $this->color,
                    'description' => $this->description,
                    'line'=>$this->line,
                    'usage'=>$this->usage,
                    'replace_id'=>$this->replace,
                    'stock_min'=>$this->stock_min,
                    'stock_max'=>$this->stock_max,
                ]);
                $this->showmaterial($this->material);
                Connector::create([
                    'material_id' => $this->material->id,
                    'terminal_id' => $this->terminal,
                    'seal_id' => $this->seal,
                    'number_of_ways' => $this->number_of_ways,
                    'type' => $this->type,
                    'connector_id' => $this->connector,
                    'watertight' => $this->watertight,
                    'lock' => $this->lock,
                    'cover' => $this->cover,                 
                ]);
                $this->material = $this->material->id;
            }elseif($this->family == 'Terminales'){
               $regex = '/^[\d]{0,4}(\.[\d]{1,2})?$/';

                $this->validate([
                    'size' => 'numeric|required',
                    'minimum_section' => 'numeric|nullable|regex: '.$regex,
                    'maximum_section' => 'numeric|nullable|regex: '.$regex,
                    'term_material' => 'required',
                    'term_type' => 'required'
                ], [
                    'size.numeric' => 'El campo tamaño es numérico',
                    'size.required' => 'El campo tamaño es requerido',
                    'minimum_section.numeric' => 'El campo sección mínima es numérico',
                    'maximum_section.numeric' => 'El campo sección máxima es numérico',
                    'minimum_section.regex' => 'El campo sección mínima es un número de máximo 4 cifras con 2 posiciones decimales',
                    'maximum_section.regex' => 'El campo sección máxima es un número de máximo 4 cifras con 2 posiciones decimal',
                    'term_material.required' => 'Seleccione una opción para el campo Material',
                    'term_type.required' => 'Seleccione una opción para el campo Material',
                    
                ]);
                $this->material=Material::create([
                    'code' => $this->code,
                    'name' => $this->name_material,
                    'family' => $this->family,
                    'color' => $this->color,
                    'description' => $this->description,
                    'line'=>$this->line,
                    'usage'=>$this->usage,
                    'replace_id'=>$this->replace,
                    'stock_min'=>$this->stock_min,
                    'stock_max'=>$this->stock_max,
                ]);
                $this->showmaterial($this->material);
                Terminal::create([
                    'material_id' => $this->material->id,
                    'size' => $this->size,
                    'minimum_section' => $this->minimum_section,
                    'maximum_section' => $this->maximum_section,
                    'material' => $this->term_material,
                    'type' => $this->term_type,
                ]);

                $this->material = $this->material->id;
            }elseif($this->family == 'Cables'){
                $regex = '/^[\d]{0,4}(\.[\d]{1,2})?$/';
                $this->validate([
                    'section' => 'numeric|required|regex: '.$regex,
                    'base_color' => 'required',
                    'line_color' => 'nullable',
                    'braid_configuration' => 'required',
                    'norm' =>  'required',
                    'number_of_unipolar' => 'numeric|nullable',
                    'mesh_type' => 'string|nullable',
                    'operating_temperature' => 'numeric|required|regex: '.$regex,
                ], [
                    'section.numeric' => 'El campo sección es numérico',
                    'section.required' => 'El campo sección es requerido',
                    'section.regex' => 'El campo sección es un número de máximo 4 cifras con 2 posiciones decimales',
                    'base_color.required' => 'Seleccione una opción del campo color base',
                    'braid_configuration.required' => 'Seleccione una opción del campo Configuración de Trenza',
                    'norm.required' => 'Seleccione una opción del campo Norma',
                    'number_of_unipolar.numeric' => 'El campo Cantidad de unipolares es numérico',
                    'operating_temperature.numeric' => 'El campo Temperatura de Servicio es numérico',
                    'operating_temperature.required' => 'El campo Temperatura de Servicio es requerido',
                    'operating_temperature.regex' => 'El campo Temperatura de Servicio es un número de máximo 4 cifras con 2 posiciones decimales',
    
                ]);
                $this->material=Material::create([
                    'code' => $this->code,
                    'name' => $this->name_material,
                    'family' => $this->family,
                    'color' => ' ',
                    'description' => $this->description,
                    'line'=>$this->line,
                    'usage'=>$this->usage,
                    'replace_id'=>$this->replace,
                    'stock_min'=>$this->stock_min,
                    'stock_max'=>$this->stock_max,
                ]);
                $this->showmaterial($this->material);
                Cable::create([
                    'material_id' => $this->material->id,
                    'section' => $this->section,
                    'base_color' => $this->base_color,
                    'line_color' => $this->line_color,
                    'braid_configuration' => $this->braid_configuration,
                    'norm' => $this->norm,
                    'number_of_unipolar' => $this->number_of_unipolar,
                    'mesh_type' => $this->mesh_type,
                    'operating_temperature' => $this->operating_temperature,
                ]);
            
                $this->material = $this->material->id;
            }elseif($this->family == 'Sellos'){
          
                $regex = '/^[\d]{0,4}(\.[\d]{1,2})?$/';
    
                $this->validate([
                    'minimum_diameter' => 'numeric|required|regex: '.$regex,
                    'maximum_diameter' => 'numeric|required|regex: '.$regex,
                    'seal_type' => 'nullable|max:30',
                    ], [
                    'minimum_diameter.numeric' => 'El campo Diámetro mínimo de Cable es numérico',
                    'minimum_diameter.required' => 'El campo Diámetro mínimo de Cable es requerido',
                    'minimum_diameter.regex' => 'El campo Diámetro mínimo de Cable es un número de máximo 4 cifras con 2 posiciones decimales',
                    'maximum_diameter.numeric' => 'El campo Diámetro máximo de Cable es numérico',
                    'maximum_diameter.required' => 'El campo Diámetro máximo de Cable es requerido',
                    'maximum_diameter.regex' => 'El campo Diámetro máximo de Cable es un número de máximo 4 cifras con 2 posiciones decimales',
                    'seal_type.max' => 'El campo Tipo de sello debe ser inferior a 30 carácteres'
                ]);
                $this->material=Material::create([
                    'code' => $this->code,
                    'name' => $this->name_material,
                    'family' => $this->family,
                    'color' => $this->color,
                    'description' => $this->description,
                    'line'=>$this->line,
                    'usage'=>$this->usage,
                    'replace_id'=>$this->replace,
                    'stock_min'=>$this->stock_min,
                    'stock_max'=>$this->stock_max,
                ]);
                $this->showmaterial($this->material);
                Seal::create([
                    'material_id' => $this->material->id,
                    'minimum_diameter' => $this->minimum_diameter,
                    'maximum_diameter' => $this->maximum_diameter,
                    'type' => $this->seal_type,
                ]);
                $this->material = $this->material->id;
            }elseif($this->family == 'Tubos'){
              
                $regex = '/^[\d]{0,4}(\.[\d]{1,2})?$/';
    
                if($this->tube_type=="Termocontraible"){
                    $this->validate([
                        'tube_diameter' => 'numeric|required|regex: '.$regex,
                        'tube_type' => 'required',
                        'wall_thickness' => 'numeric|required|regex: '.$regex,
                        'contracted_diameter' => 'numeric|nullable|regex: '.$regex,
                        'minimum_temperature' => 'numeric|nullable|min:-55|max:9999',
                        'maximum_temperature' => 'numeric|nullable|min:-55|max:9999',
                    ], [
                        'tube_diameter.numeric' => 'El campo Diámetro es numérico (decimales separados por punto)',
                        'tube_diameter.required' => 'El campo Diámetro es requerido',
                        'tube_diameter.regex' => 'El campo Diámetro es un número de máximo 4 cifras con 2 posiciones decimal',
                        'wall_thickness.numeric' => 'El campo Espesor de Pared es numérico (decimales separados por punto)',
                        'wall_thickness.required' => 'El campo Espesor de Pared es requerido',
                        'wall_thickness.regex' => 'El campo Espesor de Pared es un número de máximo 4 cifras con 2 posiciones decimal',
                        'contracted_diameter.numeric' => 'El campo Diámetro Contraído es numérico (decimales separados por punto)',
                        'contracted_diameter.required' => 'El campo Diámetro Contraído es requerido',
                        'contracted_diameter.regex' => 'El campo Diámetro Contraído es un número de máximo 4 cifras con 2 posiciones decimal',
                        'minimum_temperature.numeric' => 'El campo Temperatura mínima de Servicio es numérico (decimales separados por punto)',
                        'minimum_temperature.required' => 'El campo Temperatura mínima de Servicio es requerido',
                        'minimum_temperature.min' => 'El campo Temperatura mínima de Servicio es como mínimo -55°C',
                        'minimum_temperature.max' => 'El campo Temperatura mínima de Servicio es un número de máximo 4 cifras con 2 posiciones decimal',
                        'maximum_temperature.numeric' => 'El campo Temperatura máxima de Servicio es numérico (decimales separados por punto)',
                        'maximum_temperature.required' => 'El campo Temperatura máxima de Servicio es requerido',
                        'maximum_temperature.min' => 'El campo Temperatura máxima de Servicio es como mínimo -55°C',
                        'maximum_temperature.max' => 'El campo Temperatura máxima de Servicio es un número de máximo 4 cifras con 2 posiciones decimal',
                         'tube_type.required' => 'Seleccione una opción del campo Tipo de Tubo',
                                  ]);
                    }else{
                        $this->validate([
                            'tube_diameter' => 'numeric|required|regex: '.$regex,
                            'tube_type' => 'required',
                            'wall_thickness' => 'numeric|required|regex: '.$regex,
                        ], [
                            'tube_diameter.numeric' => 'El campo Diámetro es numérico (decimales separados por punto)',
                            'tube_diameter.required' => 'El campo Diámetro es requerido',
                            'tube_diameter.regex' => 'El campo Diámetro es un número de máximo 4 cifras con 2 posiciones decimal',
                            'wall_thickness.numeric' => 'El campo Espesor de Pared es numérico (decimales separados por punto)',
                            'wall_thickness.required' => 'El campo Espesor de Pared es requerido',
                            'wall_thickness.regex' => 'El campo Espesor de Pared es un número de máximo 4 cifras con 2 posiciones decimal',
                            'tube_type.required' => 'Seleccione una opción del campo Tipo de Tubo',
                                      ]);
                    }
                    $this->material=Material::create([
                        'code' => $this->code,
                        'name' => $this->name_material,
                        'family' => $this->family,
                        'color' => $this->color,
                        'description' => $this->description,
                        'line'=>$this->line,
                        'usage'=>$this->usage,
                        'replace_id'=>$this->replace,
                        'stock_min'=>$this->stock_min,
                        'stock_max'=>$this->stock_max,
                    ]);
                    $this->showmaterial($this->material);
                    if($this->tube_type=="Termocontraible"){
                    Tube::create([
                        'material_id' => $this->material->id,
                        'diameter' => $this->tube_diameter,
                        'wall_thickness' => $this->wall_thickness,
                        'contracted_diameter' => (!empty($this->contracted_diameter)) ? $this->contracted_diameter : 0,
                        'minimum_temperature' => (!empty($this->minimum_temperature)) ? $this->minimum_temperature : 0,
                        'maximum_temperature' => (!empty($this->maximum_temperature)) ? $this->maximum_temperature : 0,
                        'type' => $this->tube_type,
                    ]);
                    }else{
                        Tube::create([
                            'material_id' => $this->material->id,
                            'diameter' => $this->tube_diameter,
                            'wall_thickness' => $this->wall_thickness,
                            'type' => $this->tube_type,
                        ]);
                    }
               
                $this->material = $this->material->id;
            }elseif($this->family == 'Clips'){
              
                $regex = '/^[\d]{0,4}(\.[\d]{1,2})?$/';
    
                $this->validate([
                    'long' => 'numeric|required|regex: '.$regex,
                    'width' => 'numeric|required|regex: '.$regex,
                    'hole_diameter' => 'numeric|required|regex: '.$regex,
                    'clip_type' => 'required',
         ], [
                    'long.numeric' => 'El campo Largo es numérico',
                    'long.required' => 'El campo Largo es requerido',
                    'long.regex' => 'El campo Largo es un número de máximo 4 cifras con 2 posiciones decimales',
                    'width.numeric' => 'El campo Ancho es numérico',
                    'width.required' => 'El campo Ancho es requerido',
                    'width.regex' => 'El campo Ancho es un número de máximo 4 cifras con 2 posiciones decimales',
                    'hole_diameter.numeric' => 'El campo Diámetro del Orificio es numérico',
                    'hole_diameter.required' => 'El campo Diámetro del Orificio es requerido',
                    'hole_diameter.regex' => 'El campo Diámetro del Orificio es un número de máximo 4 cifras con 2 posiciones decimales',
                    'clip_type.required' => 'Seleccione una opción del campo tipo de Clip',
                ]);
                $this->material=Material::create([
                    'code' => $this->code,
                    'name' => $this->name_material,
                    'family' => $this->family,
                    'color' => $this->color,
                    'description' => $this->description,
                    'line'=>$this->line,
                    'usage'=>$this->usage,
                    'replace_id'=>$this->replace,
                    'stock_min'=>$this->stock_min,
                    'stock_max'=>$this->stock_max,
                ]);
                $this->showmaterial($this->material);
                Clip::create([
                    'material_id' => $this->material->id,
                    'long' => $this->long,
                    'width' => $this->width,
                    'hole_diameter' => $this->hole_diameter,
                    'type' => $this->clip_type,
                ]);
                $this->material = $this->material->id;
            }else{
              
                $this->validate([
                    'accesory_type' => 'required',
                ], [
                    'accesory_type.required' => 'Seleccione una opción del campo tipo de Accesorio',
                ]);
    
                $this->material=Material::create([
                    'code' => $this->code,
                    'name' => $this->name_material,
                    'family' => $this->family,
                    'color' => $this->color,
                    'description' => $this->description,
                    'line'=>$this->line,
                    'usage'=>$this->usage,
                    'replace_id'=>$this->replace,
                    'stock_min'=>$this->stock_min,
                    'stock_max'=>$this->stock_max,
                ]);
                $this->showmaterial($this->material);
                Accessory::create([
                    'material_id' => $this->material->id,
                    'type' => $this->accesory_type,
                ]);
                $this->material = $this->material->id;
            }
            $this->addMaterial = false;
            $this->searchmateriales="";
            $this->dispatchBrowserEvent('hide-form');

        }

    public function selMaterial(){
        $this->addMaterial = false;
    }
    public function showmaterial(Material $material){
        $this->material_new=$material;
    }
    public function selectmaterial(Material $material)
    {
        $this->material_new=$material;
        $this->material_name=$material->name;
        $this->addMaterial = false;
        $this->searchmateriales="";
    }
    public function downmaterial()
    {
        unset($this->material_new);
        $this->addMaterial = true;
    }
    public function con(){
        $this->div=$this->family;
        #dd($this->div);
        $this->material_family=Material::where('family','LIKE','%'.$this->div.'%')->get();
        
   }
   public function size(){
    $this->term_size = (!empty($this->terminal)) ? Terminal::find($this->terminal)->size : '';
    }
    public function select_type(){
        if ($this->tube_type == 'Termocontraible') {
            return $this->div_tube = true;
        }else{
            return $this->div_tube = false;
        }
    }

}
