<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Récupérer l'email de la session
        $email = Session::get('connexion');

        if (!$email) {
            return redirect()->route('connexion')->with('messagesErreur', ['Vous devez être connecté.']);
        }

        // Récupérer l'utilisateur en fonction de l'email
        $user = \App\Models\Personnel::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('connexion')->with('messagesErreur', ['Utilisateur introuvable.']);
        }

        // Si le rôle est "Superviseur", accès à tout
        if ($user->role === 'Superviseur') {
            return $next($request);
        }

        // Si le rôle attendu ne correspond pas, refuser l'accès
        if ($user->role !== $role) {
            return redirect()->route('connexion')->with('messagesErreur', ['Accès interdit pour votre rôle.']);
        }

        return $next($request);
    }
}
