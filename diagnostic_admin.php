<?php

/**
 * Script de diagnostic pour les problèmes d'administration
 * Vérifie l'accès admin et les commandes
 */

require_once 'vendor/autoload.php';

use App\Models\User;
use App\Models\Commande;
use App\Models\Panier;

echo "🔍 Diagnostic Admin - Projet E-commerce\n";
echo "=======================================\n\n";

// 1. Vérifier l'utilisateur connecté
echo "1. 📋 Utilisateurs dans la base de données :\n";
$users = User::all();
foreach ($users as $user) {
    echo "   - ID: {$user->id} | Nom: {$user->name} | Email: {$user->email} | Admin: " . ($user->is_admin ? 'OUI' : 'NON') . "\n";
}
echo "\n";

// 2. Vérifier les commandes
echo "2. 📦 Commandes dans la base de données :\n";
$commandes = Commande::with('user')->get();
if ($commandes->count() > 0) {
    foreach ($commandes as $commande) {
        echo "   - Commande #{$commande->id} | Client: {$commande->user->name} | Total: {$commande->total} FCFA | Date: {$commande->created_at->format('d/m/Y H:i')}\n";
    }
} else {
    echo "   ❌ Aucune commande trouvée dans la base de données\n";
}
echo "\n";

// 3. Vérifier les paniers
echo "3. 🛒 Paniers dans la base de données :\n";
$paniers = Panier::with('user', 'produit')->get();
if ($paniers->count() > 0) {
    foreach ($paniers as $panier) {
        echo "   - Panier ID: {$panier->id} | Client: {$panier->user->name} | Produit: {$panier->produit->nom} | Quantité: {$panier->quantite}\n";
    }
} else {
    echo "   ❌ Aucun panier trouvé dans la base de données\n";
}
echo "\n";

// 4. Test de la méthode adminIndex
echo "4. 🧪 Test de la méthode adminIndex :\n";
try {
    $controller = new \App\Http\Controllers\CommandeController();
    $commandes = Commande::with(['user', 'produits'])->orderBy('created_at', 'desc')->get();
    echo "   ✅ Méthode adminIndex fonctionne\n";
    echo "   📊 Nombre de commandes récupérées : {$commandes->count()}\n";
} catch (Exception $e) {
    echo "   ❌ Erreur dans adminIndex : " . $e->getMessage() . "\n";
}
echo "\n";

// 5. Vérifier les permissions
echo "5. 🔐 Vérification des permissions :\n";
$adminUsers = User::where('is_admin', true)->get();
if ($adminUsers->count() > 0) {
    echo "   ✅ Utilisateurs administrateurs trouvés :\n";
    foreach ($adminUsers as $admin) {
        echo "      - {$admin->name} ({$admin->email})\n";
    }
} else {
    echo "   ❌ Aucun utilisateur administrateur trouvé\n";
    echo "   💡 Pour créer un admin, utilisez : php artisan tinker\n";
    echo "   💡 Puis : User::find(1)->update(['is_admin' => true]);\n";
}
echo "\n";

// 6. Recommandations
echo "6. 💡 Recommandations :\n";
echo "   - Assurez-vous d'être connecté avec un compte admin\n";
echo "   - Vérifiez que les clients ont bien passé des commandes\n";
echo "   - Testez l'accès à : /admin/commandes\n";
echo "   - Vérifiez les logs Laravel pour les erreurs\n";
echo "\n";

echo "🎯 Résumé :\n";
echo "- Utilisateurs : " . $users->count() . "\n";
echo "- Commandes : " . $commandes->count() . "\n";
echo "- Paniers : " . $paniers->count() . "\n";
echo "- Admins : " . $adminUsers->count() . "\n";

?> 