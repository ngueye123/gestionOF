<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Logs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('menuPrincipal') 
    <div class="container mt-4">
        <h2 class="mb-4">Gestion des Logs</h2>

        <div class="card mb-4">
            <div class="card-header">
                Choisissez deux dates pour filtrer les logs
            </div>

            @if(session('messagesErreur'))
            <div class="alert alert-danger">
                @foreach(session('messagesErreur') as $message)
                    <p>{{ $message }}</p>
                @endforeach
            </div>
             @endif

            <div class="card-body">
                <form method="GET" action="{{ route('log') }}">
                    @csrf
                    @include('messageErreur')
                    <div class="mb-3">
                    <label for="date" class="form-label">Date de début</label>
                    <input type="datetime-local" class="form-control" id="date" name="dateDebut" required>
                </div>
                <div class="mb-3">
                    <label for="dateButoire" class="form-label">Date de fin</label>
                    <input type="datetime-local" class="form-control" id="dateFin" name="dateFin" required>
                </div>

                    
                 
                    <button type="submit" class="btn btn-primary" name="valider">valider</button>
                </form>
            </div>
        </div>

        <!-- Carte pour afficher les logs -->
        <div class="card">
            <div class="card-header">
                Liste des Logs
            </div>
            <div class="card-body">
                @if($logs->isEmpty())
                    <div class="alert alert-info">Aucun log disponible pour cette date.</div>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prenom</th>
                                <th>Date</th>
                                <th>Action réalisée</th>
                                <th>OF</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                                <tr>
                                    <td>{{ $log->personnel->nom ?? 'Inconnu' }}</td>
                                    <td>{{ $log->personnel->prenom ?? 'Inconnu' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($log->dateTime)->format('d/m/Y H:i:s') }}</td>
                                    <td>{{ $log->action }}</td>
                                    <td>{{ $log->ordreFabrication->idOF?? 'Non spécifié' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
