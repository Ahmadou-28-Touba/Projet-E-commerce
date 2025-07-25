@extends('template')
@section('content')

    <a class="btn btn-success mb-3" href="{{ route('produit.create') }}">Add</a>

    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Description</th>
            <th>Prix</th>
            <th>Stock</th>
            <th>Image</th>
            <th>Catégorie</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($produits as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->nom }}</td>
                <td>{{ $p->description }}</td>
                <td>{{ $p->prix }} FCFA</td>
                <td>{{ $p->stock }}</td>
                <td>
                    <img src="{{ asset('images/produits/' . $p->image) }}" alt="Image du produit" width="80">
                </td>
                <td>{{ $p->categorie_id }}</td>
                <td>
                    <form action="{{ route('produit.destroy', $p->id) }}" method="post" style="display:inline-block;">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</button>
                    </form>
                    <a href="{{ route('produit.edit', $p->id) }}" class="btn btn-primary btn-sm">Modifier</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $produits->links() }}
    </div>

@endsection
