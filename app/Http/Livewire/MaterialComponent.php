<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Material;
use App\Models\Line;
use App\Models\Usage;
use App\Models\Terminal;
use App\Models\Seal;
use App\Models\Tube;
use App\Models\Accessory;
use App\Models\Clip;
use App\Models\Connector;
use App\Models\Cable;
use App\Models\Provider;
use App\Models\ProviderPrice;
use App\Models\Price;
use App\Models\ConnectorTerminal;
use App\Models\ConnectorSeal;
use App\Models\Workorder;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Dollar;
use DB;

class MaterialComponent extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    protected $materials;
    public  $paginas=25, $addterminal=array(), $count_terminales=0,$terminales=array(),$searchs="",$addsello=array(), $count_sellos=0,$sellos=array(),$ma, $conector, $dolar,$ar_price, $search, $search_terminal= "", $termi, $seli, $provider_material_code, $connect, $rplce, $info, $hola="", $funcion="", $explora="inactivo",  $order='code', $material, $material_id, $code, $name, $family, $terminal, $connector, $seal ,$color, $description, $line_id, $usage_id, $replace_id, $stock_min, $stock_max, $stock, $line, $usage, $replace, $info_line, $info_usage, $info_term, $info_sell, $div, $info_con, $number_of_ways, $type, $size, $minimum_section, $maximum_section, $material_family = [], $material_replace, $idu, $material_up, $connector_up, $conn, $term, $sl, $cab, $terminal_id = '', $seal_id, $connector_id, $conn_id, $term_id, $cab_id, $terminal_up, $cable_up, $seal_up, $conn_del, $seal_del, $term_del, $cable_del, $mat_n, $info_pro, $provider, $unit, $presentation, $usd_price, $ars_price, $amount, $provider_prices, $id_provider_price, $id_provider, $marterial, $pro, $images = [], $imagenes = [], $images_up = [], $img, $addProvider, $name_provider, $addres_provider, $email_provider, $regex, $watertight, $section , $base_color, $line_color, $braid_configuration, $norm, $number_of_unipolar, $mesh_type, $operating_temperature, $term_material, $term_type, $minimum_diameter, $maximum_diameter, $seal_type, $tube_type, $tube_diameter, $wall_thickness, $contracted_diameter, $minimum_temperature, $maximum_temperature, $accesory_type, $clip_type, $long, $width, $hole_diameter, $acc, $tub, $sl_id, $tub_id, $acc_id, $clip_id, $provider_new, $searchproviders, $providers, $material_price, $term_size, $lock, $cover, $div_tube=false, $reservations=array(), $disabled, $show_replace = false, $showColor = false; 
    public function render()
    {
        $this->dolar=Dollar::where('id',1)->first();
        $this->ar_price=$this->dolar->arp_price;
        $mats = Material::where('code','like','%'.$this->search.'%')
                ->orderBy($this->order);
        $this->materials = $mats->paginate($this->paginas);

        $this->info_term = Material::where('family', 'Terminales')
            ->where(function ($query) {
                $query->orWhere('code', 'LIKE', '%' . $this->search_terminal . '%');
            })
            ->orderBy('code')
            ->get();

        $this->info_sell = Material::where('family','Sellos')
        ->where(function($query) {
            $query->orwhere('code','LIKE','%'.$this->searchs.'%');
        })->get();
        
        $reservations_materials = $mats->get();
        $workorder = Workorder::where('state', 'Actual')->orWhere('state', 'Actual con pedidos cancelados')->first();
         
            if (!empty($reservations_materials) && !empty($workorder)) {
                foreach ($reservations_materials as $material) {
                    $this->reservations[$material->id] = $material->reservationmaterials()->select('material_id', DB::raw('SUM(amount) as
                    total'))->where('workorder_id', $workorder->id)->first();
                }
            }            
        $this->providers =Provider::where('name','LIKE','%'.$this->searchproviders.'%')
            ->orWhere('address','LIKE','%'.$this->searchproviders.'%')
            ->orWhere('phone','LIKE','%'.$this->searchproviders.'%')
            ->orWhere('email','LIKE','%'.$this->searchproviders.'%')
            ->orWhere('contact_name','LIKE','%'.$this->searchproviders.'%')
            ->orWhere('point_contact','LIKE','%'.$this->searchproviders.'%')
            ->orWhere('site_url','LIKE','%'.$this->searchproviders.'%')->get();   
        
        if(isset($this->usd_price)  && $this->usd_price > 0){
            $this->ars_price = $this->usd_price*$this->ar_price;
        }
            
         return view('livewire.material-component', [
            'materials' => $this->materials,
        ]);
    }

    public function funcion()
    {
        $this->resetValidation();
        $this->funcion="crear";
        $this->count_terminales=0;
        $this->count_sellos=0;
        $this->id_provider=null;
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
        $this->term_size=null;
        $this->cover=null;
        $this->lock=null;
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
        $this->maximum_section =null;
        $this->sl=null;
        $this->cab=null; 
        $this->rplce = null;
        $this->termi = null;
        $this->seli = null;
        $this->images = null;
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
        $this->tube_type="";
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
        $this->idu=null;
        $this->info_line=Line::all();
        $this->info_usage=Usage::all();
        
        $this->info_sell=Seal::whereExists(function ($query) {
            $query->select('id')
                  ->from('materials')
                  ->where('family','Sellos')
                  ->whereColumn('seals.material_id', 'materials.id');
        })
        ->get();
        $this->info_con=Connector::all();
        $this->disabled='';
        $this->terminales=[];
        $this->addterminal=[];
        $this->sellos=[];
        $this->addsello=[];
        $this->showColor = false;
    }

    public function addterminal(Material $material){
        $flag=false;
        foreach($this->terminales as $ter){
            if($material->id==$ter[0]){
                $flag=true;
            }
        }
        if(!$flag){
            $this->addterminal[0]=$material->id;
            $this->addterminal[1]=$material->name;
            $this->addterminal[2]=$material->code;
            $this->addterminal[3]=$material->terminal->size;
            $this->addterminal[4]=$material->terminal->minimum_section;
            $this->addterminal[5]=$material->terminal->maximum_section;
            $this->addterminal[6]=$this->count_terminales;
            $this->terminales[$this->count_terminales]=$this->addterminal;
            $this->count_terminales++;
        }   
        $this->search_terminal="";
    }
    public function dropterminal($pos_terminal){
        unset($this->terminales[$pos_terminal]);
    }
    public function addsello(Material $material){
        $flag=false;
        foreach($this->sellos as $sel){
            if($material->id==$sel[0]){
                $flag=true;
            }
        }
        if(!$flag){
            $this->addsello[0]=$material->id;
            $this->addsello[1]=$material->name;
            $this->addsello[2]=$material->code;
            $this->addsello[3]=$material->seal->type;
            $this->addsello[4]=$material->seal->minimum_diameter;
            $this->addsello[5]=$material->seal->maximum_diameter;
            $this->addsello[6]=$this->count_sellos;
            $this->sellos[$material->id]=$this->addsello;
            $this->count_sellos++;
        }   
        $this->searchs="";
    }
    public function dropsello($pos_sello){
        unset($this->sellos[$pos_sello]);
    }

    public function store(){
        $this->validate([
            'code' => 'required|unique:materials|max:20',
            'family' => 'required',
            'color' => 'nullable',
            'description' => 'max:500|nullable',
            'line' => 'nullable',
            'usage' => 'nullable',
            'replace' => 'nullable',
            'stock_min' => 'numeric|nullable|min:1|max:999999',
            'stock_max' => 'numeric|nullable|min:1|max:999999',
            'images.*' => 'nullable|max:20480',
        ],[
            'code.required' => 'El campo código es requerido',
            'code.unique' => 'El campo código que inteta ingresar se encuentra en uso, debe ser único',
            'code.max' => 'El campo código tiene como máximo 20 caracteres',
            'family.required' => 'El campo familia es requerido',
            'description.max' => 'El campo descripción no debe superar 500 carácteres',
            'stock_min.numeric' => 'El campo stock mínimo es numérico (decimales separados por punto)',
            'stock_min.min' => 'El campo stock mínimo debe ser un número mayor a 0(cero).',
            'stock_min.max' => 'El campo stock mínimo es inferior a 6 digitos.',
            'stock_max.numeric' => 'El campo stock máximo es numérico (decimales separados por punto)',
            'stock_max.min' => 'El campo stock máximo debe ser un número mayor a 0(cero).',
            'stock_max.max' => 'El campo stock máximo es inferior a 6 digitos.',
            'images.*.max' => 'La imagen que inteta adjuntar superan el límite de peso (20MB)'
        ]);
        if($this->family == 'Conectores'){
            $this->validate([
                'terminal' => 'nullable',
                'seal' => 'nullable',
                'number_of_ways' => 'numeric|integer|min:1|max:999|nullable',
                'type' => 'nullable',
                'connector' =>'nullable',
                'watertight' =>'nullable|boolean',
                'lock' =>'nullable|boolean',
                'cover' =>'nullable|boolean'
            ], [
                'number_of_ways.numeric' => 'El campo cantidad de vías es numérico (decimales separados por punto)',
                'number_of_ways.integer' => 'El campo cantidad de vías es un número natural',
                'number_of_ways.min' => 'El campo cantidad de vías debe ser un número entero de 1 a 999',
                'number_of_ways.max' => 'El campo cantidad de vías debe ser un número entero de 1 a 999',
                'watertight.boolean' => 'El campo estanco debe ser sí o no',
                'lock.boolean' => 'El campo traba secundaria debe ser sí o no',
                'cover.boolean' => 'El campo tapa debe ser sí o no',
            ]);
            $this->material=Material::create([
                'code' => $this->code,
                'name' => $this->name,
                'family' => $this->family,
                'color' => $this->color,
                'description' => $this->description,
                'line'=>$this->line,
                'usage'=>$this->usage,
                'replace_id'=>$this->replace,
                'stock_min'=>$this->stock_min,
                'stock_max'=>$this->stock_max,
                'stock' => $this->stock,
            ]);
            
            $this->conector=Connector::create([
                'material_id' => $this->material->id,
                'number_of_ways' => $this->number_of_ways,
                'type' => $this->type,
                'connector_id' => $this->connector,
                'watertight' => $this->watertight,
                'lock' => $this->lock,
                'cover' => $this->cover,
            ]);
            foreach($this->terminales as $ter){
                $term=Terminal::where('material_id', $ter[0])->first();
                ConnectorTerminal::create([
                    'connector_id' => $this->conector->id,
                    'terminal_id' => $term->id,
                ]);
            }
            foreach($this->sellos as $sel){
                $sell=Seal::where('material_id', $sel[0])->first();
                ConnectorSeal::create([
                    'connector_id' => $this->conector->id,
                    'seal_id' => $sell->id,
                ]);
            }
            
            if(!empty($this->images)){
                foreach ($this->images as $key => $image) {
                    $this->images[$key] = $image->store('materials','public');
                }
                
                $this->images = json_encode($this->images);
                $this->material->image = $this->images;
            }
            $this->material->save();
        }elseif($this->family == 'Terminales'){
           
            $regex = '/^[\d]{0,4}(\.[\d]{1,8})?$/';

            $this->validate([
                'size' => 'numeric|nullable|min:1|max:99999',
                'minimum_section' => 'numeric|nullable|regex: '.$regex,
                'maximum_section' => 'numeric|nullable|regex: '.$regex,
                'term_material' => 'nullable',
                'term_type' => 'nullable'
            ], [
                'size.numeric' => 'El campo tamaño es numérico(decimales separados por púnto)',
                'size.min' => 'El campo tamaño debe ser un número mayor a 0(cero)',
                'size.max' => 'El campo tamaño debe ser un número de 5 cifras como máximo',
                'minimum_section.numeric' => 'El campo sección mínima es numérico (decimales separados por punto)',
                'maximum_section.numeric' => 'El campo sección máxima es numérico (decimales separados por punto)',
                'minimum_section.regex' => 'El campo sección mínima es un número de máximo 4 cifras con 2 posiciones decimales',
                'maximum_section.regex' => 'El campo sección máxima es un número de máximo 4 cifras con 2 posiciones decimal',   
            ]);
            $this->material=Material::create([
                'code' => $this->code,
                'name' => $this->name,
                'family' => $this->family,
                'color' => $this->color,
                'description' => $this->description,
                'line'=>$this->line,
                'usage'=>$this->usage,
                'replace_id'=>$this->replace,
                'stock_min'=>$this->stock_min,
                'stock_max'=>$this->stock_max,
            ]);
            Terminal::create([
                'material_id' => $this->material->id,
                'size' => $this->size,
                'minimum_section' => (!empty($this->minimum_section)) ? $this->minimum_section : 0,
                'maximum_section' => (!empty($this->maximum_section)) ? $this->maximum_section : 0,
                'material' => $this->term_material,
                'type' => $this->term_type,
            ]);
            if(!empty($this->images)){
                foreach ($this->images as $key => $image) {
                    $this->images[$key] = $image->store('materials','public');
                }
                
                $this->images = json_encode($this->images);
                $this->material->image = $this->images;
            }
            $this->material->save();
        }elseif($this->family == 'Cables'){
          
            $regex = '/^[\d]{0,4}(\.[\d]{1,8})?$/';


            $this->validate([
                'section' => 'numeric|nullable|regex: '.$regex,
                'base_color' => 'nullable',
                'line_color' => 'nullable',
                'braid_configuration' => 'nullable',
                'norm' =>  'nullable',
                'number_of_unipolar' => 'numeric|nullable|min:1',
                'mesh_type' => 'string|nullable',
                'operating_temperature' => 'numeric|nullable|regex: '.$regex,
            ], [
                'section.numeric' => 'El campo sección es numérico (decimales separados por punto)',
                'section.regex' => 'El campo sección es un número de máximo 4 cifras con 2 posiciones decimales',
                'number_of_unipolar.numeric' => 'El campo Cantidad de unipolares es numérico (decimales separados por punto)',
                'number_of_unipolar.min' => 'El campo Cantidad de unipolares debe ser un número mayor a cero (0) ',
                'operating_temperature.numeric' => 'El campo Temperatura de Servicio es numérico (decimales separados por punto)',
                'operating_temperature.regex' => 'El campo Temperatura de Servicio es un número de máximo 4 cifras con 2 posiciones decimales',
            ]);
            $this->material=Material::create([
                'code' => $this->code,
                'name' => $this->name,
                'family' => $this->family,
                'color' => ' ',
                'description' => $this->description,
                'line'=>$this->line,
                'usage'=>$this->usage,
                'replace_id'=>$this->replace,
                'stock_min'=>$this->stock_min,
                'stock_max'=>$this->stock_max,
            ]);
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
            if(!empty($this->images)){
                foreach ($this->images as $key => $image) {
                    $this->images[$key] = $image->store('materials','public');
                }
                
                $this->images = json_encode($this->images);
                $this->material->image = $this->images;
            }
            $this->material->save();
        }elseif($this->family == 'Sellos'){
          
            $regex = '/^[\d]{0,4}(\.[\d]{1,8})?$/';

            $this->validate([
                'minimum_diameter' => 'numeric|nullable|regex: '.$regex,
                'maximum_diameter' => 'numeric|nullable|regex: '.$regex,
                'seal_type' => 'nullable|max:30',
                ], [
                'minimum_diameter.numeric' => 'El campo Diámetro mínimo de Cable es numérico (decimales separados por punto)',
                'minimum_diameter.regex' => 'El campo Diámetro mínimo de Cable es un número de máximo 4 cifras con 2 posiciones decimales',
                'maximum_diameter.numeric' => 'El campo Diámetro máximo de Cable es numérico (decimales separados por punto)',
                'maximum_diameter.regex' => 'El campo Diámetro máximo de Cable es un número de máximo 4 cifras con 2 posiciones decimales',
                'seal_type.max' => 'El campo Tipo de sello debe ser inferior a 30 carácteres'
            ]);
            $this->material=Material::create([
                'code' => $this->code,
                'name' => $this->name,
                'family' => $this->family,
                'color' => $this->color,
                'description' => $this->description,
                'line'=>$this->line,
                'usage'=>$this->usage,
                'replace_id'=>$this->replace,
                'stock_min'=>$this->stock_min,
                'stock_max'=>$this->stock_max,
            ]);
            Seal::create([
                'material_id' => $this->material->id,
                'minimum_diameter' => $this->minimum_diameter,
                'maximum_diameter' => $this->maximum_diameter,
                'type' => $this->seal_type,
            ]);
            if(!empty($this->images)){
                foreach ($this->images as $key => $image) {
                    $this->images[$key] = $image->store('materials','public');
                }
                
                $this->images = json_encode($this->images);
                $this->material->image = $this->images;
            }
            $this->material->save();
        }elseif($this->family == 'Tubos'){
          
            $regex = '/^[\d]{0,4}(\.[\d]{1,2})?$/';
            if($this->tube_type=="Termocontraible"){
            $this->validate([
                'tube_diameter' => 'numeric|nullable|regex: '.$regex,
                'tube_type' => 'nullable',
                'wall_thickness' => 'numeric|nullable|regex: '.$regex,
                'contracted_diameter' => 'numeric|nullable|regex: '.$regex,
                'minimum_temperature' => 'numeric|nullable|min:0|max:9999',
                'maximum_temperature' => 'numeric|nullable|min:0|max:9999',
            ], [
                'tube_diameter.numeric' => 'El campo Diámetro es numérico (decimales separados por punto)',
                'tube_diameter.regex' => 'El campo Diámetro es un número de máximo 4 cifras con 2 posiciones decimal',
                'wall_thickness.numeric' => 'El campo Espesor de Pared es numérico (decimales separados por punto)',
                'wall_thickness.regex' => 'El campo Espesor de Pared es un número de máximo 4 cifras con 2 posiciones decimal',
                'contracted_diameter.numeric' => 'El campo Diámetro Contraído es numérico (decimales separados por punto)',
                'contracted_diameter.regex' => 'El campo Diámetro Contraído es un número de máximo 4 cifras con 2 posiciones decimal',
                'minimum_temperature.numeric' => 'El campo Temperatura mínima de Servicio es numérico (decimales separados por punto)',
                'minimum_temperature.min' => 'El campo Temperatura mínima de Servicio es como mínimo 0°C',
                'minimum_temperature.max' => 'El campo Temperatura mínima de Servicio es un número de máximo 4 cifras con 2 posiciones decimal',
                'maximum_temperature.numeric' => 'El campo Temperatura máxima de Servicio es numérico (decimales separados por punto)',
                'maximum_temperature.min' => 'El campo Temperatura máxima de Servicio es como mínimo 0°C',
                'maximum_temperature.max' => 'El campo Temperatura máxima de Servicio es un número de máximo 4 cifras con 2 posiciones decimal',
            ]);
            }else{
                $this->validate([
                    'tube_diameter' => 'numeric|nullable|regex: '.$regex,
                    'wall_thickness' => 'numeric|nullable|regex: '.$regex,
                ], [
                    'tube_diameter.numeric' => 'El campo Diámetro es numérico (decimales separados por punto)',
                    'tube_diameter.regex' => 'El campo Diámetro es un número de máximo 4 cifras con 2 posiciones decimal',
                    'wall_thickness.numeric' => 'El campo Espesor de Pared es numérico (decimales separados por punto)',
                    'wall_thickness.regex' => 'El campo Espesor de Pared es un número de máximo 4 cifras con 2 posiciones decimal',
                              ]);
            }
            $this->material=Material::create([
                'code' => $this->code,
                'name' => $this->name,
                'family' => $this->family,
                'color' => $this->color,
                'description' => $this->description,
                'line'=>$this->line,
                'usage'=>$this->usage,
                'replace_id'=>$this->replace,
                'stock_min'=>$this->stock_min,
                'stock_max'=>$this->stock_max,
            ]);
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
            if(!empty($this->images)){
                foreach ($this->images as $key => $image) {
                    $this->images[$key] = $image->store('materials','public');
                }
                
                $this->images = json_encode($this->images);
                $this->material->image = $this->images;
            }
            $this->material->save();
        }elseif($this->family == 'Clips'){
          
            $regex = '/^[\d]{0,4}(\.[\d]{1,8})?$/';

            $this->validate([
                'long' => 'numeric|nullable|regex: '.$regex,
                'width' => 'numeric|nullable|regex: '.$regex,
                'hole_diameter' => 'numeric|nullable|regex: '.$regex,
                'clip_type' => 'nullable',
     ], [
                'long.numeric' => 'El campo Largo es numérico (decimales separados por punto)',
                'long.regex' => 'El campo Largo es un número de máximo 4 cifras con 2 posiciones decimales',
                'width.numeric' => 'El campo Ancho es numérico (decimales separados por punto)',
                'width.regex' => 'El campo Ancho es un número de máximo 4 cifras con 2 posiciones decimales',
                'hole_diameter.numeric' => 'El campo Diámetro del Orificio es numérico (decimales separados por punto)',
                'hole_diameter.regex' => 'El campo Diámetro del Orificio es un número de máximo 4 cifras con 2 posiciones decimales',
            ]);
            $this->material=Material::create([
                'code' => $this->code,
                'name' => $this->name,
                'family' => $this->family,
                'color' => $this->color,
                'description' => $this->description,
                'line'=>$this->line,
                'usage'=>$this->usage,
                'replace_id'=>$this->replace,
                'stock_min'=>$this->stock_min,
                'stock_max'=>$this->stock_max,
            ]);
            Clip::create([
                'material_id' => $this->material->id,
                'long' => $this->long,
                'width' => $this->width,
                'hole_diameter' => $this->hole_diameter,
                'type' => $this->clip_type,
            ]);
            if(!empty($this->images)){
                foreach ($this->images as $key => $image) {
                    $this->images[$key] = $image->store('materials','public');
                }
                
                $this->images = json_encode($this->images);
                $this->material->image = $this->images;
            }
            $this->material->save();
        }else{
            $this->validate([
                'accesory_type' => 'nullable',
            ]);

            $this->material=Material::create([
                'code' => $this->code,
                'name' => $this->name,
                'family' => $this->family,
                'color' => $this->color,
                'description' => $this->description,
                'line'=>$this->line,
                'usage'=>$this->usage,
                'replace_id'=>$this->replace,
                'stock_min'=>$this->stock_min,
                'stock_max'=>$this->stock_max,
            ]);
            Accessory::create([
                'material_id' => $this->material->id,
                'type' => $this->accesory_type,
            ]);
            if(!empty($this->images)){
                foreach ($this->images as $key => $image) {
                    $this->images[$key] = $image->store('materials','public');
                }
                
                $this->images = json_encode($this->images);
                $this->material->image = $this->images;
            }
            $this->material->save();
        }
        $this->div=null;
        $this->agregamat($this->material);
    }
    
    public function update(Material $material)
    {   
        $this->search=null;
        $this->terminales=[];
        $this->addterminal=[];
        $this->count_terminales=0;
        $this->sellos=[];
        $this->addsello=[];
        $this->count_sellos=0;
        $this->resetValidation();
        $this->disabled='disabled';
        $this->idu=$material->id;
        $this->material =Material::find($this->idu);
        $this->name=$material->name; 
        $this->family=$material->family;
        $this->color=$material->color;
        $this->code=$material->code;
        $this->description=$material->description;
        $this->replace_id=$material->replace_id;
        $this->rplce = Material::where('id',$this->replace_id)->first();
        $this->stock_min=$material->stock_min;
        $this->stock_max=$material->stock_max;
        $this->stock=$material->stock;
        $this->usage=$material->usage;
        $this->line=$material->line;
        $this->div=$material->family;
        $this->images_up=json_decode($material->image);
        $this->images = json_decode($material->image);
        $this->info_line=Line::all();
        $this->info_usage=Usage::all();
        $this->info_con=Connector::all();
        $this->show_replace = ($material->family == 'Cables' || $material->family == 'Tubos') ? false : true;
        $this->material_family = Material::where('family', $this->family)->whereNotIn('id', [$material->id])->get();
        $this->con();
        $this->showColor = ($material->family == 'Terminales' || $material->family == 'Cables') ? false : true;

        if($this->family == 'Conectores'){
            $this->conn = Connector::where('material_id',$material->id)->first();
            $this->conn_id=$this->conn->id;
            $this->number_of_ways=$this->conn->number_of_ways;
            $this->type=$this->conn->type;
            $this->terminal_id=$this->conn->terminals()->get();
            $this->cover=$this->conn->cover;
            $this->lock=$this->conn->lock;
            $this->seal_id=$this->conn->seals()->get();
            $this->connector_id=$this->conn->connector_id;
            $this->watertight=$this->conn->watertight;
            if($this->conn !=null){
                foreach($this->terminal_id as $ter){
                    $material=Material::where('id',$ter->material_id)->first();
                    $this->addterminal[0]=$material->id;
                    $this->addterminal[1]=$material->name;
                    $this->addterminal[2]=$material->code;
                    $this->addterminal[3]=$material->terminal->size;
                    $this->addterminal[4]=$material->terminal->minimum_section;
                    $this->addterminal[5]=$material->terminal->maximum_section;
                    $this->addterminal[6]=$this->count_terminales;
                    $this->terminales[$this->count_terminales]=$this->addterminal;
                    $this->count_terminales++;
                }
                foreach($this->seal_id as $sel){
                    $material=Material::where('id',$sel->material_id)->first();
                    $this->addsello[0]=$material->id;
                    $this->addsello[1]=$material->name;
                    $this->addsello[2]=$material->code;
                    $this->addsello[3]=$material->seal->type;
                    $this->addsello[4]=$material->seal->minimum_diameter;
                    $this->addsello[5]=$material->seal->maximum_diameter;
                    $this->addsello[6]=$this->count_sellos;
                    $this->sellos[$material->id]=$this->addsello;
                    $this->count_sellos++;
                }
                $this->connect = Connector::where('id',$this->connector_id)->first();
            }   
        }elseif($this->family == 'Terminales'){
            $this->term = Terminal::where('material_id',$material->id)->first();
            $this->term_id=$this->term->id;
            $this->size=$this->term->size;
            $this->minimum_section=$this->term->minimum_section;
            $this->maximum_section=$this->term->maximum_section;
            $this->term_material=$this->term->material;
            $this->term_type=$this->term->type;
        }elseif($this->family == 'Cables'){
            $this->cab = Cable::where('material_id',$material->id)->first();
            $this->cab_id= $this->cab->id;
            $this->section=$this->cab->section;
            $this->base_color=$this->cab->base_color;
            $this->line_color=$this->cab->line_color;
            $this->braid_configuration=$this->cab->braid_configuration;
            $this->norm=$this->cab->norm;
            $this->number_of_unipolar=$this->cab->number_of_unipolar;
            $this->mesh_type=$this->cab->mesh_type;
            $this->operating_temperature=$this->cab->operating_temperature;
        }elseif($this->family == 'Tubos'){
            $this->tub = Tube::where('material_id',$material->id)->first();
            $this->tub_id= $this->tub->id;
            $this->tube_diameter=$this->tub->diameter;
            $this->wall_thickness=$this->tub->wall_thickness;
            $this->contracted_diameter=$this->tub->contracted_diameter;
            $this->minimum_temperature=$this->tub->minimum_temperature;
            $this->maximum_temperature=$this->tub->maximum_temperature;
            $this->tube_type=$this->tub->type;
        }elseif($this->family == 'Clips'){
            $this->clip = Clip::where('material_id',$material->id)->first();
            $this->clip_id= $this->clip->id;
            $this->long=$this->clip->long;
            $this->width=$this->clip->width;
            $this->hole_diameter=$this->clip->hole_diameter;
            $this->clip_type=$this->clip->type;
        }elseif($this->family == 'Accesorios'){
            $this->acc = Accessory::where('material_id',$material->id)->first();
            $this->acc_id= $this->acc->id;
            $this->accesory_type=$this->acc->type;
        }else{
            $this->sl = Seal::where('material_id',$material->id)->first();  
            $this->sl_id=$this->sl->id;
            $this->minimum_diameter=$this->sl->minimum_diameter;
            $this->maximum_diameter=$this->sl->maximum_diameter;
            $this->seal_type=$this->sl->type;
        }
        
        $this->funcion="actualizar";
        $this->explora="inactivo";
    }

    public function editar(){
        $this->validate([
            'code' => 'required|max:20',
            'family' => 'required',
            'color' => 'nullable',
            'description' => 'max:500|nullable',
            'line' => 'nullable',
            'usage' => 'nullable',
            'replace' => 'nullable',
            'stock_min' => 'numeric|nullable|min:1|max:999999',
            'stock_max' => 'numeric|nullable|min:1|max:999999',
            'images.*' => 'nullable|max:20480',
        ],[
            'code.required' => 'El campo código es requerido',
            'code.max' => 'El campo código tiene como máximo 20 caracteres',
            'family.required' => 'El campo familia es requerido',
            'description.max' => 'El campo descripción no debe superar 500 carácteres',
            'stock_min.required' => 'El campo stock mínimo es requerido',
            'stock_min.numeric' => 'El campo stock mínimo es numérico (decimales separados por punto)',
            'stock_min.min' => 'El campo stock mínimo debe ser un número mayor a 0(cero).',
            'stock_min.max' => 'El campo stock mínimo es inferior a 6 digitos.',
            'stock_max.numeric' => 'El campo stock máximo es numérico (decimales separados por punto)',
            'stock_max.min' => 'El campo stock máximo debe ser un número mayor a 0(cero).',
            'stock_max.max' => 'El campo stock máximo es inferior a 6 digitos.',
            'images.*.max' => 'La imagen que inteta adjuntar superan el límite de peso (20MB)'
        ]);
        $material_up =Material::find($this->idu);
        $material_up->name=$this->name;
        $material_up->code=$this->code;
        $material_up->family=$this->family;
        if($this->family == 'Conectores'){
          
            $this->validate([
                'terminal' => 'nullable',
                'seal' => 'nullable',
                'number_of_ways' => 'numeric|integer|min:1|max:999|nullable',
                'type' => 'nullable',
                'connector' =>'nullable',
                'watertight' =>'nullable|boolean',
                'lock' =>'nullable|boolean',
                'cover' =>'nullable|boolean'
            ], [
                'number_of_ways.numeric' => 'El campo cantidad de vías es numérico (decimales separados por punto)',
                'number_of_ways.integer' => 'El campo cantidad de vías es un número natural',
                'number_of_ways.min' => 'El campo cantidad de vías debe ser un número entero de 1 a 999',
                'number_of_ways.max' => 'El campo cantidad de vías debe ser un número entero de 1 a 999',
                'watertight.boolean' => 'El campo estanco debe ser sí o no',
                'lock.boolean' => 'El campo traba secundaria debe ser sí o no',
                'cover.boolean' => 'El campo tapa debe ser sí o no',
            ]);

            $connector_up =Connector::find($this->conn_id);
            if($connector_up == null){
                Connector::create([
                    'material_id' => $this->material->id,
                    'number_of_ways' => $this->number_of_ways,
                    'type' => $this->type,
                    'connector_id' => $this->connector,
                    'watertight' => $this->watertight,
                    'lock' => $this->lock,
                    'cover' => $this->cover,
                    
                ]);
            }else{
                $connector_up->material_id=$this->idu;
                $connector_up->number_of_ways=$this->number_of_ways;
                $connector_up->type=$this->type;
                $connector_up->connector_id=$this->connector;
                $connector_up->watertight=$this->watertight;
                $connector_up->cover=$this->cover;
                $connector_up->lock=$this->lock;
                $connector_up->save();
                $terminals_of_connector=ConnectorTerminal::where('connector_id',$connector_up->id)->get();
                foreach($terminals_of_connector as $t_o_c){
                    $t_o_c->delete();
                }
                foreach($this->terminales as $ter){
                    $term=Terminal::where('material_id', $ter[0])->first();
                    ConnectorTerminal::create([
                        'connector_id' => $connector_up->id,
                        'terminal_id' => $term->id,
                    ]);
                }
                $seals_of_connector=ConnectorSeal::where('connector_id',$connector_up->id)->get();
                foreach($seals_of_connector as $s_o_c){
                    $s_o_c->delete();
                }
                foreach($this->sellos as $sel){
                    $sell=Seal::where('material_id', $sel[0])->first();
                    ConnectorSeal::create([
                        'connector_id' => $connector_up->id,
                        'seal_id' => $sell->id,
                    ]);
                }
            }
        }elseif($this->family == 'Terminales'){
            $regex = '/^[\d]{0,4}(\.[\d]{1,8})?$/';

            $this->validate([
                'size' => 'numeric|nullable|min:1|max:99999',
                'minimum_section' => 'numeric|nullable|regex: '.$regex,
                'maximum_section' => 'numeric|nullable|regex: '.$regex,
                'term_material' => 'nullable',
                'term_type' => 'nullable'
            ], [
                'size.numeric' => 'El campo tamaño es numérico',
                'size.min' => 'El campo tamaño debe ser un número mayor a 0(cero)',
                'size.max' => 'El campo tamaño debe ser un número de 5 cifras como máximo',
                'minimum_section.numeric' => 'El campo sección mínima es numérico (decimales separados por punto)',
                'maximum_section.numeric' => 'El campo sección máxima es numérico (decimales separados por punto)',
                'minimum_section.regex' => 'El campo sección mínima es un número de máximo 4 cifras con 2 posiciones decimales',
                'maximum_section.regex' => 'El campo sección máxima es un número de máximo 4 cifras con 2 posiciones decimales',      
            ]);

            $terminal_up =Terminal::find($this->term_id);
            if($terminal_up == null){
                Terminal::create([
                    'material_id' => $this->material->id,
                    'size' => $this->size,
                    'minimum_section' => (!empty($this->minimum_section)) ? $this->minimum_section : 0,
                    'maximum_section' =>(!empty($this->maximum_section)) ? $this->maximum_section : 0,
                    'material' => $this->term_material,
                    'type' => $this->term_type,
                ]);
            }else{
                $terminal_up->material_id=$this->idu;
                $terminal_up->size=$this->size;
                $terminal_up->minimum_section=(!empty($this->minimum_section)) ? $this->minimum_section : 0;
                $terminal_up->maximum_section=(!empty($this->maximum_section)) ? $this->maximum_section : 0;
                $terminal_up->material=$this->term_material;
                $terminal_up->type=$this->term_type;
                $terminal_up->save();
            }           
        }elseif($this->family == 'Cables'){
            $regex = '/^[\d]{0,4}(\.[\d]{1,8})?$/';

            $this->validate([
                'section' => 'numeric|nullable|regex: '.$regex,
                'base_color' => 'nullable',
                'line_color' => 'nullable',
                'braid_configuration' => 'nullable',
                'norm' =>  'nullable',
                'number_of_unipolar' => 'numeric|nullable|min:1',
                'mesh_type' => 'string|nullable',
                'operating_temperature' => 'numeric|nullable|regex: '.$regex,
            ], [
                'section.numeric' => 'El campo sección es numérico (decimales separados por punto)',
                'section.regex' => 'El campo sección es un número de máximo 4 cifras con 2 posiciones decimales',
                'number_of_unipolar.numeric' => 'El campo Cantidad de unipolares es numérico (decimales separados por punto)',
                'number_of_unipolar.min' => 'El campo Cantidad de unipolares debe ser un número mayor a cero (0) ',
                'operating_temperature.numeric' => 'El campo Temperatura de Servicio es numérico (decimales separados por punto)',
                'operating_temperature.regex' => 'El campo Temperatura de Servicio es un número de máximo 4 cifras con 2 posiciones decimales',

            ]);
            
            $cable_up =Cable::find($this->cab_id);
            if($cable_up == null){
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
            }else{
                $cable_up->material_id=$this->idu;
                $cable_up->section=$this->section;
                $cable_up->base_color=$this->base_color;
                $cable_up->line_color=$this->line_color;
                $cable_up->braid_configuration=$this->braid_configuration;
                $cable_up->norm=$this->norm;
                $cable_up->number_of_unipolar=$this->number_of_unipolar;
                $cable_up->mesh_type=$this->mesh_type;
                $cable_up->operating_temperature=$this->operating_temperature;
                $cable_up->save();
            }
        }elseif($this->family == 'Tubos'){
            $regex = '/^[\d]{0,4}(\.[\d]{1,8})?$/';

            $this->validate([
                'tube_diameter' => 'numeric|nullable|regex: '.$regex,
                'tube_type' => 'nullable',
                'wall_thickness' => 'numeric|nullable|regex: '.$regex,
                'contracted_diameter' => 'numeric|nullable|regex: '.$regex,
                'minimum_temperature' => 'numeric|nullable|min:0|max:9999',
                'maximum_temperature' => 'numeric|nullable|min:0|max:9999',
            ], [
                'tube_diameter.numeric' => 'El campo Diámetro es numérico (decimales separados por punto)',
                'tube_diameter.regex' => 'El campo Diámetro es un número de máximo 4 cifras con 2 posiciones decimales',
                'wall_thickness.numeric' => 'El campo Espesor de Pared es numérico (decimales separados por punto)',
                'wall_thickness.regex' => 'El campo Espesor de Pared es un número de máximo 4 cifras con 2 posiciones decimales',
                'contracted_diameter.numeric' => 'El campo Diámetro Contraído es numérico (decimales separados por punto)',
                'contracted_diameter.regex' => 'El campo Diámetro Contraído es un número de máximo 4 cifras con 2 posiciones decimales',
                'minimum_temperature.numeric' => 'El campo Temperatura mínima de Servicio es numérico (decimales separados por punto)',
                'minimum_temperature.min' => 'El campo Temperatura es como mínimo 0°C',
                'minimum_temperature.max' => 'El campo Temperatura mínima de Servicio es un número de máximo 4 cifras con 2 posiciones decimales',
                'maximum_temperature.numeric' => 'El campo Temperatura máxima de Servicio es numérico (decimales separados por punto)',
                'maximum_temperature.min' => 'El campo Temperatura máxima es como mínimo -0°C',
                'maximum_temperature.max' => 'El campo Temperatura máxima de Servicio es un número de máximo 4 cifras con 2 posiciones decimales',
            ]);

            $tube_up =Tube::find($this->tub_id);
            if($tube_up == null){
                Tube::create([
                    'material_id' => $this->material->id,
                    'diameter' => $this->tube_diameter,
                    'wall_thickness' => $this->wall_thickness,
                    'contracted_diameter' => ($this->tube_type == 'Termocontraible') ? $this->contracted_diameter : 0,
                    'minimum_temperature' => ($this->tube_type == 'Termocontraible') ? $this->minimum_temperature : 0,
                    'maximum_temperature' => ($this->tube_type == 'Termocontraible') ? $this->maximum_temperature : 0,
                    'type' => $this->tube_type,
                ]);
            }else{
                $tube_up->material_id=$this->idu;
                $tube_up->diameter=$this->tube_diameter;
                $tube_up->wall_thickness=$this->wall_thickness;
                $tube_up->contracted_diameter=($this->tube_type == 'Termocontraible') ? $this->contracted_diameter : 0;
                $tube_up->minimum_temperature=($this->tube_type == 'Termocontraible') ? $this->minimum_temperature : 0;
                $tube_up->maximum_temperature=($this->tube_type == 'Termocontraible') ? $this->maximum_temperature : 0;
                $tube_up->type=$this->tube_type;
                $tube_up->save();
            }
        }elseif($this->family == 'Clips'){
                $regex = '/^[\d]{0,4}(\.[\d]{1,8})?$/';
    
                $this->validate([
                    'long' => 'numeric|nullable|regex: '.$regex,
                    'width' => 'numeric|nullable|regex: '.$regex,
                    'hole_diameter' => 'numeric|nullable|regex: '.$regex,
                    'clip_type' => 'nullable',
         ], [
                    'long.numeric' => 'El campo Largo es numérico (decimales separados por punto)',
                    'long.regex' => 'El campo Largo es un número de máximo 4 cifras con 2 posiciones decimales',
                    'width.numeric' => 'El campo Ancho es numérico (decimales separados por punto)',
                    'width.regex' => 'El campo Ancho es un número de máximo 4 cifras con 2 posiciones decimales',
                    'hole_diameter.numeric' => 'El campo Diámetro del Orificio es numérico (decimales separados por punto)',
                    'hole_diameter.regex' => 'El campo Diámetro del Orificio es un número de máximo 4 cifras con 2 posiciones decimales',
                ]);
            
                $clip_up =Clip::find($this->clip_id);
                if($clip_up == null){
                    Clip::create([
                        'material_id' => $this->material->id,
                        'long' => $this->long,
                        'width' => $this->width,
                        'hole_diameter' => $this->hole_diameter,
                        'type' => $this->clip_type,
                    ]);
                }else{
                $clip_up->material_id=$this->idu;
                $clip_up->long=$this->long;
                $clip_up->width=$this->width;
                $clip_up->hole_diameter=$this->hole_diameter;
                $clip_up->type=$this->clip_type;
                $clip_up->save();
                }
            }elseif($this->family == 'Accesorios'){
                    $regex = '/^[\d]{0,4}(\.[\d]{1,8})?$/';
                    $this->validate([
                            'accesory_type' => 'nullable',
                    ]);
                    $accesory_up =Accessory::find($this->acc_id);
                    if($accesory_up == null){
                        Accessory::create([
                            'material_id' => $this->material->id,
                            'type' => $this->accesory_type,
                        ]);
                    }else{
                    $accesory_up->material_id=$this->idu;
                    $accesory_up->type=$this->accesory_type;
                    $accesory_up->save();
                }
            }else{
                        $regex = '/^[\d]{0,4}(\.[\d]{1,8})?$/';

                        $this->validate([
                            'minimum_diameter' => 'numeric|nullable|regex: '.$regex,
                            'maximum_diameter' => 'numeric|nullable|regex: '.$regex,
                            'seal_type' => 'nullable|max:30',
                            ], [
                            'minimum_diameter.numeric' => 'El campo Diámetro mínimo de Cable es numérico (decimales separados por punto)',
                            'minimum_diameter.regex' => 'El campo Diámetro mínimo de Cable es un número de máximo 4 cifras con 2 posiciones decimales',
                            'maximum_diameter.numeric' => 'El campo Diámetro máximo de Cable es numérico (decimales separados por punto)',
                            'maximum_diameter.regex' => 'El campo Diámetro máximo de Cable es un número de máximo 4 cifras con 2 posiciones decimales',
                            'seal_type.max' => 'El campo Tipo de sello debe ser inferior a 30 carácteres'
                        ]);

                        $seal_up =Seal::find($this->sl_id);
                        if($seal_up == null){
                            Seal::create([
                                'material_id' => $this->material->id,
                                'minimum_diameter' => $this->minimum_diameter,
                                'maximum_diameter' => $this->maximum_diameter,
                                'type' => $this->seal_type,
                            ]);
                        }else{
                            $seal_up->material_id=$this->idu;    
                            $seal_up->minimum_diameter=$this->minimum_diameter;
                            $seal_up->maximum_diameter=$this->maximum_diameter;
                            $seal_up->type=$this->seal_type;
                            $seal_up->save();
                        }
            
                    }
        $material_up->color=($this->family != 'Cables') ? $this->color : '';
        $material_up->description=$this->description;
        $material_up->replace_id=$this->replace;
        $material_up->line=$this->line;
        $material_up->usage=$this->usage;
        $material_up->stock_min=$this->stock_min;
        $material_up->stock_max=$this->stock_max;
        $material_up->stock=$this->stock;
       
       # dd($this->images);
        if(!empty($this->images) && is_array($this->images)){
        if($material_up->image != null){
           if(!empty(array_diff($this->images, json_decode($material_up->image)))){
                    foreach (json_decode($material_up->image) as $key => $image) {
                        Storage::disk('public')->delete($image); 
                    }
            }
        }
      
            foreach ($this->images as $key => $image) {
                    if(!is_string($image)){
                        $this->images[$key] = $image->store('materials','public');
                    }

            }
            $this->images = json_encode($this->images);
            
            $material_up->image = $this->images;
            
        }
            
        
   
        $material_up->save();
        $this->funcion="";
    }

    public function back(){
        $this->div=null;
        $this->search=null;
        $this->funcion="";
        $this->explora='inactivo';  
       
    }

    public function explorar(Material $material_id){
        $this->material_id=$material_id;
        $this->name=$material_id->name; 
        $this->family=$material_id->family;
        $this->color=$material_id->color;
        $this->code=$material_id->code;
        $this->description=$material_id->description;
        $this->replace_id=$material_id->replace_id;
        $this->replace = Material::where('id',$this->replace_id)->first();
        $this->show_replace = ($material_id->family == 'Cables' || $material_id->family == 'Tubos') ? false : true;
        $this->stock_min=$material_id->stock_min;
        $this->stock_max=$material_id->stock_max;
        $this->stock=$material_id->stock;
        $this->usage=$material_id->usage;
        $this->line=$material_id->line;
        $this->div=$material_id->family;
        $this->showColor = ($material_id->family == 'Terminales' || $material_id->family == 'Cables') ? false : true;
        $this->images_up=json_decode($material_id->image);
        $this->images = json_decode($material_id->image);
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
       
        if($this->family == 'Conectores'){
            $this->terminales=[];
            $this->addterminal=[];
            $this->conn = Connector::where('material_id',$material_id->id)->first();
            $this->conn_id=$this->conn->id;
            $this->number_of_ways=$this->conn->number_of_ways;
            $this->type=$this->conn->type;
            $this->terminal_id=$this->conn->terminals()->get();
            $this->seal_id=$this->conn->seals()->get();
            $this->cover=$this->conn->cover;
            $this->lock=$this->conn->lock;
            $this->connector_id=$this->conn->connector_id;
            $this->watertight=$this->conn->watertight;
            if($this->conn !=null){
                foreach($this->terminal_id as $ter){
                    $material=Material::where('id',$ter->material_id)->first();
                    $this->addterminal[0]=$material->id;
                    $this->addterminal[1]=$material->name;
                    $this->addterminal[2]=$material->code;
                    $this->addterminal[3]=$material->terminal->size;
                    $this->addterminal[4]=$material->terminal->minimum_section;
                    $this->addterminal[5]=$material->terminal->maximum_section;
                    $this->addterminal[6]=$this->count_terminales;
                    $this->count_terminales++;
                }
                foreach($this->seal_id as $sel){
                    $material=Material::where('id',$sel->material_id)->first();
                    $this->addsello[0]=$material->id;
                    $this->addsello[1]=$material->name;
                    $this->addsello[2]=$material->code;
                    $this->addsello[3]=$material->seal->type;
                    $this->addsello[4]=$material->seal->minimum_diameter;
                    $this->addsello[5]=$material->seal->maximum_diameter;
                    $this->addsello[6]=$this->count_sellos;
                    $this->sellos[$material->id]=$this->addsello;
                    $this->count_sellos++;
                }
                $this->connect = Connector::where('id',$this->connector_id)->first();
            }   
        }elseif($this->family == 'Terminales'){
            $this->term = Terminal::where('material_id',$material_id->id)->first();
            $this->term_id=$this->term->id;
            $this->size=$this->term->size;
            $this->minimum_section=$this->term->minimum_section;
            $this->maximum_section=$this->term->maximum_section;
            $this->term_material=$this->term->material;
            $this->term_type=$this->term->type;
        }elseif($this->family == 'Cables'){
            $this->cab = Cable::where('material_id',$material_id->id)->first();
            if (!empty($this->cab)) {
                $this->cab_id= $this->cab->id;
                $this->section=$this->cab->section;
                $this->base_color=$this->cab->base_color;
                $this->line_color=$this->cab->line_color;
                $this->braid_configuration=$this->cab->braid_configuration;
                $this->norm=$this->cab->norm;
                $this->number_of_unipolar=$this->cab->number_of_unipolar;
                $this->mesh_type=$this->cab->mesh_type;
                $this->operating_temperature=$this->cab->operating_temperature;
            }
        }elseif($this->family == 'Tubos'){
            $this->tub = Tube::where('material_id',$material_id->id)->first();
            $this->tub_id= $this->tub->id;
            $this->tube_diameter=$this->tub->diameter;
            $this->wall_thickness=$this->tub->wall_thickness;
            $this->contracted_diameter=$this->tub->contracted_diameter;
            $this->minimum_temperature=$this->tub->minimum_temperature;
            $this->maximum_temperature=$this->tub->maximum_temperature;
            $this->tube_type=$this->tub->type;
        }elseif($this->family == 'Clips'){
            $this->clip = Clip::where('material_id',$material_id->id)->first();
            $this->clip_id= $this->clip->id;
            $this->long=$this->clip->long;
            $this->width=$this->clip->width;
            $this->hole_diameter=$this->clip->hole_diameter;
            $this->clip_type=$this->clip->type;
        }elseif($this->family == 'Accesorios'){
            $this->acc = Accessory::where('material_id',$material_id->id)->first();
            $this->acc_id= $this->acc->id;
            $this->accesory_type=$this->acc->type;
        }else{
            $this->sl = Seal::where('material_id',$material_id->id)->first();  
            $this->sl_id=$this->sl->id;
            $this->minimum_diameter=$this->sl->minimum_diameter;
            $this->maximum_diameter=$this->sl->maximum_diameter;
            $this->seal_type=$this->sl->type;
        }

        $this->material=Material::where('id', $this->material_id->id)->first();
        $this->provider_prices=ProviderPrice::where('material_id', $this->material->id)->orderBy('created_at','desc')->get();
        
        #$this->prices=Price::where('provider_id', $this->provider->id)->get();
      
        if($this->explora=='inactivo'){
            $this->explora='activo';
            $this->funcion=" ";
        }
    }

    public function con(){
        $this->div=$this->family;
        $this->show_replace = ($this->family == 'Cables' || $this->family == 'Tubos') ? false : true;
        $this->material_family = Material::where('family', $this->div)->where('code','!=',$this->code)->get();
        $this->showColor = ($this->family == 'Terminales' || $this->family == 'Cables') ? false : true;

        if(!empty($this->idu)){
            if($this->div == 'Conectores'){
                $this->conn = Connector::where('material_id',$this->idu)->first();
                $this->conn_id= $this->conn != null ? $this->conn->id : null;
            }elseif($this->div == 'Terminales'){
                $this->term = Terminal::where('material_id',$this->idu)->first();
                $this->term_id=$this->term != null ? $this->term->id : null;
            }elseif($this->div == 'Cables'){
                $this->cab = Cable::where('material_id',$this->idu)->first();
                $this->cab_id= $this->cab != null ? $this->cab->id : null;
            }elseif($this->div == 'Sellos'){
                $this->sl = Seal::where('material_id',$this->idu)->first();  
                $this->sl_id=$this->sl != null ? $this->sl->id : null;
            }elseif($this->div == 'Tubos'){
                $this->tub = Tube::where('material_id',$this->idu)->first();
                $this->tub_id= $this->tub != null ? $this->tub->id : null;
            }elseif($this->div == 'Accesorios'){
                $this->acc = Accessory::where('material_id',$this->idu)->first();
                $this->acc_id= $this->acc != null ? $this->acc->id : null;
            }elseif($this->div == 'Clips'){
                $this->clip = Clip::where('material_id',$this->idu)->first();
                $this->clip_id= $this->clip != null ? $this->clip->id : null;
            }
        }
       
        
   }

   public function destruir(Material $material)
   {
       $this->material=$material;
       $this->dispatchBrowserEvent('show-borrar');
   }

   public function delete(Material $material){
    if(auth()->user()->cannot('delete', auth()->user())){
        abort(403);
    }else{
        if($this->material->family == 'Conectores'){
            $this->conn_del = Connector::where('material_id',$this->material->id)->first();
            $seals_of_connector=ConnectorSeal::where('connector_id',$this->conn_del->id)->get();
            foreach($seals_of_connector as $s_o_c){
                $s_o_c->delete();
            }
            $terminals_of_connector=ConnectorTerminal::where('connector_id',$this->conn_del->id)->get();
            foreach($terminals_of_connector as $t_o_c){
                $t_o_c->delete();
            }
            $deleteFamily = $this->conn_del ? $this->conn_del->delete() : '';
        }elseif($this->material->family == 'Terminales'){
            $term_del = Terminal::where('material_id',$this->material->id)->first();
            $deleteFamily = $term_del ? $term_del->delete() : '';
        }elseif($material->family == 'Cables'){
            $cable_del = Cable::where('material_id',$this->material->id)->first();
            $deleteFamily = $cable_del ? $cable_del->delete() : '';
        }elseif($this->material->family == 'Tubos'){
            $tube_del = Tube::where('material_id',$this->material->id)->first();
            $deleteFamily = $tube_del ? $tube_del->delete() : '';
        }elseif($this->material->family == 'Clips'){
            $clip_del = Clip::where('material_id',$this->material->id)->first();
            $deleteFamily = $clip_del ? $clip_del->delete() : '';
        }elseif($this->material->family == 'Accesorios'){
            $accesory_del = Accessory::where('material_id',$this->material->id)->first();
            $deleteFamily = $accesory_del ? $accesory_del->delete() : '';
        }elseif($this->material->family == 'Sellos'){
            $seal_del = Seal::where('material_id',$this->material->id)->first();
            $deleteFamily = $seal_del ? $seal_del->delete() : '';
        }
        
        if(!empty($this->material->providerprices)){
            foreach ($this->material->providerprices as $provider_price) {
                 $provider_price->delete();
                
                if (!empty($provider_price->price)) {
                     foreach ($provider_price->price as $price) {
                         $price->delete();
                     }
                    
                }
            }
        }

        $this->material->delete();
        $this->funcion="";
        $this->explora="inactivo";
        $this->material=null;
    }
        $this->dispatchBrowserEvent('hide-borrar');
        $this->dispatchBrowserEvent('deleted');
   }

   public function agregamat(Material $material){
       
    $this->amount=null;
    $this->unit=null;
    $this->presentation=null;
    $this->provider=null;
    $this->usd_price=null;
    $this->ars_price=null;
    $this->info_pro = Provider::all();
    $this->mat_n = null;
    $this->name_provider = null;
    $this->addres_provider = null;
    $this->email_provider = null;
    $this->provider_new=null;
    $this->provider_material_code=null;
    $this->addProvider = true;
    $this->explora='inactivo';
    $this->funcion="crearmat";    
    $this->resetValidation();
}

public function storemat(Material $material){
    
    $this->validate([
        'amount' => 'nullable|numeric|min:0',
        'unit' => 'nullable|numeric|min:0',
        'presentation' => 'nullable',
        'provider_material_code' => 'nullable|string|min:1|max:50',
        'usd_price' => 'nullable|numeric|min:0',
        'ars_price' => 'nullable|numeric|min:0',
      ], [
        'amount.numeric' => 'El campo cantidad debe ser numérico (decimales separados por punto)',
        'amount.min' => 'El campo cantidad debe ser mayor a cero (0)',
        'unit.numeric' => 'El campo unidad debe ser numérico (decimales separados por punto)',
        'unit.min' => 'El campo unidad debe ser mayor a cero (0)',
        'presentation.required' => 'Seleccione una opción para el campo de la unidad de packaging',
        'provider_material_code.required' => 'El código de proveedor es requerido',
        'provider_material_code.string' => 'El código de proveedor es requerido',
        'provider_material_code.min'=>'El código de proveedor tiene como mínimo un caracter',
        'provider_material_code.max'=>'El código de proveedor tiene como máximo cincuenta caracteres',
        'usd_price.numeric' => 'El campo precio U$D debe ser numérico (decimales separados por punto)',
        'usd_price.min' => 'El campo  U$D  debe ser mayor a cero (0)',
        'ars_price.numeric' => 'El campo precio AR$ es numérico (decimales separados por punto)',
        'ars_price.min' => 'El campo  AR$  debe ser mayor a cero (0)',
    ]);
    
   $provider_price= ProviderPrice::create([
        'provider_id' =>$this->provider_new->id,
        'material_id' =>$material->id,
        'amount' =>$this->amount,
        'unit' =>$this->unit,
        'provider_code'=>$this->provider_material_code,
        'presentation' =>$this->presentation,
        'usd_price' =>$this->usd_price,
        'ars_price' =>$this->ars_price,
        
    ]);
    $price= Price::create([
         'date' => date("d-m-Y"),
         'provider_price_id' => $provider_price->id,
         'provider_id' =>$this->provider_new->id,
         'price' =>$this->usd_price,
    ]);
    $this->div=null;
    $this->addProvider = false;
    $this->provider_material_code=null;
    $this->funcion="0";
    $this->explorar($material);

}
public function destruirmat(Material $material)
{
        $material->delete();
        $this->funcion="0";
        $this->explorar($this->provider);
}

public function updatemat(ProviderPrice $provider_price)
{  
    $this->resetValidation();
    $this->id_provider_price = $provider_price->id;
    $this->material_price=$provider_price->material_id;
    $this->id_provider=$provider_price->provider_id;
    $this->amount=$provider_price->amount;
    $this->unit=$provider_price->unit;
    $this->provider_material_code=$provider_price->provider_code;
    $this->presentation=$provider_price->presentation;
    $this->usd_price=$provider_price->usd_price;
    $this->ars_price=$provider_price->ars_price;;
    $this->mat_n = $provider_price->provider;
    $this->info_pro = Provider::all();  
    $this->name_provider = null;
    $this->addres_provider = null;
    $this->email_provider = null;
    $this->provider_new = Provider::where('id', $provider_price->provider_id)->first();
    $this->addProvider = false;
    $this->explora= 'inactivo';
    $this->funcion="actualizarmat";
}

public function editarmat(){
    
    $this->validar=  $this->validate([
        'amount' => 'nullable|numeric|min:0',
        'unit' => 'nullable|numeric|min:0',
        'presentation' => 'nullable',
        'provider_material_code' => 'nullable|string|min:1|max:50',
        'usd_price' => 'nullable|numeric|min:0',
        'ars_price' => 'nullable|numeric|min:0',
      ], [
        'amount.numeric' => 'El campo cantidad debe ser numérico (decimales separados por punto)',
        'amount.min' => 'El campo cantidad debe ser mayor a cero (0)',
        'unit.numeric' => 'El campo unidad debe ser numérico (decimales separados por punto)',
        'unit.min' => 'El campo unidad debe ser mayor a cero (0)',
        'presentation.required' => 'Seleccione una opción para el campo de la unidad de packaging',
        'provider_material_code.required' => 'El código de proveedor es requerido',
        'provider_material_code.string' => 'El código de proveedor es requerido',
        'provider_material_code.min'=>'El código de proveedor tiene como mínimo un caracter',
        'provider_material_code.max'=>'El código de proveedor tiene como máximo cincuenta caracteres',
        'usd_price.numeric' => 'El campo precio U$D debe ser numérico (decimales separados por punto)',
        'usd_price.min' => 'El campo  U$D  debe ser mayor a cero (0)',
        'ars_price.numeric' => 'El campo precio AR$ es numérico (decimales separados por punto)',
        'ars_price.min' => 'El campo  AR$  debe ser mayor a cero (0)',
        ]);
        
        $pro =Material::find($this->material_price);
        $material_up =ProviderPrice::find($this->id_provider_price);
        $material_up->amount=$this->amount; 
        $material_up->material_id=$this->material_price;
        $material_up->provider_id=$this->provider_new->id;
        $material_up->unit=$this->unit;
        $material_up->presentation=$this->presentation;
        $material_up->provider_code=$this->provider_material_code;
        $material_up->ars_price=$this->ars_price;
    if($material_up->usd_price != $this->usd_price){
            $price= Price::create([
                'date' => date("d-m-Y"),
                'provider_price_id' => $this->id_provider_price,
                'provider_id' =>$this->provider_new->id,
                'price' =>$this->usd_price,
            ]);
    }
    $material_up->usd_price = $this->usd_price;
        $material_up->save();
        $this->funcion="0";
        $this->provider_material_code=null;
        $this->explorar($pro);
    }
    public function downprovider()
    {
        unset($this->provider_new);
        $this->addProvider = true;
    }
    public function backmat(){
        $this->funcion="0";
        $this->addProvider = false;
        #$this->explora='activo';   
        $this->explorar($this->material);
    }
    public function deleteImg($img){
    
        unset($this->images[$img]);
    
    }
    public function addProvider(){
        $this->id_provider=null;
        $this->name=null;
        $this->address=null;
        $this->phone=null;
        $this->email=null;
        $this->contact_name=null;
        $this->point_contact=null;
        $this->site_url=null;
        $this->provider_new = null;
        $this->dispatchBrowserEvent('show-form');
        $this->searchproviders="";

    }
    public function addproviderprice(){
        $this->validate([
            'name_provider' => 'required',
            'addres_provider' => 'required',
            'email_provider' => 'required|unique:providers,email|email',
          ], [
            'name_provider.required' => 'El campo nombre es requerido',
            'addres_provider.required' => 'El campo domicilio es requerido',
            'email_provider.required' => 'El campo correo electrónico para ventas es requerido',
            'email_provider.unique' => 'El correo electrónico para ventas ya se encuentra registrado',
            'email_provider.email' => 'El campo correo electrónico para ventas debe ser un email',
              ]);

        $this->provider = Provider::create([
            'name' => $this->name_provider,
            'address' => $this->addres_provider,
            'email' => $this->email_provider,
            'status'=>1
        ]);
  
        $this->showprovider($this->provider);
        $this->addProvider = false;
        $this->searchproviders="";
        $this->dispatchBrowserEvent('hide-form');

    }
    public function showprovider(Provider $provider){
        $this->provider_new=$provider;
    }
    public function selectprovider(Provider $provider)
    {
        $this->provider_new=$provider;
        $this->provider_name=$provider->name;
        $this->addProvider = false;
        $this->searchproviders="";
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
