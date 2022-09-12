<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SelectionListInstallations extends Component
{
    public $searchInstallations, $installations, $installationsSelected;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($searchInstallations = '', $installations = [], $installationsSelected)
    {
        $this->searchInstallations = $searchInstallations;
        $this->installations = $installations;
        $this->installationsSelected = $installationsSelected;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.selection-list-installations');
    }
}
