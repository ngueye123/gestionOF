<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrôle des Jetons</title>
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
        <h1 class="mb-4">Contrôle des Jetons</h1>

        <form method="POST" action="{{ route('controle.store') }}">
            <fieldset>
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="idOF" class="form-label">Sélectionner un OF</label>
                    <select class="form-control" id="idOF" name="idOF" required>
                        @foreach($ofs as $of)
                            <option value="{{ $of->idOF }}">{{ $of->idOF }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="testeur" class="form-label">Nom du Testeur</label>
                    <input type="text" class="form-control" id="testeur" name="testeur" required>
                </div>
            </div>

            <div class="row">
                @for ($i = 1; $i <= 4; $i++)
                    <div class="col-md-3">
                        <div class="card mb-3">
                            <div class="card-header bg-dark text-white" >Jeton {{ $i }}</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Épaisseur (mm)</label>
                                    <input type="number" class="form-control epaisseur" name="jetons[{{ $i-1 }}][epaisseur]" step="0.01" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Diamètre (mm)</label>
                                    <input type="number" class="form-control diametre" name="jetons[{{ $i-1 }}][diametre]" step="0.01" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Couleur</label>
                                    <select class="form-control" name="jetons[{{ $i-1 }}][couleur]" required>
                                        <option value="Blanc">Blanc</option>
                                        <option value="Rouge">Rouge</option>
                                        <option value="Vert">Vert</option>
                                        <option value="Rose">Rose</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Conforme</label>
                                    <input type="text" class="form-control conformity" name="jetons[{{ $i-1 }}][conforme]" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            <button type="submit" class="btn btn-primary" style="margin-bottom: 50px;">Enregistrer</button>
            
        </form>
    </div>

    <div class="container" style="margin-bottom: 50px;" >
        <h2 class="mb-4">liste des contrôles des OF</h2>
        @foreach($controles as $idOF => $controleParOF)
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <h5>Contrôle de l'Ordre de Fabrication : {{ $idOF }}</h5>
                </div>
                <div class="card-body" >
                    <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($controleParOF->first()->dateControl)->format('d/m/Y H:i') }}</p>
                    <p><strong>TPI:</strong> {{ $controleParOF->first()->personnel->nom }} {{ $controleParOF->first()->personnel->prenom }}</p>

                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Jeton</th>
                                <th>Testeur</th>
                                <th>Couleur</th>
                                <th>Épaisseur (mm)</th>
                                <th>Diamètre (mm)</th>
                                <th>Conformité</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($controleParOF as $controle)
                                <tr>
                                    <td>Jeton {{ $controle->numeroJeton }}</td>
                                    <td>{{ $controle->testeur }}</td>
                                    <td>{{ $controle->couleur }}</td>
                                    <td>{{ $controle->epaisseur }}</td>
                                    <td>{{ $controle->diametre }}</td>
                                    <td>{{ $controle->conformite ? 'OK' : 'Non Conforme' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach

    </div>




    <script>
        document.addEventListener('input', function() {
            let jetons = document.querySelectorAll('.card');
            jetons.forEach(function(card) {
                let epaisseur = parseFloat(card.querySelector('.epaisseur').value);
                let diametre = parseFloat(card.querySelector('.diametre').value);
                let conformeInput = card.querySelector('.conformity');

                let conforme = (!isNaN(epaisseur) && epaisseur >= 2.0 && epaisseur <= 2.6) &&
                               (!isNaN(diametre) && diametre >= 22.7 && diametre <= 23.3);

                conformeInput.value = conforme ? 'Conforme' : 'Non Conforme';
                if(conformeInput.value=='Conforme'){
                    conformeInput.style.color = "green";
                }else{
                    conformeInput.style.color = "red";
                }
                
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
