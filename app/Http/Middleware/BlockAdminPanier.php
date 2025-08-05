<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockAdminPanier
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si l'utilisateur est connecté et est admin
        if (auth()->check() && auth()->user()->isAdmin()) {
            // Bloquer l'accès au panier et aux commandes pour les admins
            if ($request->is('panier*') || $request->is('commande*') || $request->is('commandes*')) {
                return redirect()->route('admin.dashboard')
                    ->with('warning', 'En tant qu\'administrateur, vous ne pouvez pas accéder au panier ou passer des commandes. Utilisez l\'interface d\'administration pour gérer les commandes des clients.');
            }
        }

        return $next($request);
    }
}
