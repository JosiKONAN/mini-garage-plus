@extends('base')

@section('titre', 'Nouvelle réparation')

@section('contenu')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Nouvelle réparation</h1>
    <a href="{{ route('reparations.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Retour</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $erreur)
                        <li>{{ $erreur }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('reparations.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" for="vehicule_id">Véhicule concerné *</label>
                    <select name="vehicule_id" id="vehicule_id" class="form-select" required>
                        <option value="">— Choisir un véhicule —</option>
                        @foreach ($vehicules as $vehicule)
                            <option value="{{ $vehicule->id }}" @selected(old('vehicule_id') == $vehicule->id)>
                                {{ $vehicule->marque }} {{ $vehicule->modele }} ({{ $vehicule->immatriculation }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="date">Date *</label>
                    <input type="date" name="date" id="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="duree_main_oeuvre">Durée main d'œuvre (h) *</label>
                    <input type="number" step="0.5" min="0" name="duree_main_oeuvre" id="duree_main_oeuvre"
                           class="form-control" value="{{ old('duree_main_oeuvre', '1.0') }}" required>
                </div>
            </div>

            <div class="mt-3">
                <label class="form-label" for="objet_reparation">Objet de la réparation *</label>
                <input type="text" name="objet_reparation" id="objet_reparation" class="form-control"
                       value="{{ old('objet_reparation') }}" placeholder="Ex. : remplacement des plaquettes de frein" required>
            </div>

            <div class="mt-3">
                <label class="form-label d-block">Techniciens intervenants (choix multiple)</label>
                @if ($techniciens->isEmpty())
                    <div class="alert alert-warning mb-0">Aucun technicien enregistré. Ajoutez d'abord des techniciens.</div>
                @else
                    <div class="row">
                        @foreach ($techniciens as $technicien)
                            <div class="col-md-4 col-lg-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="techniciens[]"
                                           value="{{ $technicien->id }}" id="tech_{{ $technicien->id }}"
                                           @checked(in_array($technicien->id, (array) old('techniciens', [])))>
                                    <label class="form-check-label" for="tech_{{ $technicien->id }}">
                                        {{ $technicien->prenom }} {{ $technicien->nom }}
                                        <small class="text-muted d-block">{{ $technicien->specialite }}</small>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success">Enregistrer la réparation</button>
                <a href="{{ route('reparations.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection