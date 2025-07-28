<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categorie::paginate(3);
        return view('listeCategorie',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('addcategorie');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           'nom' => 'required|min:3',
        ]);
        $categorie = new Categorie();
        $categorie->nom =$request['nom'];
        $categorie->save();
        return redirect('/listecategorie')->with('message','Categorie ajouté avec succes!');
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
        $categorie = Categorie::findOrFail($id);
        return view('editcategorie', compact('categorie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
           'nom' => 'required|min:3',
        ]);
        
        $categorie = Categorie::findOrFail($id);
        $categorie->nom = $request['nom'];
        $categorie->save();
        
        return redirect('/listecategorie')->with('message', 'Catégorie modifiée avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Categorie::destroy($id);
        return redirect('/listecategorie')->with('message','Categorie supprime avec succes');
    }
}
