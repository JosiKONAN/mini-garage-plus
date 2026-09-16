@extends('base')

@section('titre', 'Réparations')

@section('contenu')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Réparations</h1>
    <a href="{{ route('reparations.create') }}" class="btn btn-success">+ Nouvelle réparation</a>
</div>

<form method="GET" action="{{ route('reparations.index') }}" class="row g-2 mb-3">
    <div class="col-md-8">
        <input type="search" name="q" value="{{ old('q', $recherche ?? '') }}" class="form-control"
               placeholder="Rechercher par objet de réparation ou immatriculation...">
    </div>
    <div class="col-md-4 d-grid">
        <button type="submit" class="btn btn-dark">🔍 Rechercher</button>
    </div>
</form>

@if ($reparations->isEmpty())
    <div class="alert alert-info">Aucune réparation trouvée.</div>
@else
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Véhicule</th>
                        <th>Objet de la réparation</th>
                        <th>Durée (h)</th>
                        <th>Techniciens</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reparations as $reparation)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($reparation->date)->format('d/m/Y') }}</td>
                        <td>
                            <strong>{{ $reparation->vehicule->marque }} {{ $reparation->vehicule->modele }}</strong><br>
                            <small class="text-muted">{{ $reparation->vehicule->immatriculation }}</small>
                        </td>
                        <td>{{ $reparation->objet_reparation }}</td>
                        <td>{{ $reparation->duree_main_oeuvre }}</td>
                        <td>
                            @if ($reparation->techniciens->isEmpty())
                                <em class="text-muted">—</em>
                            @else
                                @foreach ($reparation->techniciens as $technicien)
                                    <span class="badge bg-info text-dark">{{ $technicien->prenom }} {{ $technicien->nom }}</span>
                                @endforeach
                            @endif
                        </td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('reparations.show', $reparation) }}" class="btn btn-sm btn-outline-success">Voir</a>
                            <a href="{{ route('reparations.edit', $reparation) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
                            <form action="{{ route('reparations.destroy', $reparation) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Supprimer cette réparation ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">
        {{ $reparations->withQueryString()->links() }}
    </div>
@endif
@endsection