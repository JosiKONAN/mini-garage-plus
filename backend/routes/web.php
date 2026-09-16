<?php

use App\Http\Controllers\ReparationController;
use App\Http\Controllers\TechnicienController;
use App\Http\Controllers\VehiculeController;
use Illuminate\Support\Facades\Route;

// Accueil : redirection vers le catalogue des véhicules
Route::get('/', fn () => redirect()->route('vehicules.index'));

// Véhicules (index avec recherche + show avec model binding)
Route::resource('vehicules', VehiculeController::class)->only(['index', 'show']);

// Réparations : CRUD complet (create/edit avec sélection multiple des techniciens)
Route::resource('reparations', ReparationController::class);

// Techniciens
Route::get('techniciens', [TechnicienController::class, 'index'])->name('techniciens.index');