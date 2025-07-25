<?php

use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ProduitController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/listecategorie',[CategorieController::class,'index'])->name('listecategorie');
Route::get('/addcategorie',[CategorieController::class,'create'])->name('addcategorie');
Route::post('/savecategorie',[CategorieController::class,'store'])->name('savecategorie');
Route::delete('/deletecategorie/{id}',[CategorieController::class,'destroy'])->name('deletecategorie');


Route::resource('produit', ProduitController::class);
