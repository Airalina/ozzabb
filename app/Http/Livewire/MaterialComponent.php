<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Material;
use App\Models\Line;
use App\Models\Usage;
use App\Models\Terminal;
use App\Models\Seal;
use App\Models\Connector;
use App\Models\Cable;
use App\Models\ProviderPrice;
use Livewire\WithPagination;


class MaterialComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';


    public $ma,$search, $termi, $seli, $connect, $rplce, $info, $hola="", $funcion="", $explora="inactivo",  $order='name', $material, $materials, $material_id, $code, $name, $family, $terminal, $connector, $seal ,$color, $description, $line_id, $usage_id, $replace_id, $stock_min, $stock_max, $stock, $line, $usage, $replace, $info_line, $info_usage, $info_term, $info_sell, $div, $info_con, $number_of_ways, $type, $size, $minimum_section, $maximum_section, $material_family, $material_replace, $idu, $material_up, $connector_up, $conn, $term, $sl, $cab, $terminal_id, $seal_id, $connector_id, $conn_id, $term_id, $cab_id, $terminal_up, $cable_up, $seal_up, $conn_del, $seal_del, $term_del, $cable_del;

    public function render()
    {
        $this->materials = Material::where('code','like','%'.$this->search.'%')
            ->orWhere('name','LIKE','%'.$this->search.'%')
            ->orWhere('family','LIKE','%'.$this->search.'%')
            ->orWhere('color','LIKE','%'.$this->search.'%')
            ->orWhere('description','LIKE','%'.$this->search.'%')
            ->orWhere('line_id','LIKE','%'.$this->search.'%')
            ->orWhere('usage_id','LIKE','%'.$this->search.'%')
            ->orWhere('replace_id','LIKE','%'.$this->search.'%')
            ->orWhere('stock_min','LIKE','%'.$this->search.'%')
            ->orWhere('stock_max','LIKE','%'.$this->search.'%')
            ->orWhere('stock','LIKE','%'.$this->search.'%')
            ->orderBy($this->order)->get();
 
        
         return view('livewire.material-component', [
            'materials' => $this->materials,
        ]);
    }

    public function funcion()
    {
        $this->funcion="crear";
       #$this->id_provider=null;
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
        $this->sl=null;
        $this->cab=null;
        $this->seal_id=null;
        $this->rplce = null;
        $this->termi = null;
        $this->seli = null;
        $this->connect = null;
        $this->info_line=Line::all();
        $this->info_usage=Usage::all();
        $this->info_term=Terminal::all();
        $this->info_sell=Seal::all();
        $this->info_con=Connector::all();
    }

    public function store(){
        $this->validate([
            'code' => 'required',
            'name' => 'required',
            'family' => 'required',
            'color' => 'required',
            'description' => 'max:500|nullable',
            'line' => 'required',
            'usage' => 'required',
            'replace' => 'nullable',
            'stock_min' => 'numeric|required',
            'stock_max' => 'numeric|nullable',
            'stock' => 'numeric|required',
            
        ],[
            'code.required' => 'El campo código es requerido',
            'name.required' => 'El campo nombre es requerido',
            'family.required' => 'El campo familia es requerido',
            'color.required' => 'El campo color es requerido',
            'description.max' => 'El campo descripción no debe superar 500 carácteres',
            'line.required' => 'Seleccione una opción para el campo de línea',
            'usage.required' => 'Seleccione una opción para el campo de uso',
            'stock_min.required' => 'El campo stock mínimo es requerido',
            'stock_min.numeric' => 'El campo stock mínimo es numérico',
            'stock_max.numeric' => 'El campo stock máximo es numérico',
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
                'number_of_ways.digits' => 'El campo cantidad de vías debe ser de menor o igual a dos cifras',
                'number_of_ways.required' => 'El campo cantidad de vías es requerido',
                'type.required' => 'El campo tipo es requerido',
            ]);
            $this->material=Material::create([
                'code' => $this->code,
                'name' => $this->name,
                'family' => $this->family,
                'color' => $this->color,
                'description' => $this->description,
                'line_id'=>$this->line,
                'usage_id'=>$this->usage,
                'replace_id'=>$this->replace,
                'stock_min'=>$this->stock_min,
                'stock_max'=>$this->stock_max,
                'stock' => $this->stock
            ]);
            Connector::create([
                'material_id' => $this->material->id,
                'terminal_id' => $this->terminal,
                'seal_id' => $this->seal,
                'number_of_ways' => $this->number_of_ways,
                'type' => $this->type,
                'connector_id' => $this->connector,
            ]);
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
                'name' => $this->name,
                'family' => $this->family,
                'color' => $this->color,
                'description' => $this->description,
                'line_id'=>$this->line,
                'usage_id'=>$this->usage,
                'replace_id'=>$this->replace,
                'stock_min'=>$this->stock_min,
                'stock_max'=>$this->stock_max,
                'stock' => $this->stock
            ]);
            Terminal::create([
                'material_id' => $this->material->id,
                'size' => $this->size,
                'minimum_section' => $this->minimum_section,
                'maximum_section' => $this->maximum_section,
            ]);
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
                'name' => $this->name,
                'family' => $this->family,
                'color' => $this->color,
                'description' => $this->description,
                'line_id'=>$this->line,
                'usage_id'=>$this->usage,
                'replace_id'=>$this->replace,
                'stock_min'=>$this->stock_min,
                'stock_max'=>$this->stock_max,
                'stock' => $this->stock
            ]);
            Cable::create([
                'material_id' => $this->material->id,
                'size' => $this->size,
                'minimum_section' => $this->minimum_section,
                'maximum_section' => $this->maximum_section,
            ]);
        }else{
            $this->material=Material::create([
                'code' => $this->code,
                'name' => $this->name,
                'family' => $this->family,
                'color' => $this->color,
                'description' => $this->description,
                'line_id'=>$this->line,
                'usage_id'=>$this->usage,
                'replace_id'=>$this->replace,
                'stock_min'=>$this->stock_min,
                'stock_max'=>$this->stock_max,
                'stock' => $this->stock
            ]);
            Seal::create([
                'material_id' => $this->material->id,
            ]);
        }
    
        $this->funcion="";
    }
    
    public function update(Material $material)
    { 
        $this->idu=$material->id;
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
        $this->usage=$material->usage->id;
        $this->line=$material->line->id;
        $this->usage_id=$material->usage;
        $this->line_id=$material->line;
        $this->info_line=Line::all();
        $this->info_usage=Usage::all();
        $this->info_term=Terminal::all();
        $this->info_sell=Seal::all();
        $this->info_con=Connector::all();

        if($this->family == 'Conectores'){
            $this->conn = Connector::where('material_id',$material->id)->first();
            $this->conn_id=$this->conn->id;
            $this->number_of_ways=$this->conn->number_of_ways;
            $this->type=$this->conn->type;
            $this->terminal_id=$this->conn->terminal_id;
            $this->seal_id=$this->conn->seal_id;
            $this->connector_id=$this->conn->connector_id;
        
        if($this->conn !=null){
            $this->termi = Terminal::where('id',$this->terminal_id)->first();
            $this->seli = Seal::where('id',$this->seal_id)->first();
            $this->connect = Connector::where('id',$this->connector_id)->first();
        }   
           

        }elseif($this->family == 'Terminales'){
            $this->term = Terminal::where('material_id',$material->id)->first();
            $this->term_id=$this->term->id;
            $this->size=$this->term->size;
            $this->minimum_section=$this->term->minimum_section;
            $this->maximum_section=$this->term->maximum_section;
        }elseif($this->family == 'Cables'){
            $this->cab = Cable::where('material_id',$material->id)->first();
            $this->size=$this->cab->size;
            $this->minimum_section=$this->cab->minimum_section;
            $this->maximum_section=$this->cab->maximum_section;
        }else{
            $this->sl = Seal::where('material_id',$material->id)->first();
            $this->seal_id=$this->sl->id;
        }
        
        $this->funcion="actualizar";
        $this->explora="inactivo";
    }

    public function editar(){
        $this->validate([
            'code.required' => 'El campo código es requerido',
            'name.required' => 'El campo nombre es requerido',
            'family.required' => 'El campo familia es requerido',
            'color.required' => 'El campo color es requerido',
            'description.max' => 'El campo descripción no debe superar 500 carácteres',
            'line.required' => 'Seleccione una opción para el campo de línea',
            'usage.required' => 'Seleccione una opción para el campo de uso',
            'stock_min.required' => 'El campo stock mínimo es requerido',
            'stock_min.numeric' => 'El campo stock mínimo es numérico',
            'stock_max.numeric' => 'El campo stock máximo es numérico',
            'stock.required' => 'El campo stock es requerido',
            'stock.numeric' => 'El campo stock es numérico',
        ], [
            'name.required' => 'El campo nombre es requerido',
            'name.string' => 'El campo nombre no debe tener números ni carácteres',
            'address.required' => 'El campo dirección es requerido',
            'email.required' => 'El campo correo electrónico para ventas es requerido',
            'email.unique' => 'El email correo electrónico para ventas ya se encuentra registrado',
            'email.email' => 'El campo correo electrónico para ventas debe ser un email',
            'phone.numeric' => 'El campo teléfono debe ser numérico',
            'contact_name' => 'El campo nombre de contacto no debe tener números ni carácteres',
            'site_url.url' => 'El campo página web no es válido',
        ]);

        $material_up =Material::find($this->idu);
        $material_up->name=$this->name;
        $material_up->code=$this->code;
        $material_up->family=$this->family;
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
                'number_of_ways.digits' => 'El campo cantidad de vías debe ser de menor o igual a dos cifras',
                'number_of_ways.required' => 'El campo cantidad de vías es requerido',
                'type.required' => 'El campo tipo es requerido',
            ]);
            $connector_up =Connector::find($this->conn_id);
            if($connector_up == null){
                Connector::create([
                    'material_id' => $this->idu,
                    'terminal_id' => $this->terminal,
                    'seal_id' => $this->seal,
                    'number_of_ways' => $this->number_of_ways,
                    'type' => $this->type,
                    'connector_id' => $this->connector,
                ]);
            }else{
            $connector_up->material_id=$this->idu;
            $connector_up->terminal_id=$this->terminal;
            $connector_up->seal_id=$this->seal;
            $connector_up->number_of_ways=$this->number_of_ways;
            $connector_up->type=$this->type;
            $connector_up->connector_id=$this->connector;
            $connector_up->save();
            }
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
            $terminal_up =Terminal::find($this->term_id);
            if($terminal_up == null){
                Terminal::create([
                    'material_id' => $this->idu,
                    'size' => $this->size,
                    'minimum_section' => $this->minimum_section,
                    'maximum_section' => $this->maximum_section,
                ]);
            }else{
            $terminal_up->material_id=$this->idu;
            $terminal_up->size=$this->size;
            $terminal_up->minimum_section=$this->minimum_section;
            $terminal_up->maximum_section=$this->maximum_section;
            $terminal_up->save();
            }
            
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
            $cable_up =Cable::find($this->term_id);
            if($cable_up == null){
                Cable::create([
                    'material_id' => $this->idu,
                    'size' => $this->size,
                    'minimum_section' => $this->minimum_section,
                    'maximum_section' => $this->maximum_section,
                ]);
            }else{
            $cable_up->material_id=$this->idu;
            $cable_up->size=$this->size;
            $cable_up->minimum_section=$this->minimum_section;
            $cable_up->maximum_section=$this->maximum_section;
            $cable_up->save();
            }

        }else{
            $seal_up =Seal::find($this->seal_id);
            if($seal_up == null){
                Seal::create([
                    'material_id' => $this->idu,
                ]);
            }else{
            $seal_up->material_id=$this->idu;
            $seal_up->save();
            }
            
        }
        $material_up->color=$this->color;
        $material_up->description=$this->description;
        $material_up->replace_id=$this->replace;
        $material_up->line_id=$this->line;
        $material_up->usage_id=$this->usage;
        $material_up->stock_min=$this->stock_min;
        $material_up->stock_max=$this->stock_max;
        $material_up->stock=$this->stock;

        $material_up->save();
        $this->funcion="";
    }

    public function back(){
        $this->funcion="";
        $this->explora='inactivo';  
    }

    public function explorar(Material $material_id){
        $this->material_id=$material_id;
        $this->material=Material::where('id', $this->material_id->id)->first();
        $this->provider_prices=ProviderPrice::where('material_id', $this->material->id)->get();
        #$this->prices=Price::where('provider_id', $this->provider->id)->get();
        
        if($this->explora=='inactivo'){
            $this->explora='activo';
            $this->funcion=" ";
        }
    }

    public function con(){
        $this->div=$this->family;
        #dd($this->div);
        $this->material_family=Material::where('family','LIKE','%'.$this->div.'%')->get();
        
   }

   public function destruir(Material $material)
   {
       if (auth()->user()->cannot('delete', auth()->user())) {
           abort(403);
       }else
       {
           if($material->family == 'Conectores'){
            $this->conn_del = Connector::where('material_id',$material->id)->first();
            $this->conn_del->delete();

           }elseif($material->family == 'Terminales'){
            $this->term_del = Terminal::where('material_id',$material->id)->first();
            $this->term_del->delete();
           }elseif($material->family == 'Cables'){
            $this->cable_del = Cable::where('material_id',$material->id)->first();
            $this->cable_del->delete();
           }else{
            $this->seal_del = Seal::where('material_id',$material->id)->first();
            $this->seal_del->delete();
           }
           $material->delete();
           $this->funcion="";
           $this->explora="inactivo";
       }
   }
}
