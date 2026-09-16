<?php

namespace Tests\Feature;

use App\Models\Reparation;
use App\Models\Technicien;
use App\Models\Vehicule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiFunctionsS6Test extends TestCase
{
    use RefreshDatabase;

    /**
     * La lecture seule des techniciens renvoie la liste (v1).
     */
    public function test_techniciens_index_is_read_only(): void
    {
        Technicien::factory()->count(3)->create();

        $this->getJson('/api/techniciens')
            ->assertOk()
            ->assertJsonCount(3, 'data');
    }

    /**
     * Vérifie la pagination (9 éléments par défaut).
     */
    public function test_vehicules_index_is_paginated(): void
    {
        Vehicule::factory()->count(20)->create();

        $response = $this->getJson('/api/vehicules');

        $response->assertOk();
        $response->assertJsonPath('per_page', 9);
        $response->assertJsonPath('last_page', 3);
        $response->assertJsonPath('total', 20);
    }

    /**
     * Vérifie la recherche par immatriculation, marque ou modèle (?q=).
     */
    public function test_vehicules_search_by_query(): void
    {
        Vehicule::factory()->create([
            'immatriculation' => 'AA-123-BB',
            'marque'          => 'Peugeot',
            'modele'          => '208',
        ]);
        Vehicule::factory()->create([
            'immatriculation' => 'CC-456-DD',
            'marque'          => 'Renault',
            'modele'          => 'Clio',
        ]);

        $this->getJson('/api/vehicules?q=Peugeot')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.immatriculation', 'AA-123-BB');

        $this->getJson('/api/vehicules?q=CC-456-DD')
            ->assertOk()
            ->assertJsonCount(1, 'data');
    }

    /**
     * Le tableau de bord renvoie les indicateurs (stats KPI).
     */
    public function test_dashboard_stats(): void
    {
        $vehicules = Vehicule::factory()->count(2)->create();
        $techniciens = Technicien::factory()->count(2)->create();

        Reparation::factory()->count(3)->create(['vehicule_id' => $vehicules->first()->id])
            ->each(fn (Reparation $r) => $r->techniciens()->attach($techniciens->first()->id));

        $this->getJson('/api/stats')
            ->assertOk()
            ->assertJsonPath('total_vehicules', 2)
            ->assertJsonPath('total_techniciens', 2)
            ->assertJsonPath('total_reparations', 3);
    }
}