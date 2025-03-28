<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Facture;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FactureController extends Controller
{
    public function index()
    {
        return response()->json(Facture::with('tuteur')->get());
    }

    public function store(Request $request)
    {
        $facture = Facture::create($request->all());
        return response()->json($facture, Response::HTTP_CREATED);
    }

    public function show(Facture $facture)
    {
        return response()->json($facture->load('tuteur'));
    }

    public function update(Request $request, Facture $facture)
    {
        $validatedData = $request->validate([
            'tuteur_id' => 'sometimes|integer|exists:tuteurs,id',
            'montant' => 'sometimes|numeric|min:0',
            'statut' => 'sometimes|string|in:en_attente,payée,annulée',
            'pdf' => 'sometimes|string|max:255',
            'etablissement_id' => 'sometimes|integer|exists:etablissements,id',
        ]);
        $facture->update($validatedData);
        return response()->json($facture);
    }

    public function destroy(Facture $facture)
    {
        $facture->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
