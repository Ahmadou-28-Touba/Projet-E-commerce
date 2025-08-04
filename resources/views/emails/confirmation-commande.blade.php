<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de commande</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center; }
        .header h1 { margin: 0; font-size: 28px; }
        .content { padding: 40px 30px; }
        .order-info { background-color: #f8f9fa; border-radius: 8px; padding: 25px; margin: 25px 0; border-left: 4px solid #667eea; }
        .order-number { font-size: 20px; font-weight: bold; color: #667eea; margin-bottom: 15px; }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 10px; padding: 8px 0; border-bottom: 1px solid #eee; }
        .total { background-color: #667eea; color: white; padding: 20px; border-radius: 8px; text-align: center; margin: 25px 0; }
        .total-amount { font-size: 24px; font-weight: bold; }
        .footer { background-color: #f8f9fa; padding: 30px; text-align: center; color: #666; }
        .product-item { display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-bottom: 1px solid #eee; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Confirmation de commande</h1>
            <p>Merci pour votre commande !</p>
        </div>

        <div class="content">
            <p>Bonjour <strong>{{ $user->name }}</strong>,</p>
            <p>Nous avons bien reçu votre commande et nous vous remercions pour votre confiance.</p>

            <div class="order-info">
                <div class="order-number">Commande #{{ $commande->numero_commande }}</div>
                <div class="info-row">
                    <span><strong>Date de commande :</strong></span>
                    <span>{{ $commande->created_at->format('d/m/Y à H:i') }}</span>
                </div>
                <div class="info-row">
                    <span><strong>Statut :</strong></span>
                    <span>{{ ucfirst($commande->statut) }}</span>
                </div>
                <div class="info-row">
                    <span><strong>Mode de paiement :</strong></span>
                    <span>{{ $commande->mode_paiement === 'avant_livraison' ? 'Paiement avant livraison' : 'Paiement après livraison' }}</span>
                </div>
            </div>

            <h3>📦 Produits commandés</h3>
            @foreach($commande->produits as $produit)
                <div class="product-item">
                    <div>
                        <strong>{{ $produit->nom }}</strong><br>
                        <small>Quantité : {{ $produit->pivot->quantite }} | Prix unitaire : {{ number_format($produit->pivot->prix_unitaire, 0, ',', ' ') }} FCFA</small>
                    </div>
                    <div><strong>{{ number_format($produit->pivot->prix_total, 0, ',', ' ') }} FCFA</strong></div>
                </div>
            @endforeach

            <div class="total">
                <div>Total de votre commande</div>
                <div class="total-amount">{{ number_format($commande->total, 0, ',', ' ') }} FCFA</div>
            </div>

            <div class="order-info">
                <h4>📍 Adresse de livraison</h4>
                <p>
                    <strong>{{ $user->name }}</strong><br>
                    {{ $commande->adresse_livraison }}<br>
                    <strong>Téléphone :</strong> {{ $commande->telephone }}
                </p>
                
                @if($commande->notes)
                    <h4>📝 Notes</h4>
                    <p>{{ $commande->notes }}</p>
                @endif
            </div>

            <p style="text-align: center;">Nous vous tiendrons informé de l'évolution de votre commande.</p>
        </div>

        <div class="footer">
            <p><strong>Merci de votre confiance !</strong></p>
            <p>L'équipe de votre boutique en ligne</p>
        </div>
    </div>
</body>
</html> 