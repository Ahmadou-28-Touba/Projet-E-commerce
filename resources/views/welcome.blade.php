@extends('template')
@section('title', 'Accueil')
@section('content')

<div class="container">
    <!-- Hero Section -->
    <div class="row align-items-center py-5">
        <div class="col-lg-6">
            <h1 class="display-4 fw-bold text-primary mb-4">
                <i class="fas fa-store"></i> Bienvenue sur notre E-Commerce
            </h1>
            <p class="lead text-muted mb-4">
                Découvrez notre sélection de produits de qualité. 
                Achetez en toute sécurité avec nos options de paiement flexibles.
            </p>
            <div class="d-flex gap-3">
                <a href="{{ route('catalogue') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-shopping-bag"></i> Voir le catalogue
                </a>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-user-plus"></i> Créer un compte
                    </a>
                @endguest
            </div>
                </div>
        <div class="col-lg-6 text-center">
            <div class="bg-light rounded p-5">
                <i class="fas fa-shopping-cart fa-5x text-primary mb-3"></i>
                <h3>Commencez vos achats</h3>
                <p class="text-muted">Parcourez notre catalogue et trouvez ce qui vous convient</p>
                </div>
                                </div>
                            </div>

    <!-- Features Section -->
    <div class="row py-5">
        <div class="col-12 text-center mb-5">
            <h2 class="display-5">Pourquoi choisir notre plateforme ?</h2>
                                </div>
        <div class="col-md-4 text-center mb-4">
            <div class="p-4">
                <i class="fas fa-shield-alt fa-3x text-success mb-3"></i>
                <h4>Sécurité</h4>
                <p class="text-muted">Paiements sécurisés et données protégées</p>
                            </div>
                                </div>
        <div class="col-md-4 text-center mb-4">
            <div class="p-4">
                <i class="fas fa-truck fa-3x text-info mb-3"></i>
                <h4>Livraison</h4>
                <p class="text-muted">Livraison rapide et fiable</p>
                            </div>
                                </div>
        <div class="col-md-4 text-center mb-4">
            <div class="p-4">
                <i class="fas fa-headset fa-3x text-warning mb-3"></i>
                <h4>Support</h4>
                <p class="text-muted">Service client disponible 24/7</p>
                        </div>
                    </div>
                </div>

    <!-- Call to Action -->
    <div class="row py-5">
        <div class="col-12 text-center">
            <div class="bg-primary text-white rounded p-5">
                <h2 class="mb-3">Prêt à commencer ?</h2>
                <p class="lead mb-4">Rejoignez des milliers de clients satisfaits</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('catalogue') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-shopping-bag"></i> Voir les produits
                    </a>
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-sign-in-alt"></i> Se connecter
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
