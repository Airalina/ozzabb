<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormSelectDeposited extends Component
{
    public $type, $searchType, $products, $productsSelected, $process, $warehouseSelected;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $searchType, $products, $productsSelected, $process = '', $warehouseSelected = null)
    {
        $this->type = $type;
        $this->searchType = $searchType;
        $this->products = $products;
        $this->productsSelected = $productsSelected;
        $this->process = $process; 
        $this->warehouseSelected = $warehouseSelected; 
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form-select-deposited');
    }
}
