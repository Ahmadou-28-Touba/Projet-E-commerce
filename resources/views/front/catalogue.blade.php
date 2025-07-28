@extends('template')
@section('title', 'Catalogue')
@section('content')

<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-4 text-center mb-4">
                <i class="fas fa-th-large"></i> Catalogue des Produits
            </h1>
        </div>
    </div>

    <!-- Formulaire de recherche -->
    <div class="row mb-4">
        <div class="col-md-8">
            <form action="{{ route('search') }}" method="GET" class="d-flex">
                <input type="text" name="q" class="form-control me-2" placeholder="Rechercher un produit..." value="{{ $query ?? '' }}">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Rechercher
                </button>
            </form>
        </div>
        <div class="col-md-4">
            <form action="{{ route('search') }}" method="GET" class="d-flex">
                <select name="categorie_id" class="form-control me-2">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $categorie)
                        <option value="{{ $categorie->id }}" {{ (request('categorie_id') == $categorie->id) ? 'selected' : '' }}>
                            {{ $categorie->nom }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-secondary">
                    <i class="fas fa-filter"></i> Filtrer
                </button>
            </form>
        </div>
    </div>

    <!-- Affichage des produits -->
    <div class="row">
        @forelse($produits as $produit)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    @if($produit->image)
                        <img src="{{ asset('images/produits/' . $produit->image) }}" class="card-img-top" alt="{{ $produit->nom }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-image text-muted" style="font-size: 3rem;"></i>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $produit->nom }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($produit->description, 100) }}</p>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="h5 text-primary mb-0">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</span>
                                <span class="badge bg-{{ $produit->stock > 0 ? 'success' : 'danger' }}">
                                    @if($produit->stock > 0)
                                        <i class="fas fa-check-circle"></i> {{ $produit->stock }} disponible(s)
                                    @else
                                        <i class="fas fa-times-circle"></i> Rupture de stock
                                    @endif
                                </span>
                            </div>
                            <p class="card-text">
                                <small class="text-muted">
                                    <i class="fas fa-tag"></i> {{ $produit->categorie->nom }}
                                </small>
                            </p>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('produit.show', $produit->id) }}" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-eye"></i> Voir détails
                            </a>
                            @if($produit->stock > 0)
                                @auth
                                    <form action="{{ route('panier.add') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="produit_id" value="{{ $produit->id }}">
                                        <input type="hidden" name="quantite" value="1">
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-cart-plus"></i> Ajouter au panier
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-sign-in-alt"></i> Connectez-vous pour acheter
                                    </a>
                                @endauth
                            @else
                                <button class="btn btn-secondary btn-sm" disabled>
                                    <i class="fas fa-ban"></i> Indisponible
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle"></i> Aucun produit trouvé.
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($produits->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $produits->links() }}
        </div>
    @endif
</div>

@endsection 