<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recette;
use App\Models\Produit;

class RecetteController extends Controller
{
    public function index($messagesErreur=[])
   {
        $produits = Produit::all();
        $recettes = Recette::with('produits')->orderBy('idRecette', 'desc')->get(); 

        if(session()->has('connexion')){
            if(session()->get('role')=="Technicien"){
                $messagesErreur[] = "Connectez vous en temps que Superviseur pour acceder à cette page";
                return view('connexion')->with('messagesErreur', $messagesErreur);
            }
        }else{
            return redirect()->route('connexion');
        }
        return view('recette', compact('recettes','produits' ))->with('messagesErreur', $messagesErreur);
    }

    public function store(Request $request)
    {
        $messagesErreur = array();

        // Validation des données
        $request->validate([
            'nom' => 'required|string|max:255',
            'produits' => 'required|array',
            'produits.*.idProduit' => 'required|exists:produit,idProduit',
            'produits.*.quantite' => 'required|numeric|min:1',
        ]);

        // Vérifier si une recette avec le même nom existe déjà
        $recetteExistant = Recette::where('nom', $request->nom)->first();
        if ($recetteExistant) {
            $messagesErreur[] = 'Une recette avec ce nom existe déjà. Veuillez choisir un autre nom.';
        }

        if (!empty($messagesErreur)) {
            return $this->index($messagesErreur);
        }

        // Création de la recette
        $recette = Recette::create([
            'nom' => $request->nom,
        ]);

        // Association des produits à la recette
        $produitAssociations = [];
        foreach ($request->produits as $produit) {
            $produitAssociations[$produit['idProduit']] = ['quantite' => $produit['quantite']];
        }
        $recette->produits()->attach($produitAssociations);

        // Redirection avec un message de succès
        return redirect()->route('recette')->with('success', 'Recette ajoutée avec succès !');
    }

}
