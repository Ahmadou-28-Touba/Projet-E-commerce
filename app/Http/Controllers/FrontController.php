<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $produits = Produit::with('categorie')->paginate(12);
        $categories = Categorie::all();
        return view('front.catalogue', compact('produits', 'categories'));
    }

    public function show($id)
    {
        $produit = Produit::with('categorie')->findOrFail($id);
        return view('front.produit', compact('produit'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $categorie_id = $request->get('categorie_id');
        
        $produits = Produit::with('categorie');
        
        if ($query) {
            $produits = $produits->where('nom', 'like', "%{$query}%")
                                 ->orWhere('description', 'like', "%{$query}%");
        }
        
        if ($categorie_id) {
            $produits = $produits->where('categorie_id', $categorie_id);
        }
        
        $produits = $produits->paginate(12);
        $categories = Categorie::all();
        
        return view('front.catalogue', compact('produits', 'categories', 'query', 'categorie_id'));
    }
}
