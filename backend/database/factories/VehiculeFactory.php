<?php

namespace Database\Factories;

use App\Models\Vehicule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vehicule>
 */
class VehiculeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $marques = [
            'Toyota' => ['Corolla', 'Hilux', 'RAV4', 'Yaris'],
            'Peugeot' => ['208', '3008', '508', 'Partner'],
            'Renault' => ['Clio', 'Megane', 'Kangoo', 'Duster'],
            'Kia' => ['Picanto', 'Rio', 'Sportage', 'Sorento'],
            'Mercedes-Benz' => ['Classe A', 'Classe C', 'Sprinter', 'GLA'],
            'Hyundai' => ['i10', 'Elantra', 'Tucson', 'Santa Fe'],
        ];
        $images = [
            'Toyota' => ['Corolla', 'Hilux', 'RAV4', 'Yaris'],
            'Peugeot' => ['208', '3008', '508', 'Partner'],
            'Renault' => ['Clio', 'Megane', 'Kangoo', 'Duster'],
            'Kia' => ['Picanto', 'Rio', 'Sportage', 'Sorento'],
            'Mercedes-Benz' => ['Classe A', 'Classe C', 'Sprinter', 'GLA'],
            'Hyundai' => ['i10', 'Elantra', 'Tucson', 'Santa Fe'],
        ];
        $marque = $this->faker->randomElement(array_keys($marques));
        $modele = $this->faker->randomElement($marques[$marque]);
        $imageSlug = strtolower(str_replace(['-', ' '], '_', $marque)) === 'mercedes_benz'
            ? 'mercedes'
            : strtolower(str_replace(['-', ' '], '_', $marque));
        $image = 'images/vehicules/' . $imageSlug . '_' . strtolower(str_replace(' ', '_', $modele)) . '.jpg';
        $couleurs = ['Blanc', 'Noir', 'Gris', 'Rouge', 'Bleu', 'Vert', 'Argent'];
        $carrosseries = ['Berline', 'SUV', 'Break', 'Monospace', 'Citadine', 'Pick-up', 'Utilitaire'];
        $energies = ['essence', 'diesel', 'hybride', 'electrique'];
        $boites = ['manuelle', 'automatique'];

        return [
            'immatriculation' => strtoupper($this->faker->randomLetter() . $this->faker->randomLetter())
                . '-' . $this->faker->numberBetween(100, 999)
                . '-' . strtoupper($this->faker->randomLetter() . $this->faker->randomLetter()),
            'marque' => $marque,
            'modele' => $modele,
            'couleur' => $this->faker->randomElement($couleurs),
            'annee' => $this->faker->numberBetween(2008, 2025),
            'kilometrage' => $this->faker->numberBetween(15000, 250000),
            'carrosserie' => $this->faker->randomElement($carrosseries),
            'energie' => $this->faker->randomElement($energies),
            'boite' => $this->faker->randomElement($boites),
            'image' => $image,
        ];
    }
}