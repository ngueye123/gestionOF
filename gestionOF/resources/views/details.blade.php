<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'inventaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('menuPrincipal')

    <div class="container mt-4">
        <h1>Détails de l'inventaire</h1>

        <div class="mb-4">
            <h3>Informations générales</h3>
            <p><strong>Technicien :</strong> {{ $inventaire->personnel->nom }}</p>
            <p><strong>Date de soumission :</strong> {{ $inventaire->dateSoumission }}</p>
        </div>

        <div>
            <h3>Produits </h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>produit</th>
                        <th>Quantité ancienne</th>
                        <th>Nouvelle quantité</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($details as $detail)
                        <tr>
            
                            <td>{{ $detail->produit->nom }}</td>
                            <td>{{ $detail->ancienne_quantite }}</td>
                            <td>{{ $detail->nouvelle_quantite }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <a href="{{ route('inventaire') }}" class="btn btn-primary">Retour à la liste</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
