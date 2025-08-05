# 🚀 Guide de Déploiement E-commerce

## 📋 Variables d'environnement à configurer

### 🔧 **Configuration de base :**
```env
APP_NAME="Votre Boutique E-commerce"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-domaine.com
APP_KEY=base64:votre-clé-générée
```

### 🗄️ **Base de données :**
```env
DB_CONNECTION=mysql
DB_HOST=votre-host-db
DB_PORT=3306
DB_DATABASE=votre-nom-db
DB_USERNAME=votre-username
DB_PASSWORD=votre-password
```

### 📧 **Configuration Email (Gmail) :**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=thiamahmadoubamba863@gmail.com
MAIL_PASSWORD=votre-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=thiamahmadoubamba863@gmail.com
MAIL_FROM_NAME="Votre Boutique E-commerce"
```

### 🔐 **Sécurité :**
```env
SESSION_DRIVER=database
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

## 🎯 **Étapes de déploiement**

### **1. Railway (Recommandé)**
1. Allez sur [railway.app](https://railway.app)
2. Connectez-vous avec GitHub
3. Créez un nouveau projet
4. Sélectionnez votre repository
5. Ajoutez une base de données MySQL
6. Configurez les variables d'environnement
7. Déployez !

### **2. Heroku**
1. Installez Heroku CLI
2. `heroku login`
3. `heroku create votre-app-name`
4. `heroku addons:create jawsdb:kitefin`
5. Configurez les variables d'environnement
6. `git push heroku main`

### **3. Vercel**
1. Allez sur [vercel.com](https://vercel.com)
2. Connectez-vous avec GitHub
3. Importez votre repository
4. Configurez les variables d'environnement
5. Déployez !

## ✅ **Vérifications post-déploiement**

1. **Testez** l'accès à votre site
2. **Vérifiez** que la base de données fonctionne
3. **Testez** l'envoi d'emails
4. **Vérifiez** que les admins sont bloqués du panier
5. **Testez** les fonctionnalités client

## 🎉 **Votre site sera en ligne !** 