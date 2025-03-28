@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Okeem : Tableau de Bord</h1>

    <div class="grid grid-cols-3 gap-4">
        <div class="bg-blue-100 p-4 rounded-lg shadow">
            <h2 class="text-lg font-semibold">Total Enfants</h2>
            <p class="text-xl">{{ $totalEnfants }}</p>
        </div>
        <div class="bg-green-100 p-4 rounded-lg shadow">
            <h2 class="text-lg font-semibold">Total Tuteurs</h2>
            <p class="text-xl">{{ $totalTuteurs }}</p>
        </div>
        <div class="bg-yellow-100 p-4 rounded-lg shadow">
            <h2 class="text-lg font-semibold">Total Éducateurs</h2>
            <p class="text-xl">{{ $totalOkeemiens }}</p>
        </div>
    </div>

    <div class="mt-6">
        <h2 class="text-lg font-bold">Présences Aujourd'hui : {{ $enfantsPresents }}</h2>
        <h2 class="text-lg font-bold">Factures Non Payées : {{ $facturesNonPayees }}</h2>
    </div>

    <div class="mt-6">
        <h2 class="text-lg font-bold">Dernières Transmissions</h2>
        <ul class="list-disc pl-5">
            @foreach($dernieresTransmissions as $transmission)
            <li>{{ $transmission->message }} ({{ $transmission->enfant->prenom }})</li>
            @endforeach
        </ul>
    </div>
</div>
@endsection