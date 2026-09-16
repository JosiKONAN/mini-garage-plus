<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        // La racine redirige vers /vehicules (302)
        $this->get('/')->assertStatus(302);

        // La page d'index retourne 200 avec le contenu attendu
        $this->get('/vehicules')
            ->assertStatus(200)
            ->assertSee('Véhicules du garage');
    }
}
