<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ReplaceCard extends Component
{
    public $replaces, $explorar;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($replaces, $explorar)
    {
        $this->replaces = $replaces;
        $this->explorar = $explorar;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.replace-card');
    }
}
