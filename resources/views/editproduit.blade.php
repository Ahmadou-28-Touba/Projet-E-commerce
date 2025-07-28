@extends('template')
@section('content')
    <form action="{{ route('produit.update', $produit->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <label>Nom</label>
        <input type="text" class="form-control" name="nom" value="{{ old('nom', $produit->nom) }}">
        @error('nom')
        <span class="text-danger">{{$message}}</span>
        @enderror

        <label>Description</label>
        <input type="text" class="form-control" name="description" value="{{ old('description', $produit->description) }}">
        @error('description')
        <span class="text-danger">{{$message}}</span>
        @enderror

        <label>Prix</label>
        <input type="text" class="form-control" name="prix" value="{{ old('prix', $produit->prix) }}">
        @error('prix')
        <span class="text-danger">{{$message}}</span>
        @enderror

        <label>Stock</label>
        <input type="text" class="form-control" name="stock" value="{{ old('stock', $produit->stock) }}">
        @error('stock')
        <span class="text-danger">{{$message}}</span>
        @enderror

        <label>Image actuelle</label>
        @if($produit->image)
            <img src="{{ asset('images/produits/' . $produit->image) }}" alt="Image actuelle" width="100" class="mb-2">
        @endif
        <input type="file" class="form-control" name="image">
        <small class="text-muted">Laissez vide pour conserver l'image actuelle</small>
        @error('image')
        <span class="text-danger">{{$message}}</span>
        @enderror

        <label>Categorie_Id</label>
        <select class="form-control" name="categorie_id">
            <option value="">-- Sélectionnez une catégorie --</option>
            @foreach($categories as $categorie)
                <option value="{{ $categorie->id }}" {{ (old('categorie_id', $produit->categorie_id) == $categorie->id) ? 'selected' : '' }}>
                    {{ $categorie->nom }}
                </option>
            @endforeach
        </select>
        @error('categorie_id')
        <span class="text-danger">{{$message}}</span>
        @enderror

        <button type="submit" class="btn btn-primary">Modifier</button>
        <a href="{{ route('produits.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
@endsection 