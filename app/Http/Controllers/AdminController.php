<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Produit;
use App\Models\User;
use App\Models\Categorie;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Statistiques générales
        $totalCommandes = Commande::count();
        $totalProduits = Produit::count();
        $totalClients = User::where('is_admin', false)->count();
        $totalCategories = Categorie::count();

        // Chiffre d'affaires
        $chiffreAffaires = Commande::where('statut_paiement', 'paye')->sum('total');

        // Commandes récentes
        $commandesRecentes = Commande::with(['user', 'produits'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Produits les plus vendus
        $produitsPopulaires = Produit::withCount('commandes')
            ->orderBy('commandes_count', 'desc')
            ->limit(5)
            ->get();

        // Commandes par statut
        $commandesEnAttente = Commande::where('statut', 'en_attente')->count();
        $commandesExpediees = Commande::where('statut', 'expediee')->count();
        $commandesLivrees = Commande::where('statut', 'livree')->count();

        return view('admin.dashboard', compact(
            'totalCommandes',
            'totalProduits',
            'totalClients',
            'totalCategories',
            'chiffreAffaires',
            'commandesRecentes',
            'produitsPopulaires',
            'commandesEnAttente',
            'commandesExpediees',
            'commandesLivrees'
        ));
    }
}
