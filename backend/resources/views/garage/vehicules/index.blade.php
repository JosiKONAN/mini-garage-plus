@extends('base')

@section('titre', 'Véhicules du garage')

@section('contenu')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Véhicules du garage</h1>
    <a href="{{ route('reparations.create') }}" class="btn btn-success">+ Nouvelle réparation</a>
</div>

<!-- Recherche par marque ou immatriculation -->
<form method="GET" action="{{ route('vehicules.index') }}" class="row g-2 mb-3">
    <div class="col-md-8">
        <input type="search" name="q" value="{{ old('q', $recherche ?? '') }}" class="form-control"
               placeholder="Rechercher par marque, modèle ou immatriculation...">
    </div>
    <div class="col-md-4 d-grid">
        <button type="submit" class="btn btn-dark">🔍 Rechercher</button>
    </div>
</form>

@if (!empty($recherche))
    <p class="text-muted">Résultats pour <strong>&laquo; {{ $recherche }} &raquo;</strong></p>
@endif

@if ($vehicules->isEmpty())
    <div class="alert alert-info">Aucun véhicule trouvé.</div>
@else
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
        @foreach ($vehicules as $vehicule)
            <div class="col">
                {{-- Composant Blade réutilisable --}}
                <x-vehicule-card :vehicule="$vehicule" />
            </div>
        @endforeach
    </div>

    <div class="mt-3">
        {{ $vehicules->withQueryString()->links() }}
    </div>
@endif
@endsection