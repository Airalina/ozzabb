<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormCreateProvider extends Component
{
    public $modal, $rowClass, $columnClass, $disabled;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($modal = false, $rowClass = "", $columnClass = "", $disabled = "")
    {
        $this->modal = $modal;
        $this->rowClass = $rowClass;
        $this->columnClass = $columnClass;
        $this->disabled = $disabled;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form-create-provider');
    }
}
