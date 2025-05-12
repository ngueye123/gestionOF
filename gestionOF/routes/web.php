<?php

use App\Http\Controllers\ConnexionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecetteController ;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\OrdreFabricationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\InventaireController;
use App\Http\Controllers\ProgrammeController;
use App\Http\Controllers\ControlController;
use App\Http\Controllers\FicheLivraisonController;
use App\Http\Middleware\Authentification;
use App\Http\Middleware\NonAuthentifie;


Route::get('/', [ConnexionController ::class, 'index'])->middleware([NonAuthentifie::class])->name('connexion');
Route::get('/connexion', [ConnexionController ::class, 'index'])->middleware([NonAuthentifie::class])->name('connexion');
Route::post('/connexion', [ConnexionController ::class, 'validationConnexion'])->middleware([NonAuthentifie::class])->name('validationConnexion');
Route::get('/deconnexion', [ConnexionController ::class, 'deconnexion'])->name('deconnexion');

Route::middleware([Authentification::class])->group(function () {
    Route::get('/accueil', [HomeController::class, 'index'])->name('accueil');
    Route::get('/of-en-cours', [HomeController::class, 'getOfEnCours'])->name('of.enCours');

    Route::get('/recette', [RecetteController ::class, 'index'])->name('recette');
    Route::post('/recette', [RecetteController ::class, 'store'])->name('recette.store');

    Route::get('/produit', [ProduitController::class, 'index'])->name('produit');
    Route::post('/produit', [ProduitController::class, 'store'])->name('produit.store');

    Route::get('/logs', [LogController::class, 'index'])->name('log');

    Route::get('/of', [OrdreFabricationController::class, 'index'])->name('of');
    Route::post('/of', [OrdreFabricationController::class, 'store'])->name('of.store');
    Route::get('/of/{id}/edit', [OrdreFabricationController::class, 'edit'])->name('of.edit');
    Route::put('/of/{id}', [OrdreFabricationController::class, 'update'])->name('of.update');
    
    Route::get('/personnel', [PersonnelController::class, 'index'])->name('personnel');
    Route::post('/personnel', [PersonnelController::class, 'store'])->name('personnel.store');

    Route::post('/programme', [ProgrammeController::class, 'store'])->name('programme.store');
    Route::get('/FormulaireProgramme', [ProgrammeController::class, 'afficherFormulaire'])->name('formulaire');
    Route::get('/programme', [ProgrammeController::class, 'index'])->name('programme');
    Route::get('/programme/details/{id}', [ProgrammeController::class, 'details'])->name('programme.details');
    
    Route::get('/controle', [ControlController::class, 'index'])->name('controle');
    Route::post('/controle', [ControlController::class, 'store'])->name('controle.store');

    Route::get('/livraison', [FicheLivraisonController::class, 'index'])->name('livraison');
    Route::post('/livraison', [FicheLivraisonController::class, 'store'])->name('livraison.store');

    Route::get('/inventaire', [InventaireController::class, 'index'])->name('inventaire');
    Route::post('/inventaire/soumettre', [InventaireController::class, 'soumettre'])->name('inventaire.soumettre');
    Route::get('/inventaire/valider/{id}', [InventaireController::class, 'valider'])->name('inventaire.valider');
    Route::get('/inventaire/rejeter/{id}', [InventaireController::class, 'rejeter'])->name('inventaire.rejeter');
    Route::get('/inventaire/details/{id}', [InventaireController::class, 'details'])->name('inventaire.details');
    Route::get('/inventaire-en-attente', [InventaireController::class, 'getInventaire'])->name('inventaire.enAttente');

});

