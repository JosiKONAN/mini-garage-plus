<?php

namespace Database\Factories;

use App\Models\Reparation;
use App\Models\Vehicule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Reparation>
 */
class ReparationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $objets = [
            'Vidange et changement de filtre à huile',
            'Révision générale (freins, plaquettes)',
            'Diagnostic électronique et reprogrammation',
            'Remplacement des pneus avant',
            'Changement des plaquettes et disques de frein',
            'Réparation de la boîte de vitesses',
            'Remplacement de la batterie',
            'Contrôle de la climatisation',
            'Remplacement de l\'embrayage',
            'Entretien moteur et courroie de distribution',
        ];

        return [
            'vehicule_id' => Vehicule::factory(),
            'date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'duree_main_oeuvre' => $this->faker->randomElement([0.5, 1, 1.5, 2, 2.5, 3, 4, 5]),
            'objet_reparation' => $this->faker->randomElement($objets),
        ];
    }
}