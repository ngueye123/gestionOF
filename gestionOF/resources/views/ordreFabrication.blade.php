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


    <div class="container mt-4">
        <h1 class="mb-4">Gestion des Ordres de Fabrication (OF)</h1>

        <!-- Formulaire d'ajout d'OF -->
        <div class="card mb-4">
            <div class="card-header">
                Ajouter un Ordre de Fabrication
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('of.store') }}">
                    @csrf
                    @include('messageErreur')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="idOF" class="form-label">Numéro de l'OF</label>
                                <input type="text" class="form-control" id="idOF" name="idOF" placeholder="Entrez le numéro de l'OF" required>
                            </div>
                            <div class="mb-3">
                                <label for="dateDebut" class="form-label">Date de début</label>
                                <input type="datetime-local" class="form-control" id="dateDebut" name="dateDebut" required>
                            </div>
                            <div class="mb-3">
                                <label for="dateButoire" class="form-label">Date butoir</label>
                                <input type="datetime-local" class="form-control" id="dateButoire" name="dateButoire" required>
                            </div>
                            <div class="mb-3">
                                <label for="boiteFilme" class="form-label">Boîte filmée</label>
                                <select class="form-control" id="boiteFilme" name="boiteFilme" required>
                                    <option value="1">Oui</option>
                                    <option value="0">Non</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="couleur" class="form-label">Couleur</label>
                                <select class="form-control" id="couleur" name="couleur" required>
                                    <option value="Blanc">Blanc</option>
                                    <option value="Rouge">Rouge</option>
                                    <option value="Vert">Vert</option>
                                    <option value="Rose">Rose</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="statut" class="form-label">Statut</label>
                                <select class="form-control" id="statut" name="statut" required>
                                    <option value="en cours">En cours</option>
                                    <option value="terminé">Terminé</option>
                                    <option value="annulé">Annulé</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="idRecette" class="form-label">Recette</label>
                                <select class="form-control" id="idRecette" name="idRecette" required>
                                    @foreach($recettes as $recette)
                                        <option value="{{ $recette->idRecette }}">{{ $recette->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="idProgramme" class="form-label"> Numero de programme</label>
                                <select class="form-control" id="idProgramme" name="idProgramme" required>
                                    @foreach($programmes as $programme)
                                        <option value="{{ $programme->idProgramme }}">{{ $programme->idProgramme }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="nbreCaisse" class="form-label">Nombre de caisses</label>
                                <input type="number" class="form-control" id="nbreCaisse" name="nbreCaisse" min="1" required>
                            </div>
                            <div class="mb-3">
                                <label for="nbreBoite" class="form-label">Nombre de boîtes</label>
                                <input type="number" class="form-control" id="nbreBoite" name="nbreBoite" min="1" required>
                            </div>
                            <div class="mb-3">
                                <label for="nbreJetonParBoite" class="form-label">Nombre de jetons par boîte</label>
                                <input type="number" class="form-control" id="nbreJetonParBoite" name="nbreJetonParBoite" min="1" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>

        <!-- Liste des OF -->
        <div class="container">
    <h2 class="mb-4">Liste des Ordres de Fabrication</h2>
    @foreach($ofs as $of)
    <div class="card mb-4">
        <div class="card-header bg-dark text-white">
            <h5>Ordre de Fabrication : {{ $of->idOF }}</h5>
        </div>
        <div class="card-body">
            <p><strong>Date de début :</strong> {{ \Carbon\Carbon::parse($of->dateDebut)->format('d/m/Y H:i:s') }}</p>
            <p><strong>Date butoir :</strong> {{ \Carbon\Carbon::parse($of->dateButoire)->format('d/m/Y H:i:s') }}</p>
            <p><strong>TPI :</strong> {{ $of->personnel->nom ?? 'Inconnu' }} {{ $of->personnel->prenom ?? 'Inconnu' }}</p>

            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Boîte filmée</th>
                        <th>Couleur</th>
                        <th>Recette</th>
                        <th>Programme</th>
                        <th>Nbre de caisses</th>
                        <th>Nbre de boîtes</th>
                        <th>Nbre de jetons/boîte</th>
                        <th>Statut</th>
                        <th>Total jetons</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $of->boiteFilme ? 'Oui' : 'Non' }}</td>
                        <td>{{ $of->couleur }}</td>
                        <td>{{ $of->recette->nom ?? 'Inconnu' }}</td>
                        <td>{{ $of->programme->boite ?? 'Inconnu' }}</td>
                        <td>{{ $of->nbreCaisse }}</td>
                        <td>{{ $of->nbreBoite }}</td>
                        <td>{{ $of->nbreJetonParBoite }}</td>
                        <td>{{ $of->statut }}</td>
                        <td>{{ $of->nbreBoite * $of->nbreJetonParBoite }}</td>
                    </tr>
                </tbody>
            </table>

            <a href="{{ route('of.edit', $of->idOF) }}" class="btn btn-primary btn-sm">Modifier le statut</a>
        </div>
    </div>
    @endforeach
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
