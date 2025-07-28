@extends('template')
@section('title', 'Administration - Tableau de bord')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">
                <i class="fas fa-tachometer-alt"></i> Tableau de bord - Administration
            </h1>

            <!-- Statistiques générales -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0">{{ $totalCommandes }}</h4>
                                    <p class="mb-0">Commandes</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-shopping-bag fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0">{{ $totalProduits }}</h4>
                                    <p class="mb-0">Produits</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-box fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0">{{ $totalClients }}</h4>
                                    <p class="mb-0">Clients</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-users fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0">{{ number_format($chiffreAffaires, 0, ',', ' ') }}</h4>
                                    <p class="mb-0">FCFA (CA)</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-money-bill-wave fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Commandes par statut -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-clock"></i> Commandes en attente</h5>
                        </div>
                        <div class="card-body text-center">
                            <h2 class="text-warning">{{ $commandesEnAttente }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-shipping-fast"></i> Commandes expédiées</h5>
                        </div>
                        <div class="card-body text-center">
                            <h2 class="text-info">{{ $commandesExpediees }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-check-circle"></i> Commandes livrées</h5>
                        </div>
                        <div class="card-body text-center">
                            <h2 class="text-success">{{ $commandesLivrees }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Commandes récentes et produits populaires -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-list"></i> Commandes récentes</h5>
                        </div>
                        <div class="card-body">
                            @if($commandesRecentes->count() > 0)
                                <div class="list-group list-group-flush">
                                    @foreach($commandesRecentes as $commande)
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>Commande #{{ $commande->id }}</strong><br>
                                                <small class="text-muted">{{ $commande->user->name }} - {{ $commande->created_at->format('d/m/Y H:i') }}</small>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge bg-{{ $commande->statut === 'en_attente' ? 'warning' : ($commande->statut === 'expediee' ? 'info' : 'success') }}">
                                                    {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                                                </span><br>
                                                <small class="text-muted">{{ number_format($commande->total, 0, ',', ' ') }} FCFA</small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted text-center">Aucune commande récente</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-star"></i> Produits populaires</h5>
                        </div>
                        <div class="card-body">
                            @if($produitsPopulaires->count() > 0)
                                <div class="list-group list-group-flush">
                                    @foreach($produitsPopulaires as $produit)
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $produit->nom }}</strong><br>
                                                <small class="text-muted">{{ $produit->categorie->nom }}</small>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge bg-primary">{{ $produit->commandes_count }} commande(s)</span><br>
                                                <small class="text-muted">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted text-center">Aucun produit populaire</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-bolt"></i> Actions rapides</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <a href="{{ route('admin.commandes.index') }}" class="btn btn-primary w-100 mb-2">
                                        <i class="fas fa-shopping-bag"></i> Gérer les commandes
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('produits.index') }}" class="btn btn-success w-100 mb-2">
                                        <i class="fas fa-box"></i> Gérer les produits
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('listecategorie') }}" class="btn btn-info w-100 mb-2">
                                        <i class="fas fa-tags"></i> Gérer les catégories
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('catalogue') }}" class="btn btn-secondary w-100 mb-2">
                                        <i class="fas fa-eye"></i> Voir le catalogue
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection 