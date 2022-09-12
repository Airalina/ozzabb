<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ModalSelectInstallation extends Component
{
    public $installation, $searchRevisions, $revisions, $revisionSelected, $showSelection;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($installation = [], $revisions = [], $revisionSelected = [], $searchRevisions = '', $showSelection)
    {
        $this->installation = $installation;
        $this->revisions = $revisions;
        $this->searchRevisions = $searchRevisions;
        $this->revisionSelected = $revisionSelected;
        $this->showSelection = $showSelection;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal-select-installation');
    }
}
