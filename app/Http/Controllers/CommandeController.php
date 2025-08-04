<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Panier;
use App\Models\Produit;
use App\Mail\ConfirmationCommande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CommandeController extends Controller
{
    public function index()
    {
        $commandes = Commande::with('produits')->where('user_id', auth()->id())->orderBy('created_at', 'desc')->paginate(10);
        return view('commandes.index', compact('commandes'));
    }

    public function show($id)
    {
        $commande = Commande::with('produits')->where('user_id', auth()->id())->findOrFail($id);
        return view('commandes.show', compact('commande'));
    }

    public function create()
    {
        $paniers = Panier::with('produit')->where('user_id', auth()->id())->get();
        
        if ($paniers->isEmpty()) {
            return redirect()->route('panier.index')->with('error', 'Votre panier est vide.');
        }

        $total = $paniers->sum(function($panier) {
            return $panier->quantite * $panier->produit->prix;
        });

        return view('commandes.create', compact('paniers', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'adresse_livraison' => 'required|string',
            'telephone' => 'required|string',
            'mode_paiement' => 'required|in:avant_livraison,apres_livraison',
            'notes' => 'nullable|string'
        ]);

        $paniers = Panier::with('produit')->where('user_id', auth()->id())->get();
        
        if ($paniers->isEmpty()) {
            return redirect()->route('panier.index')->with('error', 'Votre panier est vide.');
        }

        $total = $paniers->sum(function($panier) {
            return $panier->quantite * $panier->produit->prix;
        });

        // Créer la commande avec statut de paiement en attente par défaut
        $commande = Commande::create([
            'user_id' => auth()->id(),
            'numero_commande' => Commande::genererNumeroCommande(),
            'total' => $total,
            'mode_paiement' => $request->mode_paiement,
            'statut_paiement' => 'en_attente', // Toujours en attente par défaut
            'adresse_livraison' => $request->adresse_livraison,
            'telephone' => $request->telephone,
            'notes' => $request->notes
        ]);

        // Ajouter les produits à la commande
        foreach ($paniers as $panier) {
            $commande->produits()->attach($panier->produit_id, [
                'quantite' => $panier->quantite,
                'prix_unitaire' => $panier->produit->prix,
                'prix_total' => $panier->quantite * $panier->produit->prix
            ]);

            // Mettre à jour le stock
            $produit = $panier->produit;
            $produit->stock -= $panier->quantite;
            $produit->save();
        }

        // Vider le panier
        Panier::where('user_id', auth()->id())->delete();

        return redirect()->route('commandes.show', $commande->id)
                        ->with('success', 'Commande passée avec succès ! L\'administrateur vérifiera le paiement.');
    }

    // Méthodes pour l'admin
    public function adminIndex()
    {
        $commandes = Commande::with(['user', 'produits'])->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.commandes.index', compact('commandes'));
    }

    public function adminShow($id)
    {
        $commande = Commande::with(['user', 'produits'])->findOrFail($id);
        return view('admin.commandes.show', compact('commande'));
    }

    public function updateStatut(Request $request, $id)
    {
        $request->validate([
            'statut' => 'required|in:en_attente,expediee,livree,annulee'
        ]);

        $commande = Commande::findOrFail($id);
        $commande->statut = $request->statut;
        $commande->save();

        Log::info('Statut commande mis à jour', [
            'commande_id' => $id,
            'ancien_statut' => $commande->getOriginal('statut'),
            'nouveau_statut' => $request->statut
        ]);

        return back()->with('success', 'Statut de la commande mis à jour !');
    }

    public function updatePaiement(Request $request, $id)
    {
        $request->validate([
            'statut_paiement' => 'required|in:en_attente,paye,non_paye'
        ]);

        $commande = Commande::findOrFail($id);
        $commande->statut_paiement = $request->statut_paiement;
        $commande->save();

        Log::info('Statut paiement mis à jour', [
            'commande_id' => $id,
            'ancien_statut_paiement' => $commande->getOriginal('statut_paiement'),
            'nouveau_statut_paiement' => $request->statut_paiement
        ]);

        return back()->with('success', 'Statut de paiement mis à jour !');
    }

    /**
     * Envoyer un email de confirmation de commande
     */
    public function envoyerEmailConfirmation($id)
    {
        $commande = Commande::with(['user', 'produits'])->findOrFail($id);
        
        try {
            Mail::to($commande->user->email)->send(new ConfirmationCommande($commande));
            
            Log::info('Email de confirmation envoyé', [
                'commande_id' => $id,
                'user_email' => $commande->user->email
            ]);
            
            return back()->with('success', 'Email de confirmation envoyé avec succès !');
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi de l\'email de confirmation', [
                'commande_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return back()->with('error', 'Erreur lors de l\'envoi de l\'email. Veuillez réessayer.');
        }
    }
} 