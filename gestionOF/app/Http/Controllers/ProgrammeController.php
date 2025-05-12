<?php

namespace App\Http\Controllers;

use App\Models\Programme;
use Illuminate\Http\Request;

class ProgrammeController extends Controller
{
    public function index($messagesErreur = []){
        $programmes = Programme::orderby('idProgramme')->get();

      
        return view('programme',compact('programmes'))->with('messagesErreur', $messagesErreur);
    }

    public function afficherFormulaire(){
        $programmes = Programme::all();
        return view('ajoutProgramme',compact('programmes'));
    }


    public function details($id)
    {
    $programme = Programme::findOrFail($id);
    return view('programmeDetail', compact('programme'));
    }

    public function store(Request $request){

        $messagesErreur = []; // Pour ajouter d'autres erreurs spécifiques

        // Vérifier si un ordre de fabrication existe déjà
        $programmeExist = Programme::where('idProgramme', $request->idProgramme)->first();
        if ($programmeExist) {
            $messagesErreur[] = 'Le numero du programme existe déja';
        }

            // Si des erreurs supplémentaires sont détectées
        if (!empty($messagesErreur)) {
            return redirect()->back()->withErrors($messagesErreur)->withInput();
        }

    
        Programme::create([
            'idProgramme' =>$request->idProgramme,
            'gravitaire' =>$request->gravitaire,
            'boite' =>$request->boite,
            'positionBox' =>$request->positionBox,
            'positionRegul' =>$request->positionRegul,
            'taillecaisse' =>$request->tailleCaisse,
            'film' =>$request->film,
            'nbreBriquette' =>$request->nbreBriquette,


        ]);

        return redirect()->route('formulaire')->with('success', 'Programme ajouté avec succès.');

    }
    
}
