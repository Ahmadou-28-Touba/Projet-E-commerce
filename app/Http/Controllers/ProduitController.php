<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produits = Produit::paginate(3);
        return view('listeproduits', compact('produits'));
    }

    /**
     * Show the form for creating a new resource.
     */

        public function create()
    {
        $categories = Categorie::all(); // récupère toutes les catégories
        return view('addproduit', compact('categories')); // passe $categories à la vue
    }



    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'description' => 'required',
            'prix' => 'required',
            'stock' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categorie_id' => 'required',
        ]);

        $produit = new Produit();
        $produit->nom = $request['nom'];
        $produit->description = $request['description'];
        $produit->prix = $request['prix'];
        $produit->stock = $request['stock'];
        $produit->categorie_id = $request['categorie_id'];

        // Gestion de l'upload image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/produits'), $filename);
            $produit->image = $filename;
        }

        $produit->save();

        return redirect('/listeproduits')->with('message', 'Produit ajouté avec succès !');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Produit::destroy($id);
        return redirect('/listeproduits')->with('message', 'Produit supprimé avec succès');
    }
}
