@extends('template')
@section('title', $produit->nom)
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-6">
            @if($produit->image)
                <img src="{{ asset('images/produits/' . $produit->image) }}" class="img-fluid rounded shadow" alt="{{ $produit->nom }}">
            @else
                <div class="bg-light d-flex align-items-center justify-content-center rounded shadow" style="height: 400px;">
                    <i class="fas fa-image text-muted" style="font-size: 5rem;"></i>
                </div>
            @endif
        </div>
        <div class="col-md-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('catalogue') }}">Catalogue</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('search') }}?categorie_id={{ $produit->categorie_id }}">{{ $produit->categorie->nom }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $produit->nom }}</li>
                </ol>
            </nav>

            <h1 class="display-5 mb-3">{{ $produit->nom }}</h1>
            <p class="text-muted mb-3">
                <i class="fas fa-tag"></i> Catégorie : {{ $produit->categorie->nom }}
            </p>
            
            <div class="mb-4">
                <h2 class="text-primary display-6">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</h2>
            </div>

            <div class="mb-4">
                <span class="badge bg-{{ $produit->stock > 0 ? 'success' : 'danger' }} fs-6">
                    @if($produit->stock > 0)
                        <i class="fas fa-check-circle"></i> {{ $produit->stock }} disponible(s)
                    @else
                        <i class="fas fa-times-circle"></i> Rupture de stock
                    @endif
                </span>
            </div>

            <div class="mb-4">
                <h5><i class="fas fa-info-circle"></i> Description :</h5>
                <p class="text-muted">{{ $produit->description }}</p>
            </div>

            @if($produit->stock > 0)
                @auth
                    <form action="{{ route('panier.add') }}" method="POST" class="mb-4">
                        @csrf
                        <input type="hidden" name="produit_id" value="{{ $produit->id }}">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="quantite" class="form-label">
                                    <i class="fas fa-sort-numeric-up"></i> Quantité :
                                </label>
                                <input type="number" name="quantite" id="quantite" class="form-control" value="1" min="1" max="{{ $produit->stock }}">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-success btn-lg w-100">
                                    <i class="fas fa-cart-plus"></i> Ajouter au panier
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="alert alert-warning mb-4">
                        <i class="fas fa-exclamation-triangle"></i> 
                        <strong>Connexion requise :</strong> Vous devez être connecté pour ajouter des produits au panier.
                        <div class="mt-2">
                            <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-sign-in-alt"></i> Se connecter
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-user-plus"></i> S'inscrire
                            </a>
                        </div>
                    </div>
                @endauth
            @else
                <div class="alert alert-danger mb-4">
                    <i class="fas fa-exclamation-circle"></i> 
                    <strong>Produit indisponible :</strong> Ce produit est actuellement en rupture de stock.
                </div>
            @endif

            <div class="mt-4">
                <a href="{{ route('catalogue') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour au catalogue
                </a>
                @auth
                    <a href="{{ route('panier.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-shopping-cart"></i> Voir mon panier
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>

@endsection 