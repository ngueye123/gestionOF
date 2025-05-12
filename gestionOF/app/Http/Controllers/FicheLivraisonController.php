<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FicheLivraison;
use App\Models\OrdreFabrication;
use App\Models\Personnel;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class FicheLivraisonController extends Controller
{
    public function index()
    {
        // Récupérer les fiches de livraison avec les informations associées
        $fiches = FicheLivraison::orderBy('dateLivraison', 'desc')->get();
   
        $ordres = OrdreFabrication::where('statut', 'terminé')
        ->orderBy('dateDebut', 'asc')->with('personnel')->get();
        return view('ficheLivraison', compact('fiches','ordres'));
    }

    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'idOF' => 'required|exists:ordrefabrication,idOF',
            'dateLivraison' => 'required|date',
        ]);

        // Récupérer l'utilisateur connecté
        $compte = Personnel::where('email', session()->get('connexion'))->first();
        if (!$compte) {
            return redirect()->back()->withErrors("Utilisateur non trouvé. Veuillez vous reconnecter.")->withInput();
        }
        if (FicheLivraison::where('idOF', $validated['idOF'])->exists()) {
            return redirect()->back()->withErrors("Une fiche de livraison pour cet OF existe déjà.")->withInput();
        }

        // Enregistrement de la fiche de livraison
        FicheLivraison::create([
            'idOF' => $validated['idOF'],
            'idPersonnel' => $compte->idPersonnel,
            'dateLivraison' => $validated['dateLivraison'],
        ]);

        Log::ecrireLog($compte->nom, $compte->prenom, "Enregistrement fiche livraison",$validated['idOF']);
        return redirect()->route('livraison')->with('success', 'Fiche de livraison enregistrée avec succès.');
    }
}
