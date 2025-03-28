<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Livewire\Dashboard;
use Illuminate\Support\Facades\Auth;

// Redirige les utilisateurs non connectés vers /login
Route::get('/', function () {
    return Auth::check() ? redirect('/dashboard') : redirect('/login');
});

// Page de connexion
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Connexion et déconnexion (POST)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Page d'accueil protégée (Dashboard)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/docs/api', function () {
        return view('scramble::ui'); // Assurez-vous que Scramble est bien installé
    })->name('api.docs');
});
