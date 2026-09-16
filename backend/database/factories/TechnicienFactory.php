<?php

namespace Database\Factories;

use App\Models\Technicien;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Technicien>
 */
class TechnicienFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $specialites = [
            'Mécanique générale',
            'Carrosserie',
            'Électronique automobile',
            'Climatisation',
            'Moteur diesel',
            'Systèmes de freinage',
            'Boîte de vitesses',
            'Diagnostic informatique',
        ];

        return [
            'nom' => $this->faker->lastName(),
            'prenom' => $this->faker->firstName(),
            'specialite' => $this->faker->randomElement($specialites),
        ];
    }
}