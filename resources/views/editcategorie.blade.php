@extends('template')
@section('content')
<form action="{{ route('updatecategorie', $categorie->id) }}" method="post">
    @csrf
    @method('put')
    <label>Nom</label>
    <input type="text" class="form-control" name="nom" value="{{ old('nom', $categorie->nom) }}">
    @error('nom')
    <span class="text-danger">{{$message}}</span>
    @enderror
    <button type="submit" class="btn btn-primary">Modifier</button>
    <a href="{{ route('listecategorie') }}" class="btn btn-secondary">Annuler</a>
</form>
@endsection 