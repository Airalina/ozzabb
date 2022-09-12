<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ListCustomerAddress extends Component
{
    public $addresses, $addressSelected;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($addresses = [], $addressSelected)
    {
        $this->addresses = $addresses;
        $this->addressSelected = $addressSelected;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.list-customer-address');
    }
}
