<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <!-- Intégration de Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Barre de navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <!-- Bouton pour la navigation mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Basculer la navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Contenu de la barre de navigation -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <!-- Lien Accueil -->
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('accueil') ? 'active' : '' }}" href="{{ route('accueil') }}">Accueil</a>
                    </li>

                    <!-- Menu déroulant pour Postes, Recette et Produit -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ Request::routeIs('poste', 'recette', 'produit') ? 'active' : '' }}" href="#" id="menuGestion" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Gestion
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="menuGestion">
                            <li>
                                <a class="dropdown-item {{ Request::routeIs('recette') ? 'active' : '' }}" href="{{ route('recette') }}">Recette</a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ Request::routeIs('produit') ? 'active' : '' }}" href="{{ route('produit') }}">Produit</a>
                            </li>

                            <li>
                                <a class="dropdown-item {{ Request::routeIs('formulaire') ? 'active' : '' }}" href="{{ route('formulaire') }}">Programme</a>
                            </li>
                        </ul>
                    </li>


                     <!-- Menu déroulant pour OF -->
                     <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ Request::routeIs('OF', 'Programme', 'Control process', 'Fiche livraison') ? 'active' : '' }}" href="#" id="menuGestion" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Gestion OF
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="menuGestionOF">
                            <li>
                                <a class="dropdown-item {{ Request::routeIs('of') ? 'active' : '' }}" href="{{ route('of') }}">OF</a>
                            </li>
                            

                            <li>
                                <a class="dropdown-item {{ Request::routeIs('controle') ? 'active' : '' }}" href="{{ route('controle') }}">Controle process</a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ Request::routeIs('livraison') ? 'active' : '' }}" href="{{ route('livraison') }}">Fiche Livraison</a>
                            </li>
                        </ul>
                    </li>

                    <!-- Lien Inventaire -->
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('inventaire') ? 'active' : '' }}" href="{{ route('inventaire') }}">Inventaire</a>
                    </li>

                    <!-- Lien Personnel -->
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('personnel') ? 'active' : '' }}" href="{{ route('personnel') }}">Personnel</a>
                    </li>

                    <!-- Lien Log -->
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('log') ? 'active' : '' }}" href="{{ route('log') }}">Logs</a>
                    </li>
                    
                </ul>
            </div>
            <!-- Formulaire de déconnexion aligné à droite -->
            <form action="{{ route('deconnexion') }}" method="GET" class="d-flex ms-auto">
                @csrf
                <button type="submit" class="btn btn-danger">Déconnexion</button>
            </form>
        </div>
    </nav>


</body>
</html>
