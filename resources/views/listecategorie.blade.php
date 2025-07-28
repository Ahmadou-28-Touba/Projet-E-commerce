@extends('template')
@section('content')

<a class="btn btn-success" href="{{route('addcategorie')}}">Add</a>

@if(session('message'))
    <div class="alert alert-success">{{session('message')}}</div>
@endif

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Actions</th>
    </tr>
    @foreach($categories as $c)
        <tr>
            <td>{{ $c->id }}</td>
            <td>{{ $c->nom }}</td>
            <td>
                <form action="{{route('deletecategorie',['id'=> $c->id])}}" method="post">
                    @csrf
                    @method('delete')
                    <button class="btn btn-danger">Supprimer</button>
                </form>

                <a href="{{ route('editcategorie', $c->id) }}" class="btn btn-primary">Modifier</a>
            </td>
        </tr>
    @endforeach
</table>
    {{$categories->links()}}
@endsection

