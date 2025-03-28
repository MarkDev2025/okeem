<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Assure que seul un utilisateur authentifié peut accéder
    }

    public function index()
    {
        return view('dashboard'); // Charge la vue du tableau de bord
    }
}
