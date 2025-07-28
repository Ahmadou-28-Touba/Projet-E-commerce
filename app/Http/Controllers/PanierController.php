<?php

namespace App\Http\Controllers;

use App\Models\Panier;
use App\Models\Produit;
use Illuminate\Http\Request;

class PanierController extends Controller
{
    public function index()
    {
        $paniers = Panier::with('produit')->where('user_id', auth()->id())->get();
        $total = $paniers->sum(function($panier) {
            return $panier->quantite * $panier->produit->prix;
        });
        
        return view('panier.index', compact('paniers', 'total'));
    }

    public function add(Request $request)
    {
        try {
            $request->validate([
                'produit_id' => 'required|exists:produits,id',
                'quantite' => 'required|integer|min:1'
            ]);

            $produit = Produit::findOrFail($request->produit_id);
            
            // Vérifier le stock
            if ($produit->stock < $request->quantite) {
                return back()->with('error', 'Stock insuffisant pour ce produit. Stock disponible : ' . $produit->stock);
            }

            // Vérifier si le produit est déjà dans le panier
            $panier = Panier::where('user_id', auth()->id())
                            ->where('produit_id', $request->produit_id)
                            ->first();

            if ($panier) {
                // Vérifier si la nouvelle quantité totale ne dépasse pas le stock
                $nouvelleQuantite = $panier->quantite + $request->quantite;
                if ($produit->stock < $nouvelleQuantite) {
                    return back()->with('error', 'Stock insuffisant. Vous avez déjà ' . $panier->quantite . ' de ce produit dans votre panier.');
                }
                
                $panier->quantite = $nouvelleQuantite;
                $panier->save();
                
                return back()->with('success', 'Quantité mise à jour dans le panier !');
            } else {
                Panier::create([
                    'user_id' => auth()->id(),
                    'produit_id' => $request->produit_id,
                    'quantite' => $request->quantite
                ]);
                
                return back()->with('success', 'Produit ajouté au panier avec succès !');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de l\'ajout au panier.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'quantite' => 'required|integer|min:1'
            ]);

            $panier = Panier::where('user_id', auth()->id())->findOrFail($id);
            $produit = $panier->produit;

            if ($produit->stock < $request->quantite) {
                return back()->with('error', 'Stock insuffisant pour ce produit. Stock disponible : ' . $produit->stock);
            }

            $panier->quantite = $request->quantite;
            $panier->save();

            return back()->with('success', 'Quantité mise à jour avec succès !');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour.');
        }
    }

    public function remove($id)
    {
        try {
            $panier = Panier::where('user_id', auth()->id())->findOrFail($id);
            $produitNom = $panier->produit->nom;
            $panier->delete();

            return back()->with('success', 'Produit "' . $produitNom . '" retiré du panier !');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de la suppression.');
        }
    }

    public function clear()
    {
        try {
            Panier::where('user_id', auth()->id())->delete();
            return back()->with('success', 'Panier vidé avec succès !');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors du vidage du panier.');
        }
    }
}
