<?php

namespace App\View\Components;

use App\Models\Vehicule;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class VehiculeCard extends Component
{
    /**
     * Véhicule affiché dans la carte.
     */
    public Vehicule $vehicule;

    /**
     * Create a new component instance.
     */
    public function __construct(Vehicule $vehicule)
    {
        $this->vehicule = $vehicule;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.vehicule-card');
    }
}