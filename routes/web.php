<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ProduitController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/listecategorie', [CategorieController::class,'index'])->name('listecategorie');
    Route::get('/addcategorie', [CategorieController::class,'create'])->name('addcategorie');
    Route::post('/savecategorie', [CategorieController::class,'store'])->name('savecategorie');
    Route::delete('/deletecategorie/{id}', [CategorieController::class,'destroy'])->name('deletecategorie');

    Route::resource('produit', ProduitController::class);
});



require __DIR__.'/auth.php';
