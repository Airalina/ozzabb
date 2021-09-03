<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Installation;
use App\Models\Material;
use App\Models\Revision;
use App\Models\Revisiondetail;

class Instalaciones extends Component
{
    public $instalaciones, $instalacion, $installation_id, $code, $description, $descripcion, $date_admission, $usd_price, $searchinstallation="", $revisiones, $revision, $material, $materiall, $materiales, $mat=array(), $searchrevision="", $searchmateriales="", $funcion="";
    public $details=array(), $detail=array(), $detailslist, $count=0, $reason, $date, $amount, $newdetail, $number_version, $material_id, $detail_id, $upca=false;
    public function render()
    {
        $this->materiales = Material::where('code','like','%'.$this->searchmateriales.'%')
            ->orWhere('name','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('family','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('color','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('description','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('line_id','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('usage_id','LIKE','%'.$this->searchmateriales.'%')
            //->orWhere('replace','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('stock_min','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('stock_max','LIKE','%'.$this->searchmateriales.'%')
            ->orWhere('stock','LIKE','%'.$this->searchmateriales.'%')->get();
        $this->instalaciones=Installation::where('id','LIKE','%' .$this->searchinstallation. '%')
            ->orWhere('code','LIKE','%'.$this->searchinstallation.'%')
            ->orWhere('description','LIKE','%'.$this->searchinstallation.'%')->get();
        $this->revisiones=Revision::where('installation_id', $this->installation_id)->get();
        return view('livewire.instalaciones');
    }

    public function store()
    {
        if($this->funcion=="create"){
            $this->validate([
                'code'=>'required|integer|min:1',
                'description'=>'required|string|min:5|max:300',
                'date_admission'=>'required|date',
                'usd_price'=>'required|numeric|min:1'
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
            $this->number_version=count(Revision::where('installation_id', $this->installation_id)->get());
            $this->revision=new Revision;
            $this->revision->installation_id=$this->installation_id;
            $this->revision->number_version=$this->number_version;
            $this->revision->create_date=$this->date;
            $this->revision->reason=$this->reason;
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

    public function update(Installation $instalacion)
    {
        $this->instalacion=Installation::find($instalacion->id);
        $this->installation_id=$instalacion->id;
        $this->code=$instalacion->code;
        $this->description=$instalacion->description;
        $this->date_admission=$instalacion->date_admission;
        $this->usd_price=$instalacion->usd_price;
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
            'amount.required'=>'El campo cantidad es requerido. Valor máximo 1000000'
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

    public function addmaterial(Material $material)
    {
        $this->validate([
            'amount'=>'required|integer|min:1|max:1000000'
        ], [
            'amount.required'=>'El campo cantidad es requerido. Valor máximo 1000000'
        ]);
        foreach($this->details as $detail){
            if($detail[0]==$material->code){
                $this->downmaterial($detail[3]);
            }        
        }
        $this->detail[0]=$material->code;
        $this->detail[1]=$material->description;
        $this->detail[2]=$this->amount;
        $this->detail[3]=$this->count;
        $this->detail[4]=$material->id;
        $this->details[]=$this->detail;
        $this->count=$this->count+1;
        $this->amount=0;
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
        $this->funcion="explora";
        $this->update($instalacion);

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
        $this->detailslist=Revisiondetail::where('number_version', $this->number_version)->where('installation_id', $this->installation_id)->get();
        foreach($this->detailslist as $det){
            $this->mat[$det->material_id]=Material::find($det->material_id);
        }
        $this->funcion="listadodetail";
    }

    public function newrevision()
    {
        $this->funcion="newrevision";
    }

    public function volver()
    {
        return redirect()->to('instalaciones');
    }

    public function cancelarupdetail(){
        $this->upca=false;
    }
    
    public function cancelar(){
        $this->details=null;
        $this->amount=null;
        $this->searchmateriales="";
        $this->funcion="explora";
    }

}
