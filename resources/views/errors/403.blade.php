@extends('template')
@section('title', 'Accès refusé')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-exclamation-triangle fa-5x text-warning mb-4"></i>
                    <h1 class="text-danger">403 - Accès refusé</h1>
                    <p class="lead">Vous n'avez pas les permissions nécessaires pour accéder à cette page.</p>
                    <p class="text-muted">Cette section est réservée aux administrateurs.</p>
                    
                    <div class="mt-4">
                        <a href="{{ route('home') }}" class="btn btn-primary">
                            <i class="fas fa-home"></i> Retour à l'accueil
                        </a>
                        <a href="{{ route('catalogue') }}" class="btn btn-outline-primary">
                            <i class="fas fa-shopping-cart"></i> Voir le catalogue
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection 