<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ProduitController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/produits', [ProduitController::class, 'index'])->name('produits.index');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/listecategorie', [CategorieController::class, 'index'])->name('listecategorie');
    Route::get('/addcategorie', [CategorieController::class, 'create'])->name('addcategorie');
    Route::post('/savecategorie', [CategorieController::class, 'store'])->name('savecategorie');
    Route::delete('/deletecategorie/{id}', [CategorieController::class, 'destroy'])->name('deletecategorie');

    Route::resource('produit', ProduitController::class);
});

require __DIR__.'/auth.php';
