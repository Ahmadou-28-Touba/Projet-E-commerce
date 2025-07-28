@extends('template')
@section('content')

<div class="container">
    <h1 class="mb-4">Passer la commande</h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Récapitulatif de votre commande</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Prix unitaire</th>
                                    <th>Quantité</th>
                                    <th>Total</th>
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
                                                         style="width: 40px; height: 40px; object-fit: cover;" 
                                                         class="me-2">
                                                @endif
                                                <div>
                                                    <h6 class="mb-0">{{ $panier->produit->nom }}</h6>
                                                    <small class="text-muted">{{ $panier->produit->categorie->nom }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ number_format($panier->produit->prix, 0, ',', ' ') }} FCFA</td>
                                        <td>{{ $panier->quantite }}</td>
                                        <td>{{ number_format($panier->quantite * $panier->produit->prix, 0, ',', ' ') }} FCFA</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Informations de livraison</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('commandes.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="adresse_livraison" class="form-label">Adresse de livraison *</label>
                            <textarea name="adresse_livraison" id="adresse_livraison" class="form-control" rows="3" required>{{ old('adresse_livraison') }}</textarea>
                            @error('adresse_livraison')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="telephone" class="form-label">Téléphone *</label>
                            <input type="text" name="telephone" id="telephone" class="form-control" value="{{ old('telephone') }}" required>
                            @error('telephone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="mode_paiement" class="form-label">Mode de paiement *</label>
                            <select name="mode_paiement" id="mode_paiement" class="form-control" required>
                                <option value="">Choisir un mode de paiement</option>
                                <option value="avant_livraison" {{ old('mode_paiement') == 'avant_livraison' ? 'selected' : '' }}>
                                    Paiement avant livraison (en ligne)
                                </option>
                                <option value="apres_livraison" {{ old('mode_paiement') == 'apres_livraison' ? 'selected' : '' }}>
                                    Paiement après livraison (à la réception)
                                </option>
                            </select>
                            @error('mode_paiement')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes (optionnel)</label>
                            <textarea name="notes" id="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                            @error('notes')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="card bg-light">
                            <div class="card-body">
                                <h6>Total de la commande</h6>
                                <h4 class="text-primary">{{ number_format($total, 0, ',', ' ') }} FCFA</h4>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success btn-lg w-100 mt-3">
                            <i class="fas fa-check"></i> Confirmer la commande
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection 