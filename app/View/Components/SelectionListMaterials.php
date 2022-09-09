<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SelectionListMaterials extends Component
{
    public $searchMaterials, $materials, $materialsSelected;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($searchMaterials = '', $materials = [], $materialsSelected)
    {
        $this->searchMaterials = $searchMaterials;
        $this->materials = $materials;
        $this->materialsSelected = $materialsSelected;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.selection-list-materials');
    }
}
