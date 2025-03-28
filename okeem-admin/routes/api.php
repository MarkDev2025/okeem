<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EtablissementController;
use App\Http\Controllers\EnfantController;
use App\Http\Controllers\TuteurController;
use App\Http\Controllers\OkeemienController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\TransmissionController;
use App\Http\Controllers\AuthController;

Route::get('enfants', [EnfantController::class, 'index']);
Route::post('enfants', [EnfantController::class, 'store']);
Route::get('enfants/{enfant}', [EnfantController::class, 'show']);
Route::put('enfants/{enfant}', [EnfantController::class, 'update']);
Route::apiResource('etablissements', EtablissementController::class);
Route::apiResource('tuteurs', TuteurController::class);
Route::apiResource('okeemiens', OkeemienController::class);
Route::apiResource('presences', PresenceController::class);
Route::apiResource('factures', FactureController::class);
Route::apiResource('transmissions', TransmissionController::class);


// Routes protégées par Sanctum
Route::middleware('auth:sanctum')->group(function () {
    // Route::post('/logout', [AuthController::class, 'logout']);
    // Route::get('/user', [AuthController::class, 'user']);

    // Route::apiResource('etablissements', EtablissementController::class);
    //Route::apiResource('enfants', EnfantController::class);
    // Route::apiResource('tuteurs', TuteurController::class);
    // Route::apiResource('okeemiens', OkeemienController::class);
    // Route::apiResource('presences', PresenceController::class);
    // Route::apiResource('factures', FactureController::class);
    // Route::apiResource('transmissions', TransmissionController::class);
});
