<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Material;
use Livewire\WithPagination;


class MaterialComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $materials;

    public $search;

    public function render()
    {
        $this->materials = Material::where('code','like','%'.$this->search.'%')
            ->orWhere('name','LIKE','%'.$this->search.'%')
            ->orWhere('family','LIKE','%'.$this->search.'%')
            ->orWhere('color','LIKE','%'.$this->search.'%')
            ->orWhere('description','LIKE','%'.$this->search.'%')
            ->orWhere('line_id','LIKE','%'.$this->search.'%')
            ->orWhere('usage_id','LIKE','%'.$this->search.'%')
            ->orWhere('replace','LIKE','%'.$this->search.'%')
            ->orWhere('stock_min','LIKE','%'.$this->search.'%')
            ->orWhere('stock_max','LIKE','%'.$this->search.'%')
            ->orWhere('stock','LIKE','%'.$this->search.'%');

        return view('livewire.material-component', [
            "materials" => $this->materials->paginate(20),
        ]);
    }
}
