<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <h2 class="mb-4">Connexion</h2>
        {{-- Affichage des messages d'erreur --}}
        @include('messageErreur')

        {{-- Formulaire d'inscription --}}
        <form method="POST" action="{{ route('validationConnexion') }}">
            @csrf
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

            {{-- Rôle --}}
        <div class="mb-3">
            <label for="role" class="form-label">Rôle</label>
            <select name="role" id="role" class="form-control" required>
                <option value="Technicien" {{ old('role') == 'Technicien' ? 'selected' : '' }}>Technicien</option>
                <option value="Superviseur" {{ old('role') == 'Superviseur' ? 'selected' : '' }}>Superviseur</option>
            </select>
        </div>

            <!-- Bouton de soumission -->
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
