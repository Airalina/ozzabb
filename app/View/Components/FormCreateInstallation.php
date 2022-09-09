<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormCreateInstallation extends Component
{
    public $disabled, $showfields, $customersData;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($disabled = '', $showfields = true, $customersData = [])
    {
        $this->disabled = $disabled;
        $this->showfields = $showfields;
        $this->customersData = $customersData;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form-create-installation');
    }
}
