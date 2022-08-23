<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ImgUpdateCard extends Component
{
    public $images, $materials;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($images, $materials)
    {
        $this->images = $images;
        $this->materials = $materials;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.img-update-card');
    }
}
