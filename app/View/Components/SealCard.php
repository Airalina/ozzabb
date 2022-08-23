<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SealCard extends Component
{
    public $explorar;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($explorar)
    {
        $this->explorar = $explorar;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.seal-card');
    }
}
