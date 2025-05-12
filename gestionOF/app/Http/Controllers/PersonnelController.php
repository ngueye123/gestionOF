<?php

namespace App\Http\Controllers;
use App\Models\Personnel;

use Illuminate\Http\Request;

class PersonnelController extends Controller
{
   
    public function index($messagesErreur=[])
    {
      
    if(session()->has('connexion')){
            if(session()->get('role')=="Technicien"){
                $messagesErreur[] = "Connecter vous en temps que Superviseur";
                return view('connexion')->with('messagesErreur', $messagesErreur);
            }
        }else{
            return redirect()->route('connexion');
        } 
        return view('personnel')->with('messagesErreur', $messagesErreur);
    }


    public function store(Request $request){
        $messagesErreur = [];
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mdp' => 'required|string',
        ]);

        // Vérification de l'unicité de l'email
        $emailExistant = Personnel::where('email', $request->email)->first();
        if ($emailExistant) {
            $messagesErreur[] = "L'email a deja été utilisé";
        }

        // Vérification si les mots de passe correspondent
        if ($request->mdp !== $request->mdpConfirmation) {
            $messagesErreur[] = "Les deux mots de passe saisis ne sont pas identiques.";
        }

        // Si des erreurs existent, les renvoyer à la vue
        if (!empty($messagesErreur)) {
            return $this->index($messagesErreur);
        }

            // Création de l'utilisateur
        Personnel::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'mdp' => bcrypt($request->mdp), // Hash du mot de passe
            'role' => $request->role,
        ]);

        return redirect()->route('personnel')->with('success', 'Inscription réussie !');
 
   
    }
}
