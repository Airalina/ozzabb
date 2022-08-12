<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ImgUpdateCard extends Component
{
    public $images, $material; 
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($images = [], $material)
    {
        $this->images = $images;
        $this->material = $material;
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
