<nav class="flex justify-between items-center p-4 bg-gray-800 text-white">
    <ul class="flex space-x-4">
        <li><a href="{{ route('dashboard') }}" class="hover:underline">Tableau de Bord</a></li>
        <li><a href="{{ url('/docs/api') }}" class="hover:underline">Documentation de l'API</a></li>
        <li><a href="{{ url('/graphiql') }}" class="hover:underline">GraphQl</a></li>
    </ul>

    <form method="POST" action="{{ route('logout') }}" class="ml-auto">
        @csrf
        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
            Déconnexion
        </button>
    </form>
</nav>