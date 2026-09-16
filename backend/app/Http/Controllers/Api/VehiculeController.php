<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class VehiculeController extends Controller
{
    /**
     * Afficher la liste des véhicules avec recherche et pagination.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Vehicule::query();

        if ($q = $request->query('q')) {
            $query->where(function ($builder) use ($q) {
                $builder->where('immatriculation', 'like', "%{$q}%")
                    ->orWhere('marque', 'like', "%{$q}%")
                    ->orWhere('modele', 'like', "%{$q}%");
            });
        }

        $perPage = min((int) $request->query('per_page', 9), 50);
        $vehicules = $query->orderByDesc('created_at')->paginate($perPage);

        return response()->json($vehicules);
    }

    /**
     * Enregistrer un véhicule (Eloquent create()).
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'immatriculation' => 'required|string|max:20|unique:vehicules',
            'marque' => 'required|string|max:50',
            'modele' => 'required|string|max:50',
            'couleur' => 'nullable|string|max:30',
            'annee' => 'required|integer|between:1950,2026',
            'kilometrage' => 'nullable|integer|min:0',
            'carrosserie' => 'nullable|string|max:30',
            'energie' => 'required|in:essence,diesel,hybride,electrique',
            'boite' => 'required|in:manuelle,automatique',
        ]);

        $vehicule = Vehicule::create($data);

        return response()->json($vehicule, 201);
    }

    /**
     * Afficher un véhicule avec ses réparations (Eloquent find()).
     */
    public function show(string $id): JsonResponse
    {
        $vehicule = Vehicule::with('reparations')->find($id);

        if (!$vehicule) {
            return response()->json(['message' => 'Véhicule introuvable.'], 404);
        }

        return response()->json($vehicule);
    }

    /**
     * Mettre à jour un véhicule (Eloquent update()).
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $vehicule = Vehicule::find($id);

        if (!$vehicule) {
            return response()->json(['message' => 'Véhicule introuvable.'], 404);
        }

        $data = $request->validate([
            'immatriculation' => 'sometimes|string|max:20|unique:vehicules,immatriculation,' . $vehicule->id,
            'marque' => 'sometimes|string|max:50',
            'modele' => 'sometimes|string|max:50',
            'couleur' => 'nullable|string|max:30',
            'annee' => 'sometimes|integer|between:1950,2026',
            'kilometrage' => 'nullable|integer|min:0',
            'carrosserie' => 'nullable|string|max:30',
            'energie' => 'sometimes|in:essence,diesel,hybride,electrique',
            'boite' => 'sometimes|in:manuelle,automatique',
        ]);

        $vehicule->update($data);

        return response()->json($vehicule);
    }

    /**
     * Supprimer un véhicule (Eloquent delete()).
     */
    public function destroy(string $id): JsonResponse
    {
        $vehicule = Vehicule::find($id);

        if (!$vehicule) {
            return response()->json(['message' => 'Véhicule introuvable.'], 404);
        }

        $vehicule->delete();

        return response()->json(['message' => 'Véhicule supprimé.'], 200);
    }
}