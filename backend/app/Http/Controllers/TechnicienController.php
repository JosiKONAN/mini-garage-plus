<?php

namespace App\Http\Controllers;

use App\Models\Technicien;
use Illuminate\Http\Request;

class TechnicienController extends Controller
{
    /**
     * Liste des techniciens.
     */
    public function index(Request $request)
    {
        $query = Technicien::withCount('reparations');

        if ($recherche = $request->query('q')) {
            $query->where('nom', 'like', "%{$recherche}%")
                ->orWhere('prenom', 'like', "%{$recherche}%")
                ->orWhere('specialite', 'like', "%{$recherche}%");
        }

        $techniciens = $query->orderBy('nom')->paginate(10);

        return view('garage.techniciens.index', compact('techniciens', 'recherche'));
    }
}