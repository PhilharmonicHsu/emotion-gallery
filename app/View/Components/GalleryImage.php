<?php

namespace App\View\Components;

use Illuminate\View\Component;

class GalleryImage extends Component
{
    public $src;
    public $alt;
    public $className;
    public $dataResultId;

    public function __construct($src, $alt, $className = '', $dataResultId = null)
    {
        $this->src = $src;
        $this->alt = $alt;
        $this->className = $className;
        $this->dataResultId = $dataResultId;
    }

    public function render()
    {
        return view('components.gallery-image');
    }
}
