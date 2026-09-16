@extends('base')

@section('titre', 'Réparation n°' . $reparation->id)

@section('contenu')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Réparation n°{{ $reparation->id }}</h1>
    <div>
        <a href="{{ route('reparations.edit', $reparation) }}" class="btn btn-primary btn-sm">Modifier</a>
        <a href="{{ route('reparations.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Retour</a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5 class="text-success">Véhicule</h5>
                <p class="mb-1"><strong>{{ $reparation->vehicule->marque }} {{ $reparation->vehicule->modele }}</strong></p>
                <p class="mb-1">Immatriculation : {{ $reparation->vehicule->immatriculation }}</p>
                <a href="{{ route('vehicules.show', $reparation->vehicule) }}" class="btn btn-sm btn-outline-success">Voir la fiche véhicule</a>
            </div>
            <div class="col-md-6">
                <h5 class="text-success">Intervention</h5>
                <p class="mb-1"><strong>{{ $reparation->objet_reparation }}</strong></p>
                <p class="mb-1">Date : {{ \Carbon\Carbon::parse($reparation->date)->format('d/m/Y') }}</p>
                <p class="mb-0">Durée main d'œuvre : <strong>{{ $reparation->duree_main_oeuvre }} h</strong></p>
            </div>
        </div>

        <hr>

        <h5 class="text-success">Techniciens affectés
            <span class="badge bg-secondary">{{ $reparation->techniciens->count() }}</span>
        </h5>
        @if ($reparation->techniciens->isEmpty())
            <div class="alert alert-warning mb-0">Aucun technicien affecté à cette réparation.</div>
        @else
            <div class="row">
                @foreach ($reparation->techniciens as $technicien)
                    <div class="col-md-4">
                        <div class="border rounded p-2 mb-2 bg-light">
                            <strong>{{ $technicien->prenom }} {{ $technicien->nom }}</strong><br>
                            <small class="text-muted">{{ $technicien->specialite }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<form action="{{ route('reparations.destroy', $reparation) }}" method="POST" class="mt-3"
      onsubmit="return confirm('Supprimer définitivement cette réparation ?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-outline-danger">Supprimer cette réparation</button>
</form>
@endsection