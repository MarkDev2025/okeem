<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Okeemien;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OkeemienController extends Controller
{
    public function index()
    {
        return response()->json(Okeemien::with('etablissements')->get());
    }

    public function store(Request $request)
    {
        $okeemien = Okeemien::create($request->all());
        return response()->json($okeemien, Response::HTTP_CREATED);
    }

    public function show(Okeemien $okeemien)
    {
        return response()->json($okeemien->load('etablissements'));
    }

    public function update(Request $request, Okeemien $okeemien)
    {
        $validatedData = $request->validate([
            'prenom' => 'sometimes|string|max:255',
            'nom' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255',
            'telephone' => 'sometimes|string|max:20',
        ]);
        $okeemien->update($validatedData);
        return response()->json($okeemien);
    }

    public function destroy(Okeemien $okeemien)
    {
        $okeemien->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
