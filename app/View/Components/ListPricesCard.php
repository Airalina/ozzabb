<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ListPricesCard extends Component
{
    public $type, $item, $providerPrices, $permission;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $item, $providerPrices, $permission)
    {
        $this->type = $type;
        $this->item = $item;
        $this->providerPrices = $providerPrices;
        $this->permission = $permission;
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
