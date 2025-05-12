<?php

namespace App\Http\Controllers;

use App\Models\OrdreFabrication;
use App\Models\Personnel;
use App\Models\Log;
use App\Models\Recette;
use App\Models\Produit;
use App\Models\Programme;
use Illuminate\Http\Request;

class OrdreFabricationController extends Controller
{
    public function index($messagesErreur = [])
    {
        $ofs = OrdreFabrication::with('personnel', 'recette', 'programme')
            ->orderByRaw("CASE WHEN statut = 'en cours' THEN 1 ELSE 2 END") // Les "en cours" en premier
            ->orderBy('dateButoire', 'asc')->get();
        $personnels = Personnel::all();
        $recettes = Recette::all();
        $programmes = Programme::all();

        return view('ordreFabrication', compact('ofs', 'personnels', 'recettes', 'programmes'))
            ->with('messagesErreur', $messagesErreur);
    }

    public function store(Request $request)
{
    // Validation des données
    $validated = $request->validate([
        'idOF' => 'required|string|max:50',
        'dateDebut' => 'required|date',
        'dateButoire' => 'required|date',
        'statut' => 'required|string|max:500',
        'boiteFilme' => 'required',
        'couleur' => 'required',
        'idRecette' => 'required|exists:recette,idRecette',
        'idProgramme' => 'required|exists:programme,idProgramme',
        'nbreCaisse' => 'required|integer|min:1',
        'nbreBoite' => 'required|integer|min:1',
        'nbreJetonParBoite' => 'required|integer|min:1',
    ]);

    $messagesErreur = []; // Pour ajouter d'autres erreurs spécifiques

    // Vérifier si un ordre de fabrication existe déjà
    $ofExistant = OrdreFabrication::where('idOF', $validated['idOF'])->first();
    if ($ofExistant) {
        $messagesErreur[] = 'Un ordre de fabrication avec cet ID existe déjà.';
    }

    // Récupérer l'utilisateur connecté
    $compte = Personnel::where('email', session()->get('connexion'))->first();
    if (!$compte) {
        $messagesErreur[] = 'Utilisateur non trouvé. Veuillez vous reconnecter.';
    }

    $nbreJeton=$validated['nbreBoite']*$validated['nbreJetonParBoite'];
    if ($nbreJeton%4 !=0) {
        $messagesErreur[] = 'Nombre de jeton incorrect. Il doit etre un multiple de 4!';
    }

    // Si des erreurs supplémentaires sont détectées
    if (!empty($messagesErreur)) {
        return redirect()->back()->withErrors($messagesErreur)->withInput();
    }

    

    // Enregistrement dans la base de données

    $ordreFabrication=OrdreFabrication::create([
        'idOF' => $validated['idOF'],
        'dateDebut' => $validated['dateDebut'],
        'dateButoire' => $validated['dateButoire'],
        'boiteFilme' => $validated['boiteFilme'],
        'couleur' => $validated['couleur'],
        'idRecette' => $validated['idRecette'],
        'idProgramme' => $validated['idProgramme'],
        'nbreCaisse' => $validated['nbreCaisse'],
        'nbreBoite' => $validated['nbreBoite'],
        'nbreJetonParBoite' => $validated['nbreJetonParBoite'],
        'idPersonnel' => $compte->idPersonnel,
        'statut' => $validated['statut'],
    ]);

 

    Log::ecrireLog(
        $compte->nom, $compte->prenom,"Création OF",$validated['idOF']
    );

    return redirect()->route('of')->with('success', 'Ordre de fabrication ajouté avec succès.');
}


    public function edit($id)
    {
        $of = OrdreFabrication::findOrFail($id);
        return view('ofEdit', compact('of'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'statut' => 'required|string|max:500',
        ]);

        $of = OrdreFabrication::findOrFail($id);
        $of->update(['statut' => $validated['statut']]);

        $compte = Personnel::where('email', session()->get('connexion'))->first();

        Log::ecrireLog($compte->nom,$compte->prenom,
            "Modification du statut en '{$validated['statut']}'",
            $of->idOF
        );

        return redirect()->route('of')->with('success', 'Statut mis à jour avec succès.');
    }
}
