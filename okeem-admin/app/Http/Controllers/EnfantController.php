<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Enfant;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EnfantController extends Controller
{
    public function index()
    {
        return response()->json(Enfant::with('etablissement', 'tuteurs')->get());
    }

    public function store(Request $request)
    {
        $enfant = Enfant::create($request->all());
        return response()->json($enfant, Response::HTTP_CREATED);
    }

    public function show(Enfant $enfant)
    {
        return response()->json($enfant->load('etablissement', 'tuteurs'));
    }

    public function update(Request $request, Enfant $enfant)
    {

        $validatedData = $request->validate([
            'prenom' => 'sometimes|string|max:255',
            'nom' => 'sometimes|string|max:255',
            'date_naissance' => 'sometimes|date',
            'avatar' => 'sometimes|string|max:255',
            'etablissement_id' => 'sometimes|integer|exists:etablissements,id',
        ]);

        $enfant->update($validatedData);
        return response()->json($enfant);
    }

    public function destroy(Enfant $enfant)
    {
        $enfant->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
