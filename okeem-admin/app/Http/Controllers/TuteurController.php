<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tuteur;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TuteurController extends Controller
{
    public function index()
    {
        return response()->json(Tuteur::with('enfants', 'etablissements')->get());
    }

    public function store(Request $request)
    {
        $tuteur = Tuteur::create($request->all());
        return response()->json($tuteur, Response::HTTP_CREATED);
    }

    public function show(Tuteur $tuteur)
    {
        return response()->json($tuteur->load('enfants', 'etablissements'));
    }

    public function update(Request $request, Tuteur $tuteur)
    {
        $validatedData = $request->validate([
            'prenom' => 'sometimes|string|max:255',
            'nom' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255',
            'telephone' => 'sometimes|string|max:20',
        ]);

        $tuteur->update($validatedData);
        return response()->json($tuteur);
    }

    public function destroy(Tuteur $tuteur)
    {
        $tuteur->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
