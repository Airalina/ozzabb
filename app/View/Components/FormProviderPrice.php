<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormProviderPrice extends Component
{
    public $searchproviders, $providers, $addprovider, $providerselected;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($searchproviders, $providers, $addprovider, $providerselected)
    {
        $this->searchproviders = $searchproviders;
        $this->providers = $providers;
        $this->addprovider = $addprovider;
        $this->providerselected = $providerselected;
        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form-provider-price');
    }
}
