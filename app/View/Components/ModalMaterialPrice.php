<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ModalMaterialPrice extends Component
{
    public $familySelected, $materialContent, $searchTerminal, $searchSeal, $information, $explorar;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($familySelected, $materialContent, $information, $searchTerminal, $searchSeal, $explorar = [])
    {
        $this->familySelected = $familySelected;
        $this->materialContent = $materialContent;
        $this->searchTerminal = $searchTerminal;
        $this->searchSeal = $searchSeal;
        $this->information = $information;
        $this->explorar['readonly'] = '';
        $this->explorar['disabled'] = '';
        $this->explorar['familyDisabled'] = '';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal-material-price');
    }
}
