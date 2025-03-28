<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transmission;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransmissionController extends Controller
{
    public function index()
    {
        return response()->json(Transmission::with('okeemien', 'enfant', 'etablissement')->get());
    }

    public function store(Request $request)
    {
        $transmission = Transmission::create($request->all());
        return response()->json($transmission, Response::HTTP_CREATED);
    }

    public function show(Transmission $transmission)
    {
        return response()->json($transmission->load('okeemien', 'enfant', 'etablissement'));
    }

    public function update(Request $request, Transmission $transmission)
    {
        $validatedData = $request->validate([
            'okeemien_id' => 'sometimes|integer|exists:okeemiens,id',
            'enfant_id' => 'sometimes|integer|exists:enfants,id',
            'etablissement_id' => 'sometimes|integer|exists:enfants,id',
            'message' => 'sometimes|string|max:1000',
            'jour' => 'sometimes|date_format:Y-m-d',
            'heure_debut' => 'sometimes|date_format:H:i',
            'heure_fin' => 'sometimes|date_format:H:i|after_or_equal:heure_debut',
            'fichier' => 'sometimes|string|max:255',
        ]);

        $transmission->update($validatedData);
        return response()->json($transmission);
    }

    public function destroy(Transmission $transmission)
    {
        $transmission->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
