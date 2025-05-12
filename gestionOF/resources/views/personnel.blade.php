<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Personnel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('menuPrincipal')
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="container mt-5">
        <h1 class="mb-4">Inscription Personnel</h1>

        {{-- Affichage des messages d'erreur --}}
        @include('messageErreur')

        {{-- Formulaire d'inscription --}}
        <form method="POST" action="{{ route('personnel.store') }}">
            @csrf

            <!-- Nom -->
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" placeholder="Entrez votre nom" required>
            </div>

            <!-- Prénom -->
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Entrez votre prénom" required>
            </div>

            <!-- Email (Login) -->
            <div class="mb-3">
                <label for="email" class="form-label">Email (Login)</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Entrez votre adresse email" required>
            </div>

            <!-- Mot de passe -->
            <div class="mb-3">
                <label for="mdp" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Entrez un mot de passe" required>
            </div>

            <!-- Confirmation du mot de passe -->
            <div class="mb-3">
                <label for="mdpConfirmation" class="form-label">Confirmation du mot de passe</label>
                <input type="password" class="form-control" id="mdpConfirmation" name="mdpConfirmation" placeholder="Confirmez votre mot de passe" required>
            </div>

            {{-- Rôle --}}
        <div class="mb-3">
            <label for="role" class="form-label">Rôle</label>
            <select name="role" id="role" class="form-control" required>
                <option value="Technicien" {{ old('role') == 'Technicien' ? 'selected' : '' }}>Technicien</option>
                <option value="Superviseur" {{ old('role') == 'Superviseur' ? 'selected' : '' }}>Superviseur</option>
            </select>
        </div>

            <!-- Bouton de soumission -->
            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
