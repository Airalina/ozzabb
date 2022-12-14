<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ListPricesCard extends Component
{
    public $type, $providerPrices, $permission, $arPrice;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $providerPrices, $permission, $arPrice)
    {
        $this->type = $type;
        $this->providerPrices = $providerPrices;
        $this->permission = $permission;
        $this->arPrice = $arPrice;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.list-prices-card');
    }
}
