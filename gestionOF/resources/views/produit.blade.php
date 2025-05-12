<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Produits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('menuPrincipal') <!-- Inclure le menu principal -->
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif


    <div class="container mt-4">
        <h1 class="mb-4">Gestion des Produits</h1>

        <!-- Formulaire d'ajout de produit -->
        <div class="card mb-4">
            <div class="card-header">
                Ajouter un Produit
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('produit.store') }}">
                    @csrf
                    <!-- Nom du produit -->
                    @include('messageErreur')
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom du Produit</label>
                        <input type="text" class="form-control" id="nom" name="nom" placeholder="Entrez le nom du produit" required>
                    </div>

                    <!-- Quantité du produit -->
                    <div class="mb-3">
                        <label for="quantite" class="form-label">Quantité du Produit</label>
                        <input type="number" class="form-control" id="quantite" name="quantite" step="0.01" min="1" required>
                    </div>


                    <!-- Bouton de soumission -->
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>

        <!-- Liste des produits -->
        <div class="card">
            <div class="card-header">
                Liste des Produits
            </div>
            <div class="card-body">
                @if($produits->isEmpty())
                    <div class="alert alert-info">Aucun produit disponible.</div>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Quantité</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($produits as $produit)
                                <tr>
                                    <td>{{ $produit->nom }}</td>
                                    <td>{{ $produit->quantite }}</td>
                                 
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
