@extends('template')
@section('title', 'Détails de la commande')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('commandes.index') }}">Mes Commandes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Commande #{{ $commande->id }}</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">
                        <i class="fas fa-shopping-bag"></i> Commande #{{ $commande->id }}
                    </h2>
                </div>
                <div class="card-body">
                    <!-- Informations de la commande -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5><i class="fas fa-calendar"></i> Informations de la commande</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Date de commande :</strong></td>
                                    <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Statut :</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $commande->statut === 'en_attente' ? 'warning' : ($commande->statut === 'expediee' ? 'info' : ($commande->statut === 'livree' ? 'success' : 'danger')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Mode de paiement :</strong></td>
                                    <td>{{ $commande->mode_paiement === 'avant_livraison' ? 'Paiement avant livraison' : 'Paiement après livraison' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Statut du paiement :</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $commande->paiement_paye ? 'success' : 'warning' }}">
                                            {{ $commande->paiement_paye ? 'Payé' : 'En attente' }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="fas fa-map-marker-alt"></i> Adresse de livraison</h5>
                            <div class="border rounded p-3">
                                <strong>{{ $commande->nom_destinataire }}</strong><br>
                                {{ $commande->adresse_livraison }}<br>
                                {{ $commande->ville_livraison }}, {{ $commande->code_postal_livraison }}<br>
                                {{ $commande->pays_livraison }}<br>
                                <strong>Téléphone :</strong> {{ $commande->telephone_livraison }}
                            </div>
                        </div>
                    </div>

                    <!-- Produits commandés -->
                    <div class="row">
                        <div class="col-12">
                            <h5><i class="fas fa-box"></i> Produits commandés</h5>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Produit</th>
                                            <th>Prix unitaire</th>
                                            <th>Quantité</th>
                                            <th>Prix total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($commande->produits as $produit)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($produit->image)
                                                            <img src="{{ asset('images/produits/' . $produit->image) }}" 
                                                                 alt="{{ $produit->nom }}" 
                                                                 style="width: 50px; height: 50px; object-fit: cover;" 
                                                                 class="me-3">
                                                        @endif
                                                        <div>
                                                            <h6 class="mb-0">{{ $produit->nom }}</h6>
                                                            <small class="text-muted">{{ $produit->categorie->nom }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ number_format($produit->pivot->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                                                <td>{{ $produit->pivot->quantite }}</td>
                                                <td>{{ number_format($produit->pivot->prix_total, 0, ',', ' ') }} FCFA</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-primary">
                                            <td colspan="3" class="text-end"><strong>Total :</strong></td>
                                            <td><strong>{{ number_format($commande->total, 0, ',', ' ') }} FCFA</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('commandes.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Retour aux commandes
                                </a>
                                <div>
                                    @if($commande->statut === 'livree' && !$commande->paiement_paye && $commande->mode_paiement === 'apres_livraison')
                                        <button class="btn btn-success" disabled>
                                            <i class="fas fa-check"></i> Paiement en attente
                                        </button>
                                    @endif
                                    <a href="#" class="btn btn-primary">
                                        <i class="fas fa-download"></i> Télécharger la facture
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