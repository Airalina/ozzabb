<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormCreateWarehouse extends Component
{
    public $types, $showOptions, $disabled;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($types, $showOptions, $disabled = '')
    {
        $this->types = $types;
        $this->showOptions = $showOptions;
        $this->disabled = $disabled;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form-create-warehouse');
    }
}
