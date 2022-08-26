<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ListHistoryPricesCard extends Component
{
    public $prices;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($prices)
    {
        $this->prices = $prices;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.list-history-prices-card');
    }
}
