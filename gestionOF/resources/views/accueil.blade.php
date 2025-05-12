<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <title>Page d'Accueil</title>
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
        <h2>Les ordres de fabrication en cours</h2>
        <div class="row" id="of-container">
            <!-- Affichage initial côté serveur -->
            @forelse($ofEnCours as $of)
            <div class="col-md-3 of-card" data-id="{{ $of->idOF }}" style="margin-bottom: 10px;">
                <div class="card mb-6">
                    <div class="card-body">
                        <h5 class="card-title">OF: {{ $of->idOF }}</h5>
                        <p class="card-text">Statut : {{ $of->statut }}</p>
                        <p class="card-text">Lancée par : {{ $of->personnel->prenom }} {{ $of->personnel->nom }}</p>
                        <a href="/of/{{ $of->idOF }}/edit" class="btn btn-primary">Modifier le statut</a>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center text-danger">Aucun ordre de fabrication en cours.</p>
            @endforelse
        </div>
    </div>
    <script>
    // Rafraîchissement AJAX (maintient les données à jour)
    function chargerOFEnCours() {
        $.ajax({
            url: "{{ route('of.enCours') }}",
            type: "GET",
            dataType: "json",
            success: function(data) {
                let html = '';
                
                if (data.length === 0) {
                    html = '<p class="text-center text-danger">Aucun ordre de fabrication en cours.</p>';
                } else {
                    data.forEach(of => {
                        html += `
                            <div class="col-md-3 of-card" data-id="${of.idOF}" style="margin-bottom: 10px;">
                                <div class="card mb-6">
                                    <div class="card-body">
                                        <h5 class="card-title">OF: ${of.idOF}</h5>
                                        <p class="card-text">Statut : ${of.statut}</p>
                                        <p class="card-text">Lancée par : ${of.personnel.prenom} ${of.personnel.nom}</p>
                                        <a href="/of/${of.idOF}/edit" class="btn btn-primary">Modifier le statut</a>
                                    </div>
                                </div>
                            </div>`;
                    });
                }

                // Mise à jour uniquement si nécessaire
                if ($('#of-container').html().trim() !== html.trim()) {
                    $('#of-container').html(html);
                }
            }
        });
    }

    // Démarrer après le chargement initial
    $(document).ready(function() {
        setInterval(chargerOFEnCours, 1000); // Maintenance des données
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
