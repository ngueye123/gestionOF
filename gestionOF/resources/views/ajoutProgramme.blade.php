<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Programme</title>
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
        <h1 class="mb-4">Formulaire Programme</h1>

        <!-- Formulaire d'ajout d'OF -->
        <div class="card mb-4">
            <div class="card-header">
                Ajouter un programme
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('programme.store') }}">
                    @csrf
                    @include('messageErreur')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="idOF" class="form-label">Numéro du programme</label>
                                <input type="number" class="form-control" id="idProgramme" name="idProgramme" placeholder="Entrez le numéro du programme" required>
                            </div>
                           
                            <div class="mb-3">
                                <label for="boiteFilme" class="form-label">gravitaire</label>
                                <select class="form-control" id="gravitaire" name="gravitaire" required>
                                    <option value="1">Oui</option>
                                    <option value="0">Non</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="couleur" class="form-label"> Taille de la boite</label>
                                <select class="form-control" id="boite" name="boite" required>
                                    <option value="Petite">Petite</option>
                                    <option value=">Grande">Grande</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="statut" class="form-label">Position Box</label>
                                <select class="form-control" id="positionBox" name="positionBox" required>
                                    <option value="Paysage">Paysage</option>
                                    <option value="Portrait">Portrait</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                             <div class="mb-3">
                                <label for="statut" class="form-label">Position Regul</label>
                                <select class="form-control" id="positionRegul" name="positionRegul" required>
                                    <option value="Paysage">Paysage</option>
                                    <option value="Portrait">Portrait</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="statut" class="form-label">Taille caisse</label>
                                <select class="form-control" id="tailleCaisse" name="tailleCaisse" required>
                                    <option value="Petite">Petite</option>
                                    <option value="Grande">Grande</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="statut" class="form-label">Film</label>
                                <select class="form-control" id="film" name="film" required>
                                    <option value="Petite">Petite</option>
                                    <option value="Grande">Grande</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="nbreJetonParBoite" class="form-label">Nombre de briquette</label>
                                <input type="number" class="form-control" id="nbreBriquette" name="nbreBriquette" min="1" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>

       

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
