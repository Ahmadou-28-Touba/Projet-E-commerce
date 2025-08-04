# 📧 Configuration Email - Exemples

## 🔧 Copiez ces configurations dans votre fichier `.env`

### Option 1 : Gmail (Recommandé pour débuter)
```env
# Configuration Email - Gmail
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre-email@gmail.com
MAIL_PASSWORD=votre-mot-de-passe-app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=votre-email@gmail.com
MAIL_FROM_NAME="Votre Boutique E-commerce"
```

### Option 2 : SendGrid (Professionnel)
```env
# Configuration Email - SendGrid
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=votre-api-key-sendgrid
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=votre-email@votre-domaine.com
MAIL_FROM_NAME="Votre Boutique"
```

### Option 3 : Mailgun
```env
# Configuration Email - Mailgun
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=votre-domaine.mailgun.org
MAILGUN_SECRET=votre-api-key-mailgun
MAIL_FROM_ADDRESS=noreply@votre-domaine.com
MAIL_FROM_NAME="Votre Boutique"
```

### Option 4 : Amazon SES
```env
# Configuration Email - Amazon SES
MAIL_MAILER=ses
AWS_ACCESS_KEY_ID=votre-access-key
AWS_SECRET_ACCESS_KEY=votre-secret-key
AWS_DEFAULT_REGION=us-east-1
MAIL_FROM_ADDRESS=votre-email@votre-domaine.com
MAIL_FROM_NAME="Votre Boutique"
```

## 🧪 Comment tester

### 1. Test simple
```bash
php artisan email:test votre-email@example.com
```

### 2. Test avec une vraie commande
```bash
php artisan email:test votre-email@example.com --commande=1
```

### 3. Vérifier la configuration
```bash
php artisan config:clear
php artisan config:cache
```

## 🚨 Important pour Gmail

1. **Activez l'authentification à 2 facteurs**
2. **Générez un mot de passe d'application** :
   - Allez sur https://myaccount.google.com/security
   - Activez l'authentification à 2 facteurs
   - Créez un "Mot de passe d'application"
   - Utilisez ce mot de passe dans `MAIL_PASSWORD`

## ✅ Vérification

Après configuration, testez avec :
```bash
php artisan email:test votre-email@gmail.com
```

Si vous recevez l'email, la configuration est correcte ! 🎉 