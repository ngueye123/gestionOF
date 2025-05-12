<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;
use Carbon\Carbon;

class LogController extends Controller
{
  

    public function index(Request $request)
    {
        $messagesErreur = [];
        // Vérification si la date de début est supérieure à la date de fin
        if ($request->has('dateDebut') && $request->has('dateFin')) {
            $dateDebut = Carbon::parse($request->dateDebut);
            $dateFin = Carbon::parse($request->dateFin);
    
            if ($dateDebut->gt($dateFin)) { // Si la date de début est après la date de fin
                $messagesErreur[] = "La date de début ne peut pas être supérieure à la date de fin.";
                return redirect()->route('log')->with('messagesErreur', $messagesErreur);
            }
        }
    
        // Démarre la requête de base
        $query = Log::with(['personnel', 'ordreFabrication']);
    
        // Filtrage par date de début et date de fin
        if ($request->has('dateDebut') && $request->has('dateFin')) {
            $dateDebut = Carbon::parse($request->dateDebut)->startOfDay();
            $dateFin = Carbon::parse($request->dateFin)->endOfDay();
            $query->whereBetween('dateTime', [$dateDebut, $dateFin]);
        }
    
        // Récupérer les logs après avoir appliqué les filtres
        $logs = $query->orderby('dateTime', 'desc')->get();
    
        // Vérification de la session
        if (session()->has('connexion')) {
            if (session()->get('role') == "Technicien") {
                $messagesErreur[] = "Connectez-vous en tant que Superviseur pour accéder à cette page";
                return view('connexion')->with('messagesErreur', $messagesErreur);
            }
        } else {
            return redirect()->route('connexion');
        }
    
        return view('log', compact('logs'));
    }
    

    
}
