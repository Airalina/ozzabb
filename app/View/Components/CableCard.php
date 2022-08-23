<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CableCard extends Component
{
    public $content, $explorar;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($materialContent, $explorar)
    {
        $this->content = $materialContent;
        $this->explorar = $explorar;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.cable-card');
    }
}
