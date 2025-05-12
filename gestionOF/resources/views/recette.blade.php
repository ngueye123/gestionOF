<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Recettes</title>
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
        <h1 class="mb-4">Gestion des Recettes</h1>

        <!-- Formulaire d'ajout de recette -->
        <div class="card mb-4">
            <div class="card-header">
                Ajouter une Recette
            </div>
            <div class="card-body">
                <form action="{{ route('recette.store') }}" method="POST">
                    @csrf
                    @include('messageErreur')
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom de la Recette</label>
                        <input type="text" id="nom" name="nom" class="form-control" placeholder="Entrez le nom de la recette" required>
                    </div>
                   
                    <!-- choix des produits -->
                    <div class="mb-4">
                        <label class="form-label">Produits associés</label>
                        <div id="produits-container">
                            <div class="produit-entry row mb-2">
                                <div class="col-md-8">
                                    <select class="form-control" name="produits[0][idProduit]" required>
                                        <option value="" disabled selected>Choisissez un produit</option>
                                        @foreach($produits as $produit)
                                            <option value="{{ $produit->idProduit }}">{{ $produit->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" class="form-control" name="produits[0][quantite]" placeholder="Quantité" step="0.01" min="1" required>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="button" class="btn btn-success btn-sm" onclick="addProduit()">+ Ajouter un produit</button>
                        </div>

                       
                    </div>


                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>

        <!-- Liste des recettes -->
        <div class="card">
            <div class="card-header">
                Liste des Recettes
            </div>
            <div class="card-body">
                @if($recettes->isEmpty())
                    <div class="alert alert-info">Aucune recette disponible.</div>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Produits associées</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recettes as $recette)
                                <tr>
                                    <td>{{ $recette->nom }}</td>
                                    <td>
                                        @if($recette->produits->isEmpty())
                                            Aucun produit associée
                                        @else
                                            @foreach($recette->produits as $produit)
                                                {{ $produit->nom }} (Quantité : {{ $produit->pivot->quantite }})<br>
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>


    <script>
    let produitIndex = 1;

function addProduit() {
    const container = document.getElementById('produits-container');
    const newEntry = document.createElement('div');
    newEntry.classList.add('produit-entry', 'row', 'mb-2');
    newEntry.innerHTML = `
        <div class="col-md-8">
            <select class="form-control" name="produits[${produitIndex}][idProduit]" required>
                <option value="" disabled selected>Choisissez un produit</option>
                @foreach($produits as $produit)
                    <option value="{{ $produit->idProduit }}">{{ $produit->nom }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input type="number" class="form-control" name="produits[${produitIndex}][quantite]" placeholder="Quantité" step="0.01" min="1" required>
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-danger btn-sm remove-produit" onclick="removeProduit(this)">−</button>
        </div>
    `;
    container.appendChild(newEntry);
    produitIndex++;
}

function removeProduit(button) {
    const entry = button.closest('.produit-entry');
    const container = document.getElementById('produits-container');
    const allEntries = container.querySelectorAll('.produit-entry');

    // Ne permet pas de supprimer la première entrée si elle est la seule
    if (allEntries.length > 1) {
        entry.remove();
    } else {
        alert("Vous devez avoir au moins un produit sélectionné.");
    }
}

// Assurez-vous que le premier élément ne puisse pas être supprimé
document.addEventListener("DOMContentLoaded", () => {
    const container = document.getElementById('produits-container');
    const firstEntry = container.querySelector('.produit-entry');

    if (firstEntry) {
        const removeButton = firstEntry.querySelector('.remove-produit');
        if (removeButton) {
            removeButton.remove(); // Supprime le bouton "moins" du premier produit
        }
    }
});

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
