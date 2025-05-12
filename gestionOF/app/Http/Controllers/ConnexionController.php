<?php

namespace App\Http\Controllers;
use App\Models\Personnel;

use Firebase\JWT\JWT;
use Illuminate\Http\Request;

class ConnexionController extends Controller
{
    public function index($messagesErreur=[])
    {
        return view('connexion')->with('messagesErreur', $messagesErreur);
    }

    public function validationConnexion(Request $request){
        $messagesErreur = [];
        $validationFormulaire = false;
        $compte = Personnel::where('email', $request->email)->first();
        if ($compte) {
            if(password_verify($request->mdp, $compte->mdp)) {
                if($request->role==$compte->role){
                    $validationFormulaire = true;
                    session()->regenerate();
                    session()->put('connexion', $compte->email);
                    session()->put('role', $compte->role);
                }else{
                    $messagesErreur[] = "Role non conforme";
                    $validationFormulaire = false;
                }
                
            }else{
                $messagesErreur[] = "mot de passe incorrect";
                $validationFormulaire = false;
            }
        }else{
            $messagesErreur[] = "vous n'avez pas un compte";
            $validationFormulaire = false;
           
        }

        if($validationFormulaire === false){
            return $this->index($messagesErreur);
        }else{

            $cle = 'T3mUjGjhC6WuxyNGR2rkUt2uQgrlFUHx';
            $payload = [
                'name' => $compte->email,
                'sub' => $compte->idPersonnel,
                'iat' => time(),
                'exp' => time() + (60 * 60 * 2)
            ];
            $jwt = JWT::encode($payload, $cle, 'HS256');
            $timestamp30jours = time() + (60 * 60 * 24 * 30);
            setcookie("auth", $jwt, $timestamp30jours);

            if ($compte->role === 'Technicien') {
                return redirect()->route('of');
            } elseif ($compte->role === 'Superviseur') {
                return redirect()->route('accueil');
            }
        }

    }

    public function deconnexion()
    {
        session()->forget('connexion');
        session()->forget('role');
        setcookie('auth', '', time() - 3600); // Supprime le cookie d'authentification
        return redirect()->route('connexion')->with('messagesErreur', ['Vous avez été déconnecté avec succès.']);
    }
    

}
