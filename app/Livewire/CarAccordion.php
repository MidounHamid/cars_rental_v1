<?php

namespace App\Livewire;

use Livewire\Component;

class CarAccordion extends Component
{
    public $car;
    public $openSection = null;

    public function mount($car)
    {
        $this->car = $car;
    }

    public function toggleSection($section)
    {
        $this->openSection = $this->openSection === $section ? null : $section;
    }

    public function render()
    {
        return view('livewire.car-accordion');
    }
} 