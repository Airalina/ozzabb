<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormCreateMaterial extends Component
{
    public $familySelected, $materialContent, $searchTerminal, $searchSeal, $information, $explorar;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($familySelected, $materialContent, $information, $searchTerminal, $searchSeal, $explorar)
    {
        $this->familySelected = $familySelected;
        $this->materialContent = $materialContent;
        $this->searchTerminal = $searchTerminal;
        $this->searchSeal = $searchSeal;
        $this->information = $information;
        $this->explorar = $explorar;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form-create-material');
    }
}
