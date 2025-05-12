<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('menuTechnicien')
    <div class="container mt-5">
    <h1 class="mb-4">Liste des Programmes</h1>

    <div class="row">
        @foreach ($programmes as $programme)
            <div class="col-md-3 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Programme N° {{ $programme->idProgramme }}</h5>
                        <p class="card-text"><strong>Boîte :</strong> {{ $programme->boite }}</p>
                        <p class="card-text"><strong>Taille caisse :</strong> {{ $programme->Taillecaisse }}</p>
                        <p class="card-text"><strong>Position Box :</strong> {{ $programme->positionBox }}</p>
                        <p class="card-text"><strong>Position Régul :</strong> {{ $programme->positionRegul }}</p>
                        <a href="{{ route('programme.details', $programme->idProgramme) }}" class="btn btn-primary">
                            Voir détails
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>