@extends('template')
@section('title', 'Administration - Commandes')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">
                <i class="fas fa-cogs"></i> Administration - Commandes
            </h1>

            @if($commandes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Client</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Mode Paiement</th>
                                <th>Statut Commande</th>
                                <th>Statut Paiement</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($commandes as $commande)
                                <tr>
                                    <td>{{ $commande->id }}</td>
                                    <td>
                                        <strong>{{ $commande->user->name }}</strong><br>
                                        <small class="text-muted">{{ $commande->user->email }}</small>
                                    </td>
                                    <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ number_format($commande->total, 0, ',', ' ') }} FCFA</td>
                                    <td>
                                        <span class="badge bg-{{ $commande->mode_paiement === 'avant_livraison' ? 'primary' : 'warning' }}">
                                            {{ $commande->mode_paiement === 'avant_livraison' ? 'Avant livraison' : 'Après livraison' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $commande->statut === 'en_attente' ? 'warning' : ($commande->statut === 'expediee' ? 'info' : ($commande->statut === 'livree' ? 'success' : 'danger')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $commande->statut_paiement === 'paye' ? 'success' : ($commande->statut_paiement === 'non_paye' ? 'danger' : 'warning') }}">
                                            {{ ucfirst(str_replace('_', ' ', $commande->statut_paiement)) }}
                                        </span>
                                        <br><small class="text-muted">({{ $commande->statut_paiement }})</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.commandes.show', $commande->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#statutModal{{ $commande->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal pour modifier les statuts -->
                                <div class="modal fade" id="statutModal{{ $commande->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Modifier les statuts - Commande #{{ $commande->id }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.commandes.statut', $commande->id) }}" method="POST" class="mb-3">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="PATCH">
                                                    <div class="mb-3">
                                                        <label for="statut" class="form-label">Statut de la commande</label>
                                                        <select name="statut" id="statut" class="form-select">
                                                            <option value="en_attente" {{ $commande->statut === 'en_attente' ? 'selected' : '' }}>En attente</option>
                                                            <option value="expediee" {{ $commande->statut === 'expediee' ? 'selected' : '' }}>Expédiée</option>
                                                            <option value="livree" {{ $commande->statut === 'livree' ? 'selected' : '' }}>Livrée</option>
                                                            <option value="annulee" {{ $commande->statut === 'annulee' ? 'selected' : '' }}>Annulée</option>
                                                        </select>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Mettre à jour le statut</button>
                                                </form>

                                                <hr>

                                                <form action="{{ route('admin.commandes.paiement', $commande->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="PATCH">
                                                    <div class="mb-3">
                                                        <label for="statut_paiement" class="form-label">Statut du paiement</label>
                                                        <select name="statut_paiement" id="statut_paiement" class="form-select">
                                                            <option value="en_attente" {{ $commande->statut_paiement === 'en_attente' ? 'selected' : '' }}>En attente</option>
                                                            <option value="paye" {{ $commande->statut_paiement === 'paye' ? 'selected' : '' }}>Payé</option>
                                                            <option value="non_paye" {{ $commande->statut_paiement === 'non_paye' ? 'selected' : '' }}>Non payé</option>
                                                        </select>
                                                    </div>
                                                    <button type="submit" class="btn btn-success">Mettre à jour le paiement</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $commandes->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                    <h3>Aucune commande</h3>
                    <p class="text-muted">Aucune commande n'a été passée pour le moment.</p>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection 