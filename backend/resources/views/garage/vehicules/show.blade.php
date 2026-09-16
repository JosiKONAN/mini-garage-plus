@extends('base')

@section('titre', $vehicule->marque . ' ' . $vehicule->modele)

@section('contenu')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">{{ $vehicule->marque }} {{ $vehicule->modele }}</h1>
    <a href="{{ route('vehicules.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Retour</a>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title text-success">Informations techniques</h5>
                <table class="table table-sm table-borderless mb-0">
                    <tbody>
                        <tr><th class="text-muted">Immatriculation</th><td><strong>{{ $vehicule->immatriculation }}</strong></td></tr>
                        <tr><th class="text-muted">Année</th><td>{{ $vehicule->annee }}</td></tr>
                        <tr><th class="text-muted">Couleur</th><td>{{ $vehicule->couleur ?? '—' }}</td></tr>
                        <tr><th class="text-muted">Kilométrage</th><td>{{ number_format($vehicule->kilometrage, 0, ',', ' ') }} km</td></tr>
                        <tr><th class="text-muted">Carrosserie</th><td>{{ $vehicule->carrosserie ?? '—' }}</td></tr>
                        <tr><th class="text-muted">Énergie</th><td>{{ ucfirst($vehicule->energie) }}</td></tr>
                        <tr><th class="text-muted">Boîte</th><td>{{ ucfirst($vehicule->boite) }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <h5 class="mb-2 text-success">Historique des réparations
            <span class="badge bg-secondary">{{ $vehicule->reparations->count() }}</span>
        </h5>
        @if ($vehicule->reparations->isEmpty())
            <div class="alert alert-info">Aucune réparation enregistrée pour ce véhicule.</div>
        @else
            <div class="list-group shadow-sm">
                @foreach ($vehicule->reparations as $reparation)
                <div class="list-group-item">
                    <div class="d-flex justify-content-between">
                        <strong>{{ $reparation->objet_reparation }}</strong>
                        <span class="badge bg-success text-white">{{ \Carbon\Carbon::parse($reparation->date)->format('d/m/Y') }}</span>
                    </div>
                    <small class="text-muted d-block">Durée main d'œuvre : {{ $reparation->duree_main_oeuvre }} h</small>
                    <small class="text-muted">
                        Techniciens :
                        @forelse ($reparation->techniciens as $technicien)
                            <span class="badge bg-info text-dark">{{ $technicien->prenom }} {{ $technicien->nom }}</span>
                        @empty
                            <em>Aucun</em>
                        @endforelse
                    </small>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection