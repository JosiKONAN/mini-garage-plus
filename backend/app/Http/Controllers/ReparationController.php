<?php

namespace App\Http\Controllers;

use App\Models\Reparation;
use App\Models\Technicien;
use App\Models\Vehicule;
use Illuminate\Http\Request;

class ReparationController extends Controller
{
    /**
     * Liste des réparations avec relations chargées (eviter les accès inutiles).
     */
    public function index(Request $request)
    {
        $query = Reparation::with(['vehicule', 'techniciens']);

        // Recherche par immatriculation ou objet de réparation
        if ($recherche = $request->query('q')) {
            $query->where('objet_reparation', 'like', "%{$recherche}%")
                ->orWhereHas('vehicule', function ($q) use ($recherche) {
                    $q->where('immatriculation', 'like', "%{$recherche}%");
                });
        }

        $reparations = $query->latest('date')->paginate(10);

        return view('garage.reparations.index', compact('reparations', 'recherche'));
    }

    /**
     * Formulaire de création (sélection du véhicule + techniciens).
     */
    public function create()
    {
        $vehicules = Vehicule::orderBy('marque')->get();
        $techniciens = Technicien::orderBy('specialite')->get();

        return view('garage.reparations.create', compact('vehicules', 'techniciens'));
    }

    /**
     * Enregistrement d'une réparation + liaison des techniciens (attach).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'date' => 'required|date',
            'duree_main_oeuvre' => 'required|numeric|min:0|max:999.99',
            'objet_reparation' => 'required|string|max:255',
            'techniciens' => 'nullable|array',
            'techniciens.*' => 'exists:techniciens,id|distinct',
        ]);

        $reparation = Reparation::create($data);

        // Liaison plusieurs-à-plusieurs
        if (!empty($data['techniciens'])) {
            $reparation->techniciens()->attach(array_unique($data['techniciens']));
        }

        return redirect()
            ->route('reparations.show', $reparation)
            ->with('success', 'Réparation enregistrée.');
    }

    /**
     * Détail d'une réparation (model binding).
     */
    public function show(Reparation $reparation)
    {
        $reparation->load(['vehicule', 'techniciens']);

        return view('garage.reparations.show', compact('reparation'));
    }

    /**
     * Formulaire de modification d'une réparation.
     */
    public function edit(Reparation $reparation)
    {
        $vehicules = Vehicule::orderBy('marque')->get();
        $techniciens = Technicien::orderBy('specialite')->get();

        return view('garage.reparations.edit', compact('reparation', 'vehicules', 'techniciens'));
    }

    /**
     * Mise à jour d'une réparation + synchronisation des techniciens (sync).
     */
    public function update(Request $request, Reparation $reparation)
    {
        $data = $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'date' => 'required|date',
            'duree_main_oeuvre' => 'required|numeric|min:0|max:999.99',
            'objet_reparation' => 'required|string|max:255',
            'techniciens' => 'nullable|array',
            'techniciens.*' => 'exists:techniciens,id|distinct',
        ]);

        $reparation->update($data);

        // Synchronisation complète de la table pivot
        $reparation->techniciens()->sync(array_values(array_unique($data['techniciens'] ?? [])));

        return redirect()
            ->route('reparations.show', $reparation)
            ->with('success', 'Réparation modifiée.');
    }

    /**
     * Suppression d'une réparation.
     */
    public function destroy(Reparation $reparation)
    {
        $reparation->delete();

        return redirect()
            ->route('reparations.index')
            ->with('success', 'Réparation supprimée.');
    }
}