<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reparation;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ReparationController extends Controller
{
    /**
     * Afficher la liste des réparations avec relations et pagination.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min((int) $request->query('per_page', 9), 50);
        $reparations = Reparation::with(['vehicule', 'techniciens'])
            ->orderByDesc('date')
            ->paginate($perPage);

        return response()->json($reparations);
    }

    /**
     * Enregistrer une réparation et ses techniciens (Eloquent create() + attach()).
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'vehicule_id' => 'required|integer|exists:vehicules,id',
            'date' => 'required|date',
            'duree_main_oeuvre' => 'required|numeric|min:0',
            'objet_reparation' => 'required|string|max:255',
            'techniciens' => 'nullable|array',
            'techniciens.*' => 'integer|exists:techniciens,id',
        ]);

        $reparation = Reparation::create($data);

        if (!empty($data['techniciens'])) {
            $reparation->techniciens()->attach($data['techniciens']);
        }

        return response()->json($reparation->load('techniciens'), 201);
    }

    /**
     * Afficher une réparation avec ses relations (Eloquent find()).
     */
    public function show(string $id): JsonResponse
    {
        $reparation = Reparation::with(['vehicule', 'techniciens'])->find($id);

        if (!$reparation) {
            return response()->json(['message' => 'Réparation introuvable.'], 404);
        }

        return response()->json($reparation);
    }

    /**
     * Mettre à jour une réparation et ses techniciens (Eloquent update() + sync()).
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $reparation = Reparation::find($id);

        if (!$reparation) {
            return response()->json(['message' => 'Réparation introuvable.'], 404);
        }

        $data = $request->validate([
            'vehicule_id' => 'sometimes|integer|exists:vehicules,id',
            'date' => 'sometimes|date',
            'duree_main_oeuvre' => 'sometimes|numeric|min:0',
            'objet_reparation' => 'sometimes|string|max:255',
            'techniciens' => 'nullable|array',
            'techniciens.*' => 'integer|exists:techniciens,id',
        ]);

        $reparation->update($data);

        if ($request->has('techniciens')) {
            $reparation->techniciens()->sync($data['techniciens'] ?? []);
        }

        return response()->json($reparation->load('techniciens'));
    }

    /**
     * Supprimer une réparation (Eloquent delete()).
     */
    public function destroy(string $id): JsonResponse
    {
        $reparation = Reparation::find($id);

        if (!$reparation) {
            return response()->json(['message' => 'Réparation introuvable.'], 404);
        }

        $reparation->delete();

        return response()->json(['message' => 'Réparation supprimée.'], 200);
    }
}