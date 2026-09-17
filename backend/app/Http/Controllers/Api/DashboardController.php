<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reparation;
use App\Models\Technicien;
use App\Models\Vehicule;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    /**
     * Indicateurs de synthèse pour le tableau de bord.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'total_vehicules' => Vehicule::count(),
            'total_reparations' => Reparation::count(),
            'total_techniciens' => Technicien::count(),
            'reparations_mois' => Reparation::whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->count(),
            'duree_moyenne' => (function () {
                $moyenne = Reparation::avg('duree_main_oeuvre');

                return $moyenne === null ? null : round((float) $moyenne, 2);
            })(),
            'energies' => Vehicule::select('energie')
                ->selectRaw('count(*) as total')
                ->groupBy('energie')
                ->pluck('total', 'energie'),
            'dernieres_reparations' => Reparation::with(['vehicule', 'techniciens'])
                ->orderByDesc('date')
                ->limit(5)
                ->get(),
        ]);
    }
}