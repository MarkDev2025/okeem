<?php

namespace App\Http\Controllers;

use App\Models\Etablissement;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class EtablissementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Etablissement::all());
    }

    public function store(Request $request)
    {
        $etablissement = Etablissement::create($request->all());
        return response()->json($etablissement, Response::HTTP_CREATED);
    }

    public function show(Etablissement $etablissement)
    {
        return response()->json($etablissement);
    }

    public function update(Request $request, Etablissement $etablissement)
    {
        $validatedData = $request->validate([
            'nom' => 'sometimes|string|max:255',
            'type' => 'sometimes|string|max:255',
            'lieu' => 'sometimes|string|max:255',
            'nom_responsable' => 'sometimes|string|max:255',
            'nombre_okeemiens' => 'sometimes|integer|min:0',
            'avatar' => 'sometimes|string|max:255',
        ]);
        $etablissement->update($validatedData);
        return response()->json($etablissement);
    }

    public function destroy(Etablissement $etablissement)
    {
        $etablissement->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
