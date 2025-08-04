<?php

/**
 * Script de configuration email pour le projet e-commerce
 * Exécutez ce script pour configurer automatiquement l'envoi d'emails
 */

echo "🔧 Configuration Email - Projet E-commerce\n";
echo "==========================================\n\n";

// Lire le fichier .env actuel
$envFile = '.env';
$envContent = file_get_contents($envFile);

if (!$envContent) {
    echo "❌ Erreur : Impossible de lire le fichier .env\n";
    exit(1);
}

echo "📧 Configuration actuelle détectée :\n";
echo "- Mailtrap (mode test)\n\n";

echo "🎯 Options de configuration :\n";
echo "1. Gmail (Recommandé pour débuter)\n";
echo "2. SendGrid (Professionnel)\n";
echo "3. Mailgun (Populaire)\n";
echo "4. Garder Mailtrap (Test uniquement)\n\n";

echo "💡 Recommandation : Choisissez l'option 1 (Gmail) pour commencer\n";
echo "   Vous pourrez changer plus tard facilement.\n\n";

// Configuration Gmail (option recommandée)
$gmailConfig = [
    'MAIL_MAILER=smtp',
    'MAIL_HOST=smtp.gmail.com',
    'MAIL_PORT=587',
    'MAIL_USERNAME=votre-email@gmail.com',
    'MAIL_PASSWORD=votre-mot-de-passe-app',
    'MAIL_ENCRYPTION=tls',
    'MAIL_FROM_ADDRESS=votre-email@gmail.com',
    'MAIL_FROM_NAME="Votre Boutique E-commerce"'
];

// Remplacer la configuration email
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
    $newEnvContent = str_replace($oldLine, $gmailConfig[$index], $newEnvContent);
}

// Sauvegarder le nouveau fichier .env
if (file_put_contents($envFile, $newEnvContent)) {
    echo "✅ Configuration Gmail appliquée avec succès !\n\n";
    
    echo "📋 Prochaines étapes :\n";
    echo "1. Remplacez 'votre-email@gmail.com' par votre vrai email Gmail\n";
    echo "2. Remplacez 'votre-mot-de-passe-app' par votre mot de passe d'application Gmail\n";
    echo "3. Testez avec : php artisan email:test votre-email@gmail.com\n\n";
    
    echo "🔐 Pour configurer Gmail :\n";
    echo "- Allez sur https://myaccount.google.com/security\n";
    echo "- Activez l'authentification à 2 facteurs\n";
    echo "- Créez un 'Mot de passe d'application'\n";
    echo "- Utilisez ce mot de passe dans MAIL_PASSWORD\n\n";
    
    echo "🧪 Test rapide :\n";
    echo "php artisan config:clear\n";
    echo "php artisan config:cache\n";
    echo "php artisan email:test votre-email@gmail.com\n\n";
    
    echo "🎉 Configuration terminée ! Votre projet peut maintenant envoyer de vrais emails.\n";
} else {
    echo "❌ Erreur lors de la sauvegarde du fichier .env\n";
    exit(1);
}

?> 