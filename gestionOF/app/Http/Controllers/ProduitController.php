<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;


class ProduitController extends Controller
{
    // Afficher la liste des produits avec leurs recettes
    public function index($messagesErreur = [])
    {
        // Récupérer tous les produits avec leurs recettes et quantités
        $produits = Produit::orderby('idProduit', 'desc')->get();

        if(session()->has('connexion')){
            if(session()->get('role')=="Technicien"){
                $messagesErreur[] = "Connecter vous en temps que Superviseur";
                return view('connexion')->with('messagesErreur', $messagesErreur);
            }
        }else{
            return redirect()->route('connexion');
        }

        // Renvoyer la vue avec les messages d'erreur s'il y en a
        return view('produit', compact('produits'))->with('messagesErreur', $messagesErreur);
    }

    public function store(Request $request)
    {
        $messageErreur = [];

        // Validation des données de base
        $request->validate([
            'nom' => 'required|string|max:255',
            'quantite' => 'required|numeric|min:1',
        ]);

        // Vérifier si un produit avec le même nom existe déjà
        $produitExistant = Produit::where('nom', $request->nom)->first();
        if ($produitExistant) {
            $messageErreur[] = 'Un produit avec ce nom existe déjà. Veuillez choisir un autre nom.';
        }

        // Si des erreurs existent, rediriger vers index avec les messages d'erreur
        if (!empty($messageErreur)) {
            return $this->index($messageErreur);
        }

        // Création du produit
         Produit::create([
            'nom' => $request->nom,
            'quantite' => $request->quantite,
        ]);

        // Attacher les recettes au produit
      

        return redirect()->route('produit')->with('success', 'Produit ajouté avec succès.');
    }
}
