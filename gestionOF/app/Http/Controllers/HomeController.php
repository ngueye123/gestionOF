<?php

namespace App\Http\Controllers;

use App\Models\Recette;
use App\Models\Produit;
use App\Models\OrdreFabrication;

class HomeController extends Controller
{
    public function index()
    {
        if (!session()->has('connexion')) {
            return redirect()->route('connexion');
        }
    
        $ofEnCours = OrdreFabrication::where('statut', 'en cours')
            ->orderBy('dateDebut', 'desc')
            ->with('personnel')
            ->get();
    
        return view('accueil', compact('ofEnCours'));
    }

    public function getOfEnCours()
    {
        $ofEnCours = OrdreFabrication::where('status', 'en cours')
            ->orderBy('dateDebut', 'desc')
            ->with('personnel') 
            ->get();

        return response()->json($ofEnCours);
    }

}

