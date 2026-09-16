<div class="carte-vehicule">
    <div class="card shadow-sm h-100">
        <div class="card-body d-flex flex-column">
            <div class="d-flex justify-content-between align-items-start">
                <h5 class="card-title">{{ $vehicule->marque }} {{ $vehicule->modele }}</h5>
                <span class="badge badge-marque text-white">{{ $vehicule->annee }}</span>
            </div>
            <p class="text-muted small mb-1">
                <strong>{{ $vehicule->immatriculation }}</strong>
            </p>
            <ul class="list-unstyled small mb-3">
                <li>Couleur : {{ $vehicule->couleur ?? '—' }}</li>
                <li>Kilométrage : {{ number_format($vehicule->kilometrage, 0, ',', ' ') }} km</li>
                <li>Énergie : {{ ucfirst($vehicule->energie) }} &middot; Boîte {{ $vehicule->boite }}</li>
                <li>Carrosserie : {{ $vehicule->carrosserie ?? '—' }}</li>
            </ul>
            <div class="mt-auto">
                <span class="badge bg-secondary">{{ $vehicule->reparations_count }} réparation(s)</span>
                <a href="{{ route('vehicules.show', $vehicule) }}" class="btn btn-sm btn-outline-success float-end">Voir la fiche</a>
            </div>
        </div>
    </div>
</div>