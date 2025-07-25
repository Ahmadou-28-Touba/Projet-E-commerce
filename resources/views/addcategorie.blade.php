@extends('template')
@section('content')
<form action="{{ route('savecategorie') }}" method="post">
    @csrf
    @method('post')
    <label>Nom</label>
    <input type="text" class="form-control" name="nom" value="{{old('nom')}}">
    @error('nom')
    <span class="text-danger">{{$message}}</span>
    @enderror
    <button type="submit">Valider</button>
</form>
@endsection

