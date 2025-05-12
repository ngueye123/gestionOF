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
    
    <div class="container mt-5 d-flex justify-content-center">
    <div class="programme-card border border-dark p-3">
        <div class="text-center border border-dark p-2 fw-bold">PROGRAMME N° {{ $programme->idProgramme }}</div>

        <!-- Tableau Ecol' Box -->
        <table class="table-bordered text-center w-100 programme-table mt-3">
            <thead>
                <tr><th colspan="2" class="bg-light">Ecol' Box</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td class="bg-light">Position</td>
                    <td>{{ $programme->positionBox }}</td>
                    
                </tr>
                <tr>
                    <td class="bg-light">Boîte</td>
                    <td>{{ $programme->boite }}</td>
                </tr>
               
            </tbody>
        </table>

        <!-- Tableau Ecol' Régul -->
        <table class="table-bordered text-center w-100 programme-table mt-3">
            <thead>
                <tr><th colspan="3" class="bg-light">Ecol' Régul</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td class="bg-light">Position</td>
                    <td>{{ $programme->positionRegul }}</td>
                </tr>
                <tr>
                    <td class="bg-light">Film</td>
                    <td>{{ $programme->film }}</td>
                </tr>
                <tr>
                    <td class="bg-light">Briquette</td>
                    <td>{{ $programme->nbreBriquette }}</td>
                </tr>
               
            </tbody>
        </table>

        <!-- Tableau Robot -->
        <table class="table-bordered text-center w-100 programme-table mt-3 robot">
            <thead>
                <tr><th colspan="2" class="bg-light">Robot</th></tr>
            </thead>
            <tbody>
                 <tr>
                    <td class="bg-light">Programme</td>
                    <td>{{ $programme->idProgramme }}</td>
                </tr>
                <tr>
                    <td class="bg-light">Caisse</td>
                    <td>{{ $programme->Taillecaisse }}</td>
                </tr>
               
                <tr>
                    <td class="bg-light">Gravitaire</td>
                    <td>{{ $programme->gravitaire ? 'Oui' : 'Non' }}</td>
                </tr>
            </tbody>
        </table>

        
        <div class="text-center mt-4">
            <a href="{{ route('programme') }}" class="btn btn-primary">Retour</a>
        </div>
    </div>
</div>

<style>
   
    .programme-card {
        width: 90%;
        max-width: 600px;
        background: white;
    }
    .programme-table {
        border-collapse: collapse;
        width: 100%;
    }
    .programme-table th, .programme-table td {
        border: 1px solid black;
        padding: 8px;
    }
    .programme-table .bg-light {
        background: #f8f9fa;
        font-weight: bold;
    }
</style>
</body>