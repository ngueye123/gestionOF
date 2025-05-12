<!DOCTYPE html>
<html lang="fr">
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
 
        <h2>Inventaires en attente</h2>
        <table class="table" id="inventaire">
            <thead>
                <tr>
                    <th>Technicien</th>
                    <th>Date de soumission</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inventaireEnAttente as $inventaire)
                    <tr>
                        <td>{{ $inventaire->personnel->nom }}</td>
                        <td>{{ $inventaire->dateSoumission }}</td>
                        <td>{{ $inventaire->status }}</td>
                        <td>
                            <a href="{{ route('inventaire.valider', $inventaire->idInventaire) }}" class="btn btn-success">Valider</a>
                            <a href="{{ route('inventaire.rejeter', $inventaire->idInventaire) }}" class="btn btn-danger">Rejeter</a>
                            <a href="{{ route('inventaire.details', $inventaire->idInventaire) }}" class="btn btn-info">Détails</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function chargerInventaire() {
            $.ajax({
                url: "{{ route('inventaire.enAttente') }}",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    let html = '';

                    if (data.length === 0) {
                        html = '<tr><td colspan="4" class="text-center text-danger">Aucun inventaire en attente.</td></tr>';
                    } else {
                        data.forEach(inventaire => {
                            html += `
                                <tr>
                                    <td>${inventaire.personnel.nom}</td>
                                    <td>${inventaire.dateSoumission}</td>
                                    <td>${inventaire.status}</td>
                                    <td>
                                        <a href="/inventaire/valider/${inventaire.idInventaire}" class="btn btn-success">Valider</a>
                                        <a href="/inventaire/rejeter/${inventaire.idInventaire}" class="btn btn-danger">Rejeter</a>
                                        <a href="/inventaire/details/${inventaire.idInventaire}" class="btn btn-info">Détails</a>
                                    </td>
                                </tr>`;
                        });
                    }

                    // Mise à jour uniquement si nécessaire
                    if ($('#inventaire tbody').html().trim() !== html.trim()) {
                        $('#inventaire tbody').html(html);
                    }
                },
                error: function() {
                    console.error("Erreur lors du chargement des inventaires.");
                }
            });
        }

        // Démarrer après le chargement initial
        $(document).ready(function() {
            chargerInventaire(); // Charger immédiatement
            setInterval(chargerInventaire, 1000); // Rafraîchir toutes les 5 secondes
        });

    </script>
    

</body>
</html>
