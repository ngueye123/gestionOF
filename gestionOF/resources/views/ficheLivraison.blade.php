<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    @if (session('success'))
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
    <div class="container">
        <h2>Créer une fiche de livraison</h2>
        <form action="{{ route('livraison.store') }}" method="POST">
            @csrf

            
            <div class="mb-3">
                <label for="idOF" class="form-label">Ordre de Fabrication</label>
                <select name="idOF" id="idOF" class="form-control" required>
                    @foreach($ordres as $ordre)
                        <option value="{{ $ordre->idOF }}">{{ $ordre->idOF }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="dateLivraison" class="form-label">Date de fin de production</label>
                <input type="datetime-local" name="dateLivraison" id="dateLivraison" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>

    <div class="container">
    <h2 class="mb-4">Liste des Fiches de Livraison</h2>

    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Ordre de Fabrication (OF)</th>
                <th>Technicien</th>
                <th>Date de fin de production</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fiches as $livraison)
            <tr>
                <td>{{ $livraison->idOF }}</td>
                <td>{{ $livraison->personnel->nom }} {{ $livraison->personnel->prenom }}</td>
                <td>{{ $livraison->dateLivraison }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>