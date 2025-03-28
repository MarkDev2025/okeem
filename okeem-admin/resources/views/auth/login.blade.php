@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-bold text-center mb-6">Connexion</h2>

        @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" required
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Mot de passe</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
            </div>

            <button type="submit"
                class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-700 transition duration-300">
                Se connecter
            </button>
        </form>
    </div>
</div>
@endsection