<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MaterialCard extends Component
{
    public $div, $search, $terminales, $searchTerminal, $infoTerm, $infoSell,
        $connectorId, $connect, $searchs, $sellos, $infoCon, $materialFamily, $divTube, $showReplace;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $div = '',
        $search =  '',
        $terminales = [],
        $searchTerminal =  '',
        $infoTerm = '',
        $infoSell = '',
        $connectorId = '',
        $connect = '',
        $searchs = '',
        $sellos = [],
        $infoCon = '',
        $materialFamily = '',
        $divTube = '',
        $showReplace
    ) {
        $this->div = $div;
        $this->search = $search;
        $this->terminales = $terminales;
        $this->searchTerminal = $searchTerminal;
        $this->infoTerm = $infoTerm;
        $this->infoSell = $infoSell;
        $this->connectorId = $connectorId;
        $this->connect = $connect;
        $this->searchs = $searchs;
        $this->sellos = $sellos;
        $this->infoCon = $infoCon;
        $this->materialFamily = $materialFamily;
        $this->divTube = $divTube;
        $this->showReplace = $showReplace;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.material-card');
    }
}
