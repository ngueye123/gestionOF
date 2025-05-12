<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
@if(session()->has('connexion'))
        @php
            $compte = \App\Models\Personnel::where('email', session()->get('connexion'))->first();
        @endphp

        @if($compte)
            @if($compte->role === 'Superviseur')
                @include('menuPrincipal')
            @elseif($compte->role === 'Technicien')
                @include('menuTechnicien')
            @else
                <p class="text-danger">Rôle inconnu.</p>
            @endif
        @else
            <p class="text-danger">Utilisateur non trouvé.</p>
        @endif
    @endif
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <div class="container mt-4">
        
        <form method="POST" action="{{ route('inventaire.soumettre') }}">
            @csrf

            <h2>Produits</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Quantité</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produits as $produit)
                        <tr class="produit-row" data-id="{{ $produit->idProduit }}">
                            <td>{{ $produit->nom }}</td>
                            <td>
                                <span class="display-quantite">{{ $produit->quantite }}</span>
                                <input type="number" class="form-control input-quantite" 
                                    name="modifications[produit][{{ $produit->idProduit }}][nouvelle_quantite]" 
                                    value="{{ old('modifications.produit.' . $produit->idProduit . '.nouvelle_quantite', $produit->quantite) }}" 
                                    hidden readonly  required>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary btn-modifier">Modifier</button>
                                <input type="hidden" name="modifications[produit][{{ $produit->idProduit }}][idProduit]" 
                                    value="{{ $produit->idProduit }}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="submit" class="btn btn-success">Soumettre</button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.btn-modifier').forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const inputField = row.querySelector('.input-quantite');
                    const displayField = row.querySelector('.display-quantite');
                    const isEditing = this.getAttribute('data-editing') === 'true';

                    if (isEditing) {
                        // Sauvegarder la valeur et revenir en mode affichage
                        displayField.textContent = inputField.value;
                        inputField.hidden = true;
                        inputField.readOnly = true; // Utiliser readOnly au lieu de disabled
                        displayField.style.display = "inline";
                        this.textContent = "Modifier";
                        this.setAttribute('data-editing', 'false');
                    } else {
                        // Passer en mode édition
                        inputField.hidden = false;
                        inputField.readOnly = false; // Désactiver readOnly pour permettre la modification
                        displayField.style.display = "none";
                        this.textContent = "Sauvegarder";
                        this.setAttribute('data-editing', 'true');
                    }
                });
            });

            // Pas besoin d'activer les champs avant la soumission, car ils sont déjà inclus avec readOnly
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
