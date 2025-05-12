<?php
namespace App\Http\Controllers;

use App\Models\Inventaire;
use App\Models\Personnel;
use App\Models\Produit;
use App\Models\InventaireDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class InventaireController extends Controller
{
    public function index()
    {
        if (!session()->has('connexion')) {
            return redirect()->route('connexion');
        }

        $role = session()->get('role');
        $produits = Produit::all(); // Liste des produits

        if ($role == "Technicien") {
            return view('inventaire', compact('produits'));
        } elseif ($role == "Superviseur") {
            $inventaireEnAttente = Inventaire::where('status', 'en attente')->get();
            return view('validationInventaire', compact('inventaireEnAttente'));
        }

        return redirect()->route('connexion');
    }



    public function soumettre(Request $request)
    {
        // Récupérer les modifications
        $modifications = $request->input('modifications');
        $compte = Personnel::where('email', session()->get('connexion'))->first();
    
        // Vérifier si l'utilisateur existe
        if (!$compte) {
            return redirect()->route('inventaire')->with('error', 'Utilisateur non trouvé.');
        }
    
        // Vérifier si des modifications ont été soumises
        if (empty($modifications['produit'])) {
            return redirect()->route('inventaire')->with('error', 'Aucune modification détectée.');
        }
    
        try {
            // Création de l'inventaire
            $inventaire = new Inventaire();
            $inventaire->idPersonnel = $compte->idPersonnel;
            $inventaire->status = 'En attente';
            $inventaire->dateSoumission = now();
            $inventaire->save();
    
            $hasModifications = false;
    
            // Parcourir les produits modifiés
            foreach ($modifications['produit'] as $idProduit => $produitData) {
                // Vérifier si la nouvelle quantité est définie et différente de l'ancienne
                if (isset($produitData['nouvelle_quantite'])) {
                    $produit = Produit::find($idProduit);
    
                    // Convertir les quantités en entiers pour la comparaison
                    $ancienneQuantite = (int)$produit->quantite;
                    $nouvelleQuantite = (int)$produitData['nouvelle_quantite'];
    
                    if ($produit && $ancienneQuantite != $nouvelleQuantite) {
                        $hasModifications = true;
    
                        // Enregistrer la modification dans l'inventaire détail
                        InventaireDetail::create([
                            'idInventaire' => $inventaire->idInventaire,
                            'idProduit' => $produit->idProduit,
                            'ancienne_quantite' => $ancienneQuantite,
                            'nouvelle_quantite' => $nouvelleQuantite,
                        ]);
                    }
                }
            }
    
            // Vérifier si au moins une modification a été enregistrée
            if (!$hasModifications) {
                // Supprimer l'inventaire créé car aucune modification n'a été enregistrée
                $inventaire->delete();
                return redirect()->back()->withErrors("Veuillez modifier au moins un produit avant de soumettre")->withInput();

            }
    
            // Rediriger avec un message de succès
            session()->flash('success', 'Inventaire soumis avec succès.');
            return redirect()->route('inventaire')->withInput();
    
        } catch (\Exception $e) {
            // En cas d'erreur, rediriger avec un message d'erreur
            return redirect()->route('inventaire')->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }

    public function details($idInventaire)
    {
        // Récupère l'inventaire avec les détails associés
        $inventaire = Inventaire::with('details')
            ->where('idInventaire', $idInventaire)
            ->first();
    
        // Passe les données à la vue
        return view('details', [
            'inventaire' => $inventaire,
            'details' => $inventaire->details,
        ]);
    }
    
        public function valider($idInventaire)
    {
        $inventaire = Inventaire::find($idInventaire);

        try {
            // Récupération des détails de l'inventaire
            $details = InventaireDetail::where('idInventaire', $idInventaire)->get();

            foreach ($details as $detail) {
                $produit = Produit::find($detail->idProduit);
                if ($produit) {
                    // Mise à jour de la quantité du produit
                    $produit->quantite = $detail->nouvelle_quantite;
                    $produit->save();
                }
            }

           
            $inventaire->delete();
            return redirect()->route('inventaire')->with('success', 'Inventaire validée avec succès.');

        } catch (\Exception $e) {
       
            return redirect()->route('inventaire')->with('error', 'Erreur lors de la validation : ' . $e->getMessage());
        }
    }

    public function rejeter($idInventaire){
        $inventaire = Inventaire::find($idInventaire);
        $inventaire->delete();
        return redirect()->route('inventaire')->with('success', 'Inventaire rejetée avec succès.');

    }

    public function getInventaire(){
        $inventaire=Inventaire::where('status','En attente') ->orderBy('dateSoumission', 'desc')
        ->with('personnel') 
        ->get();

        return response()->json($inventaire);
    }


}
