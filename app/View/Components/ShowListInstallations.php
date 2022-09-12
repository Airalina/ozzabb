<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ShowListInstallations extends Component
{
    public $installationsSelected, $viewDetail;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($installationsSelected, $viewDetail = '')
    {
        $this->installationsSelected = $installationsSelected;
        $this->viewDetail = $viewDetail;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.show-list-installations');
    }
}
