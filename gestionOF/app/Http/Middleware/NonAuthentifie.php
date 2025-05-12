<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class NonAuthentifie
{
    public function handle(Request $request, Closure $next): Response
    {
        if (isset($_COOKIE['auth'])) {
            $cle = "T3mUjGjhC6WuxyNGR2rkUt2uQgrlFUHx";
            try {
                $jwt = JWT::decode($_COOKIE['auth'], new Key($cle, 'HS256'));
                $infosAuth = (array) $jwt;
                return redirect()->route('accueil');
            } catch (\Exception $e) {
                setcookie('auth', '', time() - 3600); // Supprime le cookie invalide
            }
        }
        return $next($request);
    }
}
