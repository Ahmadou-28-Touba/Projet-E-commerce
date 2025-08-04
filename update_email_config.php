<?php

/**
 * Script pour mettre à jour la configuration email
 */

echo "🔧 Mise à jour de la configuration email...\n";
echo "==========================================\n\n";

// Lire le fichier .env actuel
$envFile = '.env';
$envContent = file_get_contents($envFile);

if (!$envContent) {
    echo "❌ Erreur : Impossible de lire le fichier .env\n";
    exit(1);
}

// Configuration email avec l'email de l'utilisateur
$newConfig = [
    'MAIL_MAILER=smtp',
    'MAIL_HOST=smtp.gmail.com',
    'MAIL_PORT=587',
    'MAIL_USERNAME=thiamahmadoubamba863@gmail.com',
    'MAIL_PASSWORD=votre-mot-de-passe-app',
    'MAIL_ENCRYPTION=tls',
    'MAIL_FROM_ADDRESS=thiamahmadoubamba863@gmail.com',
    'MAIL_FROM_NAME="Votre Boutique E-commerce"'
];

// Remplacer la configuration email actuelle
$oldConfig = [
    'MAIL_MAILER=smtp',
    'MAIL_HOST=sandbox.smtp.mailtrap.io',
    'MAIL_PORT=2525',
    'MAIL_USERNAME=57d8771addcd5b',
    'MAIL_PASSWORD=f56b88098977da',
    'MAIL_ENCRYPTION=null',
    'MAIL_FROM_ADDRESS="hello@example.com"',
    'MAIL_FROM_NAME="${APP_NAME}"'
];

$newEnvContent = $envContent;

foreach ($oldConfig as $index => $oldLine) {
    $newEnvContent = str_replace($oldLine, $newConfig[$index], $newEnvContent);
}

// Sauvegarder le nouveau fichier .env
if (file_put_contents($envFile, $newEnvContent)) {
    echo "✅ Configuration email mise à jour avec succès !\n\n";
    
    echo "📧 Configuration appliquée :\n";
    echo "- Email : thiamahmadoubamba863@gmail.com\n";
    echo "- Host : smtp.gmail.com\n";
    echo "- Port : 587\n";
    echo "- Encryption : TLS\n\n";
    
    echo "🔐 Prochaines étapes :\n";
    echo "1. Allez sur https://myaccount.google.com/security\n";
    echo "2. Activez l'authentification à 2 facteurs\n";
    echo "3. Créez un 'Mot de passe d'application'\n";
    echo "4. Remplacez 'votre-mot-de-passe-app' par ce mot de passe\n";
    echo "5. Testez avec : php artisan email:test thiamahmadoubamba863@gmail.com\n\n";
    
    echo "🧪 Test rapide :\n";
    echo "php artisan config:clear\n";
    echo "php artisan config:cache\n";
    echo "php artisan email:test thiamahmadoubamba863@gmail.com\n\n";
    
    echo "🎉 Configuration terminée ! Il ne reste plus qu'à configurer le mot de passe d'application Gmail.\n";
} else {
    echo "❌ Erreur lors de la sauvegarde du fichier .env\n";
    exit(1);
}

?> 