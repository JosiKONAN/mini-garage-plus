<?php

use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ReparationController;
use App\Http\Controllers\Api\TechnicienController;
use App\Http\Controllers\Api\VehiculeController;
use Illuminate\Support\Facades\Route;

// API REST du garage (routes générées par apiResource)
Route::apiResource('vehicules', VehiculeController::class)->names('api.vehicules');
Route::apiResource('reparations', ReparationController::class)->names('api.reparations');
Route::apiResource('techniciens', TechnicienController::class)->names('api.techniciens');

// Tableau de bord (KPI)
Route::get('stats', [DashboardController::class, 'index'])->name('api.stats');