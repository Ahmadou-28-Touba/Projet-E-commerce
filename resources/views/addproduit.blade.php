@extends('template')
@section('content')
    <form action="{{ route('produit.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('post')
        <label>Nom</label>
        <input type="text" class="form-control" name="nom" value="{{old('nom')}}">
        @error('nom')
        <span class="text-danger">{{$message}}</span>
        @enderror

        <label>Description</label>
        <input type="text" class="form-control" name="description" value="{{old('description')}}">
        @error('description')
        <span class="text-danger">{{$message}}</span>
        @enderror

        <label>Prix</label>
        <input type="text" class="form-control" name="prix" value="{{old('prix')}}">
        @error('prix')
        <span class="text-danger">{{$message}}</span>
        @enderror

        <label>Stock</label>
        <input type="text" class="form-control" name="stock" value="{{old('stock')}}">
        @error('stock')
        <span class="text-danger">{{$message}}</span>
        @enderror

        <label>Image</label>
        <input type="file" class="form-control" name="image">
        @error('image')
        <span class="text-danger">{{$message}}</span>
        @enderror

        <label>Categorie_Id</label>
        <select class="form-control" name="categorie_id">
            <option value="">-- Sélectionnez une catégorie --</option>
            @foreach($categories as $categorie)
                <option value="{{ $categorie->id }}" {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>
                    {{ $categorie->nom }}
                </option>
            @endforeach
        </select>
        @error('categorie_id')
        <span class="text-danger">{{$message}}</span>
        @enderror

        <button type="submit">Valider</button>
    </form>
@endsection
