<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\Personnel;

class Authentification
{
    public function handle(Request $request, Closure $next): Response
    {
        if (isset($_COOKIE['auth'])) {
            $cle = "T3mUjGjhC6WuxyNGR2rkUt2uQgrlFUHx";
            try {
                // Décoder le JWT
                $jwt = JWT::decode($_COOKIE['auth'], new Key($cle, 'HS256'));
                $infosAuth = (array) $jwt;

                // Vérifier l'expiration du token
                if ($jwt->exp < time()) {
                    setcookie('auth', '', time() - 3600); // Supprime le cookie expiré
                    return redirect()->route('connexion');
                }

                // Vérification de l'existence de l'utilisateur
                if (Personnel::where('idPersonnel', $infosAuth['sub'])->exists()) {
                    return $next($request);

                    return $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                    ->header('Cache-Control', 'post-check=0, pre-check=0', false)
                    ->header('Pragma', 'no-cache')
                    ->header('Expires', 'Thu, 01 Jan 1970 00:00:00 GMT');
                }
            } catch (\Exception $e) {
                // Supprime le cookie invalide ou en cas d'erreur
                setcookie('auth', '', time() - 3600);
            }
        }

        // Redirection vers la page de connexion si non authentifié
        return redirect()->route('connexion');
    }
}
