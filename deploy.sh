#!/bin/bash

echo "🚀 Déploiement de l'application E-commerce..."

# Installation des dépendances
composer install --no-dev --optimize-autoloader

# Génération de la clé d'application
php artisan key:generate

# Migration de la base de données
php artisan migrate --force

# Optimisation du cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Déploiement terminé !" 