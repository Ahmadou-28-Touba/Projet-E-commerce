@extends('template')
@section('title', 'Administration - Détails Commande')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.commandes.index') }}">Administration - Commandes</a></li>
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
                    <!-- Informations du client -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5><i class="fas fa-user"></i> Informations du client</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Nom :</strong></td>
                                    <td>{{ $commande->user->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email :</strong></td>
                                    <td>{{ $commande->user->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Date de commande :</strong></td>
                                    <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="fas fa-cogs"></i> Gestion des statuts</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <form action="{{ route('admin.commandes.statut', $commande->id) }}" method="POST" class="mb-3">
                                        @csrf
                                        <input type="hidden" name="_method" value="PATCH">
                                        <div class="mb-2">
                                            <label for="statut" class="form-label">Statut de la commande</label>
                                            <select name="statut" id="statut" class="form-select">
                                                <option value="en_attente" {{ $commande->statut === 'en_attente' ? 'selected' : '' }}>En attente</option>
                                                <option value="expediee" {{ $commande->statut === 'expediee' ? 'selected' : '' }}>Expédiée</option>
                                                <option value="livree" {{ $commande->statut === 'livree' ? 'selected' : '' }}>Livrée</option>
                                                <option value="annulee" {{ $commande->statut === 'annulee' ? 'selected' : '' }}>Annulée</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm">Mettre à jour</button>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <form action="{{ route('admin.commandes.paiement', $commande->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="PATCH">
                                        <div class="mb-2">
                                            <label for="statut_paiement" class="form-label">Statut du paiement</label>
                                            <select name="statut_paiement" id="statut_paiement" class="form-select">
                                                <option value="en_attente" {{ $commande->statut_paiement === 'en_attente' ? 'selected' : '' }}>En attente</option>
                                                <option value="paye" {{ $commande->statut_paiement === 'paye' ? 'selected' : '' }}>Payé</option>
                                                <option value="non_paye" {{ $commande->statut_paiement === 'non_paye' ? 'selected' : '' }}>Non payé</option>
                                            </select>
                                            <small class="text-muted">Valeur actuelle: {{ $commande->statut_paiement }}</small>
                                        </div>
                                        <button type="submit" class="btn btn-success btn-sm">Mettre à jour</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informations de la commande -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5><i class="fas fa-calendar"></i> Informations de la commande</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Mode de paiement :</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $commande->mode_paiement === 'avant_livraison' ? 'primary' : 'warning' }}">
                                            {{ $commande->mode_paiement === 'avant_livraison' ? 'Paiement avant livraison' : 'Paiement après livraison' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Total :</strong></td>
                                    <td><strong>{{ number_format($commande->total, 0, ',', ' ') }} FCFA</strong></td>
                                </tr>
                                <tr>
                                    <td><strong>Notes :</strong></td>
                                    <td>{{ $commande->notes ?? 'Aucune note' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="fas fa-map-marker-alt"></i> Adresse de livraison</h5>
                            <div class="border rounded p-3">
                                <strong>{{ $commande->user->name }}</strong><br>
                                {{ $commande->adresse_livraison }}<br>
                                <strong>Téléphone :</strong> {{ $commande->telephone }}
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
                                <a href="{{ route('admin.commandes.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Retour à la liste
                                </a>
                                <div>
                                    <a href="#" class="btn btn-primary">
                                        <i class="fas fa-download"></i> Télécharger la facture
                                    </a>
                                    <a href="#" class="btn btn-info">
                                        <i class="fas fa-envelope"></i> Envoyer un email
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