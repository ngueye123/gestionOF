<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Basculer la navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <!-- Lien Accueil -->
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('accueil') ? 'active' : '' }}" href="{{ route('accueil') }}">Accueil</a>
                    </li>
                    <!-- Lien OF -->
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('of') ? 'active' : '' }}" href="{{ route('of') }}">OF</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('programme') ? 'active' : '' }}" href="{{ route('programme') }}">Programme</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('controle') ? 'active' : '' }}" href="{{ route('controle') }}">Control process</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('livraison') ? 'active' : '' }}" href="{{ route('livraison') }}">Fiche livraison</a>
                    </li>

                    <!-- Lien Inventaire -->
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('inventaire') ? 'active' : '' }}" href="{{ route('inventaire') }}">Inventaire</a>
                    </li>
                </ul>
            </div>
            <form action="{{ route('deconnexion') }}" method="GET" class="d-flex ms-auto">
                @csrf
                <button type="submit" class="btn btn-danger">Déconnexion</button>
            </form>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
