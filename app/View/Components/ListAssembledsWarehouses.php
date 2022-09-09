<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ListAssembledsWarehouses extends Component
{
    public $elements;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($elements)
    {
      $this->elements = $elements->all();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.list-assembleds-warehouses');
    }
}
