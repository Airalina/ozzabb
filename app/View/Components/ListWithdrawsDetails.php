<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ListWithdrawsDetails extends Component
{
    public $withdraws, $detail, $type;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($withdraws, $detail = true, $type = false)
    {
        $this->withdraws = $withdraws;
        $this->detail = $detail;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.list-withdraws-details');
    }
}
