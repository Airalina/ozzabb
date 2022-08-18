<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ConnectorCard extends Component
{
    public $content, $searchTerminal, $searchSeal, $explorar;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($materialContent, $searchTerminal, $searchSeal, $explorar)
    {
        $this->content = $materialContent;
        $this->searchTerminal = $searchTerminal;
        $this->searchSeal = $searchSeal;
        $this->explorar = $explorar;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.connector-card');
    }
}
