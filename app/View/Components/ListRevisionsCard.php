<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ListRevisionsCard extends Component
{
    public $revisions, $showActions;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($revisions, $showActions = true)
    {
        $this->revisions = $revisions;
        $this->showActions = $showActions;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.list-revisions-card');
    }
}
