<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use Illuminate\Http\Request;

class VehiculeController extends Controller
{
    /**
     * Liste des véhicules avec recherche par marque ou immatriculation.
     */
    public function index(Request $request)
    {
        $query = Vehicule::query();

        // Recherche : filtre sur la marque OU l'immatriculation
        if ($recherche = $request->query('q')) {
            $query->where(function ($q) use ($recherche) {
                $q->where('marque', 'like', "%{$recherche}%")
                    ->orWhere('immatriculation', 'like', "%{$recherche}%")
                    ->orWhere('modele', 'like', "%{$recherche}%");
            });
        }

        $vehicules = $query->withCount('reparations')->paginate(9);

        return view('garage.vehicules.index', compact('vehicules', 'recherche'));
    }

    /**
     * Fiche d'un véhicule utilisant le model binding ({vehicule}).
     */
    public function show(Vehicule $vehicule)
    {
        $vehicule->load('reparations.techniciens');

        return view('garage.vehicules.show', compact('vehicule'));
    }
}