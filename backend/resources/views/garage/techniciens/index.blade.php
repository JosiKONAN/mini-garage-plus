@extends('base')

@section('titre', 'Techniciens')

@section('contenu')
<h1 class="h3 mb-3">Techniciens du garage</h1>

<form method="GET" action="{{ route('techniciens.index') }}" class="row g-2 mb-3">
    <div class="col-md-8">
        <input type="search" name="q" value="{{ old('q', $recherche ?? '') }}" class="form-control"
               placeholder="Rechercher par nom, prénom ou spécialité...">
    </div>
    <div class="col-md-4 d-grid">
        <button type="submit" class="btn btn-dark">🔍 Rechercher</button>
    </div>
</form>

@if ($techniciens->isEmpty())
    <div class="alert alert-info">Aucun technicien trouvé.</div>
@else
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Spécialité</th>
                        <th class="text-center">Réparations</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($techniciens as $technicien)
                    <tr>
                        <td><strong>{{ $technicien->nom }}</strong></td>
                        <td>{{ $technicien->prenom }}</td>
                        <td><span class="badge bg-info text-dark">{{ $technicien->specialite }}</span></td>
                        <td class="text-center">{{ $technicien->reparations_count }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">
        {{ $techniciens->withQueryString()->links() }}
    </div>
@endif
@endsection