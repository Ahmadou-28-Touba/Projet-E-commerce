<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| C'est ici que tu enregistres toutes tes routes web.
| Certaines routes sont accessibles publiquement (front-office),
| d'autres nécessitent une authentification (back-office/admin).
|
*/

// Routes publiques (Front-office)
Route::get('/', [FrontController::class, 'index'])->name('home');
Route::get('/catalogue', [FrontController::class, 'index'])->name('catalogue');
Route::get('/produit/{id}', [FrontController::class, 'show'])->name('produit.show');
Route::get('/search', [FrontController::class, 'search'])->name('search');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes du panier (bloquées pour les admins)
    Route::middleware(['block.admin.panier'])->group(function () {
        Route::get('/panier', [PanierController::class, 'index'])->name('panier.index');
        Route::post('/panier/add', [PanierController::class, 'add'])->name('panier.add');
        Route::put('/panier/{id}', [PanierController::class, 'update'])->name('panier.update');
        Route::delete('/panier/{id}', [PanierController::class, 'remove'])->name('panier.remove');
        Route::delete('/panier', [PanierController::class, 'clear'])->name('panier.clear');
    });

    // Routes des commandes (client) - bloquées pour les admins
    Route::middleware(['block.admin.panier'])->group(function () {
        Route::get('/commandes', [CommandeController::class, 'index'])->name('commandes.index');
        Route::get('/commandes/{id}', [CommandeController::class, 'show'])->name('commandes.show');
        Route::get('/commande/create', [CommandeController::class, 'create'])->name('commandes.create');
        Route::post('/commande/store', [CommandeController::class, 'store'])->name('commandes.store');
    });
});

// Routes d'administration (protégées par le middleware admin)
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    // Tableau de bord d'administration
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Routes admin (produits et catégories)
    Route::get('/produits', [ProduitController::class, 'index'])->name('produits.index');
    Route::get('/listecategorie', [CategorieController::class, 'index'])->name('listecategorie');
    Route::get('/addcategorie', [CategorieController::class, 'create'])->name('addcategorie');
    Route::post('/savecategorie', [CategorieController::class, 'store'])->name('savecategorie');
    Route::get('/editcategorie/{id}', [CategorieController::class, 'edit'])->name('editcategorie');
    Route::put('/updatecategorie/{id}', [CategorieController::class, 'update'])->name('updatecategorie');
    Route::delete('/deletecategorie/{id}', [CategorieController::class, 'destroy'])->name('deletecategorie');
    Route::resource('produit', ProduitController::class);

    // Routes admin (commandes)
    Route::get('/admin/commandes', [CommandeController::class, 'adminIndex'])->name('admin.commandes.index');
    Route::get('/admin/commandes/{id}', [CommandeController::class, 'adminShow'])->name('admin.commandes.show');
    Route::patch('/admin/commandes/{id}/statut', [CommandeController::class, 'updateStatut'])->name('admin.commandes.statut');
    Route::patch('/admin/commandes/{id}/paiement', [CommandeController::class, 'updatePaiement'])->name('admin.commandes.paiement');
    Route::post('/admin/commandes/{id}/envoyer-email', [CommandeController::class, 'envoyerEmailConfirmation'])->name('admin.commandes.envoyer-email');
});

require __DIR__.'/auth.php';
