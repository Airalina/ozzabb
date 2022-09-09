<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SelectionListCustomers extends Component
{
    public $searchCustomers, $customers, $customerSelected, $showSelection;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($searchCustomers, $customers, $customerSelected, $showSelection)
    {
        $this->searchCustomers = $searchCustomers;
        $this->customers = $customers;
        $this->customerSelected = $customerSelected;
        $this->showSelection = empty($showSelection) ?: false;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.selection-list-customers');
    }
}
