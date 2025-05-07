<?php

namespace App\Livewire;

use Livewire\Component;

class CarGallery extends Component
{
    public $car;
    public $activeImage;

    public function mount($car)
    {
        $this->car = $car;
        $this->activeImage = $car->carImages->isNotEmpty() ? $car->carImages->first()->image_path : null;
    }

    public function selectImage($imagePath)
    {
        $this->activeImage = $imagePath;
    }

    public function render()
    {
        return view('livewire.car-gallery');
    }
} 