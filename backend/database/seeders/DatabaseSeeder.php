<?php

namespace Database\Seeders;

use App\Models\Reparation;
use App\Models\Technicien;
use App\Models\Vehicule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Génération des véhicules
        $vehicules = Vehicule::factory()->count(20)->create();

        // Génération des techniciens
        $techniciens = Technicien::factory()->count(10)->create();

        // Génération des réparations rattachées aux véhicules existants,
        // chacune réalisée par 1 à 3 techniciens (relation plusieurs-à-plusieurs).
        Reparation::factory()
            ->count(40)
            ->create(['vehicule_id' => fn () => $vehicules->random()->id])
            ->each(function (Reparation $reparation) use ($techniciens) {
                $reparation->techniciens()->attach(
                    $techniciens->random(rand(1, 3))->pluck('id')->all()
                );
            });
    }
}