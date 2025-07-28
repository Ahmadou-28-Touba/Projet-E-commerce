<?php

require_once 'vendor/autoload.php';

use App\Models\Commande;
use Illuminate\Http\Request;

// Simuler une requête PATCH
$request = new Request();
$request->merge([
    'statut_paiement' => 'paye'
]);

// Simuler le contrôleur
$commande = Commande::find(2);
echo "Avant modification: " . $commande->statut_paiement . "\n";

$commande->statut_paiement = $request->statut_paiement;
$commande->save();

echo "Après modification: " . $commande->fresh()->statut_paiement . "\n"; 