<?php

namespace App\Http\Controllers;
use App\Models\OrdreFabrication;
use App\Models\Personnel;
use App\Models\Control;
use App\Models\Log;

use Illuminate\Http\Request;

class ControlController extends Controller
{
    public function index(){
        $controles = Control::orderBy('dateControl', 'desc')->limit(10)->get()->groupBy('idOF');
        $ofs = OrdreFabrication::where('statut', 'terminé')
        ->orderBy('dateDebut', 'asc')
        ->with('personnel')
        ->get();
        
        return view('control',compact('ofs','controles'));

    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'idOF' => 'required|exists:ordrefabrication,idOF',
            'testeur' => 'required|string|max:100',
            'jetons' => 'required|array|size:4',
            'jetons.*.epaisseur' => 'required|numeric',
            'jetons.*.diametre' => 'required|numeric',
            'jetons.*.couleur' => 'required|string|max:50',
            'jetons.*.conforme' => 'required|string|in:Conforme,Non Conforme',
        ]);
    
    

        // Vérifier si un contrôle existe déjà pour cet OF
        if (Control::where('idOF', $validated['idOF'])->exists()) {
            return redirect()->back()->withErrors("Un contrôle pour cet OF existe déjà.")->withInput();
        }

        $compte = Personnel::where('email', session()->get('connexion'))->first();
        if (!$compte) {
            return redirect()->back()->withErrors("Utilisateur non trouvé. Veuillez vous reconnecter.")->withInput();
        }
    
        // Enregistrement des 4 jetons
        try {
            foreach ($validated['jetons'] as $numero => $jeton) {
                Control::create([
                    'idOF' => $validated['idOF'],
                    'numeroJeton' => $numero + 1,
                    'epaisseur' => $jeton['epaisseur'],
                    'diametre' => $jeton['diametre'],
                    'couleur' => $jeton['couleur'],
                    'conformite' => $jeton['conforme'] === "Conforme" ? 1 : 0,
                    'testeur' => $validated['testeur'],
                    'idPersonnel' => $compte->idPersonnel,
                ]);
            }
    
            // Journalisation
           Log::ecrireLog($compte->nom, $compte->prenom, "Contrôle Jeton",$validated['idOF']);
    
            return redirect()->route('controle')->with('success', 'Contrôle enregistré avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors("Erreur lors de l'enregistrement : " . $e->getMessage())->withInput();
        }
    }
}
