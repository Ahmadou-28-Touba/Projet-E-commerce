@extends('template')
@section('title', 'Mes Commandes')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">
                <i class="fas fa-list"></i> Mes Commandes
            </h1>

            @if($commandes->count() > 0)
                <div class="row">
                    @foreach($commandes as $commande)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">
                                        <i class="fas fa-shopping-bag"></i> Commande #{{ $commande->id }}
                                    </h5>
                                    <span class="badge bg-{{ $commande->statut === 'en_attente' ? 'warning' : ($commande->statut === 'expediee' ? 'info' : ($commande->statut === 'livree' ? 'success' : 'danger')) }}">
                                        {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Date :</strong> {{ $commande->created_at->format('d/m/Y H:i') }}</p>
                                            <p><strong>Total :</strong> {{ number_format($commande->total, 0, ',', ' ') }} FCFA</p>
                                            <p><strong>Mode de paiement :</strong> 
                                                {{ $commande->mode_paiement === 'avant_livraison' ? 'Avant livraison' : 'Après livraison' }}
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Statut paiement :</strong> 
                                                <span class="badge bg-{{ $commande->paiement_paye ? 'success' : 'warning' }}">
                                                    {{ $commande->paiement_paye ? 'Payé' : 'En attente' }}
                                                </span>
                                            </p>
                                            <p><strong>Produits :</strong> {{ $commande->produits->count() }} article(s)</p>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-3">
                                        <a href="{{ route('commandes.show', $commande->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye"></i> Voir les détails
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $commandes->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                    <h3>Aucune commande</h3>
                    <p class="text-muted">Vous n'avez pas encore passé de commande.</p>
                    <a href="{{ route('catalogue') }}" class="btn btn-primary">
                        <i class="fas fa-shopping-bag"></i> Voir le catalogue
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection 