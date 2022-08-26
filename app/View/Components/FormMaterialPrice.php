<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormMaterialPrice extends Component
{
    public $searchmaterials, $materials, $addMaterial, $materialSelected;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($searchmaterials, $materials, $addMaterial, $materialSelected)
    {
        $this->searchmaterials = $searchmaterials;
        $this->materials = $materials;
        $this->addMaterial = $addMaterial;
        $this->materialSelected = $materialSelected;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form-material-price');
    }
}
