<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SelectionListRevisions extends Component
{
    public $searchRevisions, $revisions, $revisionSelected, $showSelection;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($searchRevisions = '', $revisions = [], $revisionSelected, $showSelection = false)
    {
        $this->searchRevisions = $searchRevisions;
        $this->revisions = $revisions;
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
        return view('components.selection-list-revisions');
    }
}
