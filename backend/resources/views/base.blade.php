<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titre', 'Mini Garage') &mdash; Garage de réparation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f5f6f8; }
        .navbar-brand { font-weight: 700; }
        .carte-vehicule .card-body h5 { color: #0b6e4f; font-weight: 700; }
        .badge-marque { background: #0b6e4f; }
        footer { color: #888; font-size: .85rem; }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom">
        <div class="container">
            <a class="navbar-brand" href="{{ route('vehicules.index') }}">&#128663; Mini Garage</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navGarage" aria-controls="navGarage" aria-expanded="false" aria-label="Basculer la navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navGarage">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('vehicules.*') ? 'active' : '' }}" href="{{ route('vehicules.index') }}">Véhicules</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('reparations.*') ? 'active' : '' }}" href="{{ route('reparations.index') }}">Réparations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('techniciens.*') ? 'active' : '' }}" href="{{ route('techniciens.index') }}">Techniciens</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-4 flex-grow-1">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif
        @yield('contenu')
    </main>

    <footer class="text-center py-3 border-top">
        Mini Garage &mdash; Projet Laravel (Semaine 4) &middot; Persistance des données et intégration des vues
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>