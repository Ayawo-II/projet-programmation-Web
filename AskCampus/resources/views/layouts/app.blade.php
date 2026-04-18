<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AskCampus') — Entraide académique</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">

    {{-- ── Navbar ── --}}
    <nav class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold text-xl text-indigo-600">
                🎓 AskCampus
            </a>

            {{-- Barre de recherche --}}
            <form action="{{ route('home') }}" method="GET" class="hidden md:flex flex-1 mx-8">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Rechercher une question..."
                    class="w-full border border-gray-300 rounded-l-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                >
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-r-lg text-sm hover:bg-indigo-700">
                    🔍
                </button>
            </form>

            {{-- Navigation droite --}}
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('questions.create') }}"
                       class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700">
                        + Poser une question
                    </a>

                    {{-- Menu utilisateur --}}
                    <div class="relative group">
                        <button class="flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-indigo-600">
                            <div class="w-8 h-8 bg-indigo-100 text-indigo-700 rounded-full flex items-center justify-center font-bold text-sm">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden md:inline">{{ auth()->user()->name }}</span>
                        </button>

                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100
                                    opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-150">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-xs text-gray-500">Réputation</p>
                                <p class="font-bold text-indigo-600">⭐ {{ auth()->user()->reputation }} pts</p>
                            </div>
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm hover:bg-gray-50">Mon profil</a>
                            @if(auth()->user()->isModerator())
                                <a href="{{ route('moderator.index') }}" class="block px-4 py-2 text-sm text-orange-600 hover:bg-orange-50">
                                    🛡️ Modération
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-indigo-600">Connexion</a>
                    <a href="{{ route('register') }}"
                       class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700">
                        S'inscrire
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- ── Alertes flash ── --}}
    <div class="max-w-6xl mx-auto px-4 w-full">
        @if(session('success'))
            <div class="mt-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex justify-between">
                <span>✅ {{ session('success') }}</span>
                <button onclick="this.parentElement.remove()">×</button>
            </div>
        @endif
        @if(session('error'))
            <div class="mt-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex justify-between">
                <span>❌ {{ session('error') }}</span>
                <button onclick="this.parentElement.remove()">×</button>
            </div>
        @endif
    </div>

    {{-- ── Contenu principal ── --}}
    <main class="flex-1 max-w-6xl mx-auto px-4 py-6 w-full">
        @yield('content')
    </main>

    {{-- ── Footer ── --}}
    <footer class="bg-white border-t border-gray-200 mt-auto py-6">
        <div class="max-w-6xl mx-auto px-4 text-center text-sm text-gray-400">
            AskCampus — Plateforme d'entraide académique entre étudiants
        </div>
    </footer>

</body>
</html>