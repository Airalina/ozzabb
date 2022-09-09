<?php

namespace App\Http\Livewire;

use App\Http\Traits\AssembledTrait;
use App\Models\Assembled;
use App\Models\Material;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Assembleds extends Component
{
    use AssembledTrait;

    public $searchMaterials = "", $materials = [], $materialsSelected = [], $material = [], $assembled, $component = '', $validation;

    public function render()
    {
        $this->materials = Material::search($this->searchMaterials)->groupBy('id')->get()->toArray();

        return view('livewire.assembleds');
    }

    public function selectMaterial($materialId)
    {
        $material = Material::findOrfail($materialId);

        if ($material) {
            $this->material  = [
                'id' => $material->id,
                'code' => $material->code,
                'description' => $material->description
            ];
            $this->dispatchBrowserEvent('show-form-material');
            $this->resetValidation();
            return $this->material;
        }
        return null;
    }

    public function addMaterial()
    {
        $validationProperties = $this->validationSelectMaterials();
        $this->validation = $this->validate($validationProperties['rules'], $validationProperties['messages']);

        $this->material['amount'] =  $this->validation['material']['amount'];
        $this->materialsSelected[$this->material['id']] = $this->material;

        $this->backModal();
        $this->dispatchBrowserEvent('hide-form-material');
    }

    public function downMaterial($materialId)
    {
        unset($this->materialsSelected[$materialId]);
        return;
    }

    public function store()
    {
        //validacion para ensamblados
        $validationProperties = $this->validationAssembleds();
        $this->validation = $this->validate($validationProperties['rules'], $validationProperties['messages']);
        try {
            DB::beginTransaction();
            //creando el deposito
            $assembled = Assembled::updateOrCreate($this->validation['assembled']);

            if (count($this->materialsSelected) > 0) {
                foreach ($this->materialsSelected as $material) {
                    $materialsArray['material'][$material['id']] = ['amount' =>  $material['amount']];
                }
                $assembled->materials()->sync($materialsArray['material']);
            }

            DB::commit();
            $this->resetValidation();

            if ($this->component == 'depositos') {
                return $this->emit('newAssembled', $assembled->id);
            }
            $this->reset();
            return $assembled;
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();

            if (count($assembled->materials) > 0) {
                $materialId = array_keys($this->materialsSelected);
                $assembled->materials()->detach($materialId);
            }
            if (isset($assembled)) {
                // en caso de error, borra ensamblado
                $assembled->delete();
            }
            return null;
        }
    }

    public function backModal()
    {
        $this->resetValidation();
        $this->reset('material');
    }

    public function back()
    {
        if ($this->component == 'depositos') {
            return $this->emit('backToEntry');
        }
        $this->reset();
        return $this->resetValidation();
    }
}
