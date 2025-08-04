<?php

/**
 * Script pour corriger le mot de passe d'application
 */

echo "🔧 Correction du mot de passe d'application...\n";
echo "============================================\n\n";

// Lire le fichier .env actuel
$envFile = '.env';
$envContent = file_get_contents($envFile);

if (!$envContent) {
    echo "❌ Erreur : Impossible de lire le fichier .env\n";
    exit(1);
}

// Corriger le mot de passe en ajoutant les guillemets
$oldPassword = 'MAIL_PASSWORD=ktcv nlyp ouqx cfgf';
$newPassword = 'MAIL_PASSWORD="ktcv nlyp ouqx cfgf"';

$newEnvContent = str_replace($oldPassword, $newPassword, $envContent);

// Sauvegarder le fichier corrigé
if (file_put_contents($envFile, $newEnvContent)) {
    echo "✅ Mot de passe d'application corrigé avec succès !\n\n";
    
    echo "📧 Configuration actuelle :\n";
    echo "- Email : thiamahmadoubamba863@gmail.com\n";
    echo "- Mot de passe : ktcv nlyp ouqx cfgf\n";
    echo "- Host : smtp.gmail.com\n\n";
    
    echo "🧪 Test de la configuration :\n";
    echo "php artisan config:clear\n";
    echo "php artisan config:cache\n";
    echo "php artisan email:test thiamahmadoubamba863@gmail.com\n\n";
    
    echo "🎉 Configuration terminée ! Testez maintenant l'envoi d'email.\n";
} else {
    echo "❌ Erreur lors de la correction du fichier .env\n";
    exit(1);
}

?> 