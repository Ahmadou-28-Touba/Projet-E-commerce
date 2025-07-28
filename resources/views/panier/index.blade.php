@extends('template')
@section('content')

<div class="container">
    <h1 class="mb-4">Mon Panier</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($paniers->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Prix unitaire</th>
                        <th>Quantité</th>
                        <th>Prix total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paniers as $panier)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($panier->produit->image)
                                        <img src="{{ asset('images/produits/' . $panier->produit->image) }}" 
                                             alt="{{ $panier->produit->nom }}" 
                                             style="width: 50px; height: 50px; object-fit: cover;" 
                                             class="me-3">
                                    @endif
                                    <div>
                                        <h6 class="mb-0">{{ $panier->produit->nom }}</h6>
                                        <small class="text-muted">{{ $panier->produit->categorie->nom }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ number_format($panier->produit->prix, 0, ',', ' ') }} FCFA</td>
                            <td>
                                <form action="{{ route('panier.update', $panier->id) }}" method="POST" class="d-flex align-items-center">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="quantite" value="{{ $panier->quantite }}" 
                                           min="1" max="{{ $panier->produit->stock }}" 
                                           class="form-control" style="width: 80px;">
                                    <button type="submit" class="btn btn-sm btn-outline-primary ms-2">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </form>
                            </td>
                            <td>{{ number_format($panier->quantite * $panier->produit->prix, 0, ',', ' ') }} FCFA</td>
                            <td>
                                <form action="{{ route('panier.remove', $panier->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Êtes-vous sûr de vouloir retirer ce produit ?')">
                                        <i class="fas fa-trash"></i> Retirer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <form action="{{ route('panier.clear') }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-warning" 
                            onclick="return confirm('Êtes-vous sûr de vouloir vider votre panier ?')">
                        <i class="fas fa-trash"></i> Vider le panier
                    </button>
                </form>
            </div>
            <div class="col-md-6 text-end">
                <h4>Total : <span class="text-primary">{{ number_format($total, 0, ',', ' ') }} FCFA</span></h4>
                <a href="{{ route('commandes.create') }}" class="btn btn-success btn-lg">
                    <i class="fas fa-shopping-cart"></i> Passer la commande
                </a>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
            <h3>Votre panier est vide</h3>
            <p class="text-muted">Ajoutez des produits à votre panier pour commencer vos achats.</p>
            <a href="{{ route('catalogue') }}" class="btn btn-primary">
                <i class="fas fa-shopping-bag"></i> Voir le catalogue
            </a>
        </div>
    @endif
</div>

@endsection 