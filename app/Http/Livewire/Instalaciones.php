<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Installation;
use App\Models\Material;
use App\Models\Revision;
use App\Models\Revisiondetail;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Instalaciones extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $instalaciones;
    protected $paginationTheme = 'bootstrap';
    public $instalacion, $installation_id, $code, $codem, $paginas=25, $description, $descriptionm, $descripcion, $date_admission, $usd_price, $searchinstallation="", $revisiones, $revision, $revisiond, $material, $materiall, $materiales, $mat=array(), $searchrevision="", $searchmateriales="", $funcion="";
    public $details=array(), $detail=array(), $nombrefile, $seeimg=false, $detailslist, $photo=null, $count=0, $reason, $date, $amount, $newdetail, $number_version, $material_id, $detail_id, $upca=false;
    public function render()
    {
        $this->materiales = Material::where('code','like','%'.$this->searchmateriales.'%')
            ->orWhere('name','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('family','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('color','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('description','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('line','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('usage','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('stock_min','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('stock_max','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('stock','LIKE','%'.$this->searchmateriales.'%')->get();
        $this->instalaciones=Installation::where('id','LIKE','%' .$this->searchinstallation. '%')
            ->orWhere('code','LIKE','%'.$this->searchinstallation.'%')
            ->orWhere('description','LIKE','%'.$this->searchinstallation.'%')->paginate($this->paginas);
        $this->revisiones=Revision::where('installation_id', $this->installation_id)->get();
        return view('livewire.instalaciones',[
            'instalaciones' => $this->instalaciones,
        ]);
    }

    public function store()
    {
       
        if($this->funcion=="create"){
            $this->validate([
                'code'=>'required|integer|min:1|max:100000000',
                'description'=>'required|string|min:5|max:300',
                'date_admission'=>'required|date',
                'usd_price'=>'required|numeric|min:0|max:1000000',
            ],[
                'date_admission.required' => 'El campo Fecha es requerido',
                'code.required' => 'El campo Código es requerido',
                'code.integer' => 'El camppo Código debe ser un número entero',
                'code.min' => 'El campo Código debe ser igual o mayor a 1(uno)',
                'code.max' => 'El campo Código debe ser menor o igual a 10000000(diez millones)',
                'description.required' => 'El campo Descripción es requerido',
                'description.min' => 'El campo Descripción tiene al menos 5 caracteres',
                'description.max' => 'El campo Descripción tiene como máximo 300 caracteres',
                'date_admission.requred' => 'El campo Fecha es requerido',
                'usd_price.required' => 'El campo Precio U$D es requerido',
                'usd_price.numeric' => 'El campo Precio U$D es numérico',
                'usd_price.max' => 'El campo precio U$D tiene como maximo 1000000(un millon)',
    
            ]);
            $this->instalacion= new Installation;
            $this->instalacion->code=$this->code;
            $this->instalacion->description=$this->description;
            $this->instalacion->date_admission=$this->date_admission;
            $this->instalacion->usd_price=$this->usd_price;
            $this->instalacion->save();
            $this->revision=new Revision;
            $this->revision->installation_id=$this->instalacion->id;
            $this->revision->number_version=0;
            $this->revision->create_date=$this->date_admission;
            if($this->photo!=null){
                $this->nombrefile=$this->photo->getClientOriginalName();
                $this->photo->storeAs('images',$this->nombrefile);
                $this->revision->image=$this->nombrefile;
            }
            $this->revision->reason="Modelo base";
            $this->revision->save();
            foreach($this->details as $detail)
            {
                $this->newdetail=new Revisiondetail;
                $this->newdetail->installation_id=$this->instalacion->id;
                $this->newdetail->number_version=$this->revision->number_version;
                $this->newdetail->material_id=$detail[4];
                $this->newdetail->amount=$detail[2];
                $this->newdetail->save(); 
            }
            $this->volver();
        }
        if($this->funcion=="newrevision"){
            $this->validate([
                'date'=>'required|date',
                'reason'=>'required|string|min:5|max:300'
            ],[
                'date.required' => 'El campo Fecha es requerido',
                'reason.required' => 'El campo Razón es requerido',
                'reason.min' => 'El campo Razón tiene como mínimo 5 caracteres',
                'reason.max' => 'El campo Razón tiene como maximo 300 caracteres',
            ]);
            $this->number_version=count(Revision::where('installation_id', $this->installation_id)->get());
            $this->revision=new Revision;
            $this->revision->installation_id=$this->installation_id;
            $this->revision->number_version=$this->number_version;
            $this->revision->create_date=$this->date;
            $this->revision->reason=$this->reason;
            $this->revision->image=$this->photo;
            $this->revision->save();
            foreach($this->details as $detail)
            {
                $this->newdetail=new Revisiondetail;
                $this->newdetail->installation_id=$this->instalacion->id;
                $this->newdetail->number_version=$this->revision->number_version;
                $this->newdetail->material_id=$detail[4];
                $this->newdetail->amount=$detail[2];
                $this->newdetail->save(); 
            }
            $this->searchmateriales="";
            $this->explora($this->revision->installations->find($this->revision->installation_id));
        }
        if($this->funcion=="exploradetail"){

            foreach($this->details as $detail)
            {
                $this->newdetail=new Revisiondetail;
                $this->newdetail->installation_id=$this->installation_id;
                $this->newdetail->number_version=$this->number_version;
                $this->newdetail->material_id=$detail[4];
                $this->newdetail->amount=$detail[2];
                $this->newdetail->save(); 
            }
            $this->cancelar();
        }
    }

    public function updateinstallation(Installation $instalacion)
    {   
        $this->funcion="update";
        $this->instalacion=Installation::find($instalacion->id);
        $this->installation_id=$instalacion->id;
        $this->code=$instalacion->code;
        $this->description=$instalacion->description;
        $this->date_admission=$instalacion->date_admission;
        $this->usd_price=$instalacion->usd_price;
    }
    public function update(Installation $instalacion)
    {   
        $this->instalacion=Installation::find($instalacion->id);
        $this->installation_id=$instalacion->id;
        $this->code=$instalacion->code;
        $this->description=$instalacion->description;
        $this->date_admission=$instalacion->date_admission;
        $this->usd_price=$instalacion->usd_price;
    }
    
    public function edit(){
        $this->validate([
            'code'=>'required|integer|min:1|max:100000000',
            'description'=>'required|string|min:5|max:300',
            'usd_price'=>'required|numeric|min:0|max:1000000',
        ],[
            'code.required' => 'El campo Código es requerido',
            'code.integer' => 'El camppo Código debe ser un número entero',
            'code.min' => 'El campo Código debe ser igual o mayor a 1(uno)',
            'code.max' => 'El campo Código debe ser menor o igual a 10000000(diez millones)',
            'description.required' => 'El campo Descripción es requerido',
            'description.min' => 'El campo Descripción tiene al menos 5 caracteres',
            'description.max' => 'El campo Descripción tiene como máximo 300 caracteres',
            'date_admission.requred' => 'El campo Fecha es requerido',
            'usd_price.required' => 'El campo Precio U$D es requerido',
            'usd_price.numeric' => 'El campo Precio U$D es numérico',
            'usd_price.max' => 'El campo precio U$D tiene como maximo 1000000(un millon)',

        ]);
        $this->instalacion=Installation::find($this->installation_id);
        $this->instalacion->code=$this->code;
        $this->instalacion->description=$this->description;
        $this->instalacion->usd_price=$this->usd_price;
        $this->instalacion->save();
        $this->volver();
    }

    public function updatecantidad(Revisiondetail $det){

        $this->detail=Revisiondetail::find($det->id);
        $this->material=$this->mat[$this->detail->material_id];
        $this->code=$this->material['code'];
        $this->descripcion=$this->material['description'];
        $this->amount=$this->detail->amount;
        $this->upca=true;
    }

    public function editdetail(){
        $this->validate([
            'amount'=>'required|integer|min:1|max:1000000'
        ], [
            'amount.required'=>'El campo Cantidad es requerido',
            'amount.integer' => 'El campo Cantidad tiene que ser un número entero',
            'amount.min' => 'El campo Cantidad es como mínimo 1(uno)',
            'amount.max' => 'El campo Cantidad es como máximo 1000000(un millon)',
        ]);
        $this->detail->amount=$this->amount;
        $this->detail->save();
        $this->exploradetail($this->detail->number_version);
        $this->upca=false;
    }

    public function delete(Installation $instalacion)
    {
        $instalacion->delete();
    }

    public function borrarevision(Revision $revi)
    {
        $details=Revisiondetail::where('number_version', $revi->number_version)->where('installation_id', $revi->installation_id)->get();
        foreach($details as $det)
        {
            $det->delete();
        }
        $revi->delete(); 
    }

    public function borradetail(Revisiondetail $detail)
    {
        $detail->delete();
        $this->exploradetail($this->number_version);
    }

    public function addmaterial()
    {
        $this->validate([
           'amount'=>'required|integer|min:1|max:1000000'
        ], [
            'amount.required'=>'El campo Cantidad es requerido',
            'amount.integer' => 'El campo Cantidad tiene que ser un número entero',
            'amount.min' => 'El campo Cantidad es como mínimo 1(uno)',
            'amount.max' => 'El campo Cantidad es como máximo 1000000(un millon)',
        ]);
        foreach($this->details as $detail){
            if($detail[0]==$this->codem){
                $this->downmaterial($detail[3]);
            }        
        }
        $this->detail[0]=$this->codem;
        $this->detail[1]=$this->descriptionm;
        $this->detail[2]=$this->amount;
        $this->detail[3]=$this->count;
        $this->detail[4]=$this->material_id;
        $this->details[]=$this->detail;
        $this->count=$this->count+1;
        $this->amount=0;
        $this->dispatchBrowserEvent('hide-form');
    }
    public function selectmaterial(Material $material)
    {
        $this->material_id=$material->id;
        $this->descriptionm=$material->description;;
        $this->codem=$material->code;
        $this->dispatchBrowserEvent('show-form');
        $this->searchmateriales="";
    }
    public function newrevision()
    {
        $this->count=0;
        $this->funcion="newrevision";
        $this->number_version=(count(Revision::where('installation_id', $this->installation_id)->get())-1);
        $this->revision=Revision::where('installation_id', $this->installation_id)->get()->last();
        $this->photo=$this->revision->image;
        $this->revisiond=Revisiondetail::where('installation_id',$this->installation_id)->where('number_version', $this->number_version)->get();
        foreach($this->revisiond as $revisiondetail){
            $this->amount=$revisiondetail->amount;
            $this->material_id=$revisiondetail->material_id;
            $this->codem=$revisiondetail->materials->find( $revisiondetail->material_id)->code;
            $this->descriptionm=$revisiondetail->materials->find( $revisiondetail->material_id)->description;
            $this->addmaterial();
                }
    }
    public function downmaterial($orden)
    {
        unset($this->details[$orden]);
    }

    public function create()
    {
        $this->funcion="create";
    }

    public function explora(Installation $instalacion)
    {
        $this->details=null;
        $this->funcion="explora";
        $this->update($instalacion);
        $this->resetValidation();
    }

    public function exploradetail(int $revision)
    {
        $this->number_version=$revision;
        $this->detailslist=Revisiondetail::where('number_version', $this->number_version)->where('installation_id', $this->installation_id)->get();
        foreach($this->detailslist as $det){
            $this->mat[$det->material_id]=Material::find($det->material_id);
        }
        $this->funcion="exploradetail";
    }

    public function seedetail(int $revision){
        $this->number_version=$revision;
        $this->revision=Revision::where('number_version', $this->number_version)->where('installation_id', $this->installation_id)->get();
        foreach($this->revision as $rev){
            $this->photo=$rev->image;
        }
        $this->detailslist=Revisiondetail::where('number_version', $this->number_version)->where('installation_id', $this->installation_id)->get();
        foreach($this->detailslist as $det){
            $this->mat[$det->material_id]=Material::find($det->material_id);
        }
        $this->funcion="listadodetail";
    }

    public function volver()
    {
        return redirect()->to('instalaciones');
    }

    public function cancelarupdetail(){
        $this->upca=false;
    }

    public function verimagen(){
        $this->seeimg=true;
    }
    
    public function noverimagen(){
        $this->seeimg=false;
    }

    public function cancelar(){
        $this->details=null;
        $this->amount=null;
        $this->searchmateriales="";
        $this->funcion="explora";
    }

}
