<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PresenceController extends Controller
{
    public function index()
    {
        return response()->json(Presence::with('enfant')->get());
    }

    public function store(Request $request)
    {
        $presence = Presence::create($request->all());
        return response()->json($presence, Response::HTTP_CREATED);
    }

    public function show(Presence $presence)
    {
        return response()->json($presence->load('enfant'));
    }

    public function update(Request $request, Presence $presence)
    {
        $validatedData = $request->validate([
            'enfant_id' => 'sometimes|integer|exists:enfants,id',
            'jour' => 'sometimes|date_format:Y-m-d',
            'heure_debut' => 'sometimes|date_format:H:i',
            'heure_fin' => 'sometimes|date_format:H:i|after:heure_debut',
        ]);

        $presence->update($validatedData);
        return response()->json($presence);
    }

    public function destroy(Presence $presence)
    {
        $presence->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
