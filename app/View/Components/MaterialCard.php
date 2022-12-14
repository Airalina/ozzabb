<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MaterialCard extends Component
{
    public $familySelected, $materialContent, $showReplace, $replaces, $searchTerminal, $searchSeal, $explorar;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($familySelected, $materialContent, $showReplace, $replaces, $searchTerminal, $searchSeal, $explorar)
    {   
        $this->familySelected = $familySelected;
        $this->materialContent = $materialContent;
        $this->showReplace = $showReplace;
        $this->replaces = $replaces;
        $this->searchTerminal = $searchTerminal;
        $this->searchSeal = $searchSeal;
        $this->explorar = $explorar;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.material-card');
    }
}
