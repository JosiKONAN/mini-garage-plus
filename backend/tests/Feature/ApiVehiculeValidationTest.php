<?php

namespace Tests\Feature;

use App\Models\Vehicule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiVehiculeValidationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * La validation refuse une création sans les champs obligatoires (422).
     */
    public function test_store_rejects_missing_required_fields(): void
    {
        $response = $this->postJson('/api/vehicules', [
            'marque' => '',            // requis
            'modele' => '',            // requis
            'immatriculation' => '',   // requis
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['marque', 'modele', 'immatriculation']);
    }

    /**
     * Une création valide retourne 201 et la ressource est en base (ID 1).
     */
    public function test_store_creates_vehicle_with_valid_data(): void
    {
        $response = $this->postJson('/api/vehicules', [
            'marque'          => 'Renault',
            'modele'          => 'Clio V',
            'immatriculation' => 'RR-888-TT',
            'annee'           => 2022,
            'kilometrage'     => 12400,
            'energie'         => 'electrique',
            'boite'           => 'manuelle',
        ]);

        $response->assertStatus(201);
        $response->assertJsonPath('marque', 'Renault');
        $response->assertJsonPath('immatriculation', 'RR-888-TT');

        $this->assertDatabaseHas('vehicules', ['immatriculation' => 'RR-888-TT']);
    }
}