<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Ordres de Fabrication</title>
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
    <div class="container">
        <h2 class="mb-4">Modifier le Statut de l'Ordre de Fabrication</h2>

        <form method="POST" action="{{ route('of.update', $of->idOF) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="statut" class="form-label">Statut</label>
                <select class="form-control" id="statut" name="statut" required>
                    <option value="en cours" {{ $of->statut == 'en cours' ? 'selected' : '' }}>En cours</option>
                    <option value="terminé" {{ $of->statut == 'terminé' ? 'selected' : '' }}>Terminé</option>
                    <option value="incident" {{ $of->statut == 'incident' ? 'selected' : '' }}>Incident</option>
                    <option value="annulé" {{ $of->statut == 'annulé' ? 'selected' : '' }}>Annulé</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Enregistrer les modifications</button>
        </form>
    </div>
</body>