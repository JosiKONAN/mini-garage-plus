<?php

namespace Tests\Feature;

use App\Models\Vehicule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageVehiculesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Vérifie que la page liste les véhicules (200, HTML, contient immatriculation).
     */
    public function test_returns_200_with_vehicules_listing(): void
    {
        Vehicule::factory()->create([
            'immatriculation' => 'TEST-123-AB',
            'marque'          => 'Peugeot',
        ]);

        $response = $this->get('/vehicules');

        $response->assertStatus(200);
        $response->assertViewHas('vehicules');
        $response->assertSee('Véhicules du garage');
        $response->assertSee('TEST-123-AB');
        $response->assertSee('Peugeot');
    }
}
