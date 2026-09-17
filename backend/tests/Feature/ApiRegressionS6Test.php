<?php

namespace Tests\Feature;

use App\Models\Reparation;
use App\Models\Technicien;
use App\Models\Vehicule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests de non-régression sur les failles détectées lors de l'audit S6.
 */
class ApiRegressionS6Test extends TestCase
{
    use RefreshDatabase;

    /**
     * C1/M(type) : per_page est borné entre 1 et 50 (évite les paginations absurdes).
     */
    public function test_per_page_is_bounded(): void
    {
        Vehicule::factory()->count(3)->create();

        $this->getJson('/api/vehicules?per_page=0')
            ->assertOk()
            ->assertJsonPath('per_page', 1);

        $this->getJson('/api/vehicules?per_page=-10')
            ->assertOk()
            ->assertJsonPath('per_page', 1);

        $this->getJson('/api/vehicules?per_page=9999')
            ->assertOk()
            ->assertJsonPath('per_page', 50);
    }

    /**
     * M2 : kilometrage null est accepté et normalisé à 0 (colonne NOT NULL).
     */
    public function test_vehicule_accepts_null_kilometrage(): void
    {
        $response = $this->postJson('/api/vehicules', [
            'marque'          => 'Dacia',
            'modele'          => 'Sandero',
            'immatriculation' => 'KM-000-AA',
            'annee'           => 2021,
            'kilometrage'     => null,
            'energie'         => 'essence',
            'boite'           => 'manuelle',
        ]);

        $response->assertStatus(201);
        $response->assertJsonPath('kilometrage', 0);
        $this->assertDatabaseHas('vehicules', [
            'immatriculation' => 'KM-000-AA',
            'kilometrage'     => 0,
        ]);
    }

    /**
     * M3 : duree_main_oeuvre au-delà de la colonne DECIMAL(5,2) est refusée (422).
     */
    public function test_reparation_rejects_duree_over_max(): void
    {
        $vehicule = Vehicule::factory()->create();

        $this->postJson('/api/reparations', [
            'vehicule_id'       => $vehicule->id,
            'date'              => '2026-09-10',
            'duree_main_oeuvre' => 1000,
            'objet_reparation'  => 'Réparation hors borne',
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['duree_main_oeuvre']);
    }

    /**
     * M1 : un même technicien ne peut pas être envoyé deux fois (règle distinct).
     */
    public function test_reparation_rejects_duplicate_techniciens(): void
    {
        $vehicule = Vehicule::factory()->create();
        $technicien = Technicien::factory()->create();

        $this->postJson('/api/reparations', [
            'vehicule_id'       => $vehicule->id,
            'date'              => '2026-09-10',
            'duree_main_oeuvre' => 2,
            'objet_reparation'  => 'Doublon technicien',
            'techniciens'       => [$technicien->id, $technicien->id],
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['techniciens.0']);
    }

    /**
     * M1 : la contrainte unique de la table pivot empêche les doublons en base.
     */
    public function test_pivot_rejects_duplicate_attachment(): void
    {
        $reparation = Reparation::factory()->create();
        $technicien = Technicien::factory()->create();

        $reparation->techniciens()->attach($technicien->id);

        $this->expectException(\Illuminate\Database\QueryException::class);

        $reparation->techniciens()->attach($technicien->id);
    }

    /**
     * Mineur : sans réparation, la durée moyenne vaut null (et non 0).
     */
    public function test_duree_moyenne_is_null_without_reparation(): void
    {
        $this->getJson('/api/stats')
            ->assertOk()
            ->assertJsonPath('duree_moyenne', null);
    }
}
