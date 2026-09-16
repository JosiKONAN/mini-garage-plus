<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Technicien;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TechnicienController extends Controller
{
    /**
     * Afficher la liste des techniciens (Eloquent all()).
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'count' => Technicien::count(),
            'data' => Technicien::all(),
        ]);
    }

    /**
     * Enregistrer un technicien (Eloquent create()).
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nom' => 'required|string|max:60',
            'prenom' => 'required|string|max:60',
            'specialite' => 'required|string|max:80',
        ]);

        $technicien = Technicien::create($data);

        return response()->json($technicien, 201);
    }

    /**
     * Afficher un technicien avec ses réparations (Eloquent find()).
     */
    public function show(string $id): JsonResponse
    {
        $technicien = Technicien::with('reparations')
            ->where('id', $id)
            ->first();

        if (!$technicien) {
            return response()->json(['message' => 'Technicien introuvable.'], 404);
        }

        return response()->json($technicien);
    }

    /**
     * Mettre à jour un technicien (Eloquent update()).
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $technicien = Technicien::find($id);

        if (!$technicien) {
            return response()->json(['message' => 'Technicien introuvable.'], 404);
        }

        $data = $request->validate([
            'nom' => 'sometimes|string|max:60',
            'prenom' => 'sometimes|string|max:60',
            'specialite' => 'sometimes|string|max:80',
        ]);

        $technicien->update($data);

        return response()->json($technicien);
    }

    /**
     * Supprimer un technicien (Eloquent delete()).
     */
    public function destroy(string $id): JsonResponse
    {
        $technicien = Technicien::find($id);

        if (!$technicien) {
            return response()->json(['message' => 'Technicien introuvable.'], 404);
        }

        $technicien->delete();

        return response()->json(['message' => 'Technicien supprimé.'], 200);
    }
}