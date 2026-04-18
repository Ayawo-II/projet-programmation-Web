@extends('layouts.app')
@section('title', 'Mon profil')

@section('content')
<div class="max-w-3xl mx-auto">

    {{-- Carte profil --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 bg-indigo-100 text-indigo-700 rounded-full flex items-center justify-center text-2xl font-bold">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900">{{ $user->name }}</h1>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                <span class="inline-block mt-1 text-xs px-2 py-0.5 rounded-full font-medium
                             {{ $user->isModerator() ? 'bg-orange-100 text-orange-700' : 'bg-indigo-100 text-indigo-700' }}">
                    {{ $user->isModerator() ? '🛡️ Modérateur' : '🎓 Étudiant' }}
                </span>
            </div>
        </div>

        {{-- Réputation --}}
        <div class="mt-5 p-4 bg-indigo-50 rounded-xl border border-indigo-100">
            <div class="flex items-center justify-between mb-2">
                <h2 class="font-semibold text-indigo-800">⭐ Réputation</h2>
                <span class="text-2xl font-bold text-indigo-600">{{ $user->reputation }} pts</span>
            </div>
            <p class="text-xs text-indigo-600">
                La réputation reflète votre contribution à la communauté. Elle augmente quand vos réponses aident les autres.
            </p>
            {{-- Barre de niveau --}}
            @php
                $level = match(true) {
                    $user->reputation >= 500 => ['Expert', 'bg-purple-500', 100],
                    $user->reputation >= 200 => ['Avancé', 'bg-blue-500', min(100, ($user->reputation - 200) / 3)],
                    $user->reputation >= 50  => ['Intermédiaire', 'bg-green-500', min(100, ($user->reputation - 50) / 1.5)],
                    default                  => ['Débutant', 'bg-gray-400', min(100, $user->reputation * 2)],
                };
            @endphp
            <div class="mt-3">
                <div class="flex justify-between text-xs text-indigo-700 mb-1">
                    <span>{{ $level[0] }}</span>
                    <span>{{ round($level[2]) }}%</span>
                </div>
                <div class="bg-indigo-100 rounded-full h-2">
                    <div class="h-2 rounded-full {{ $level[1] }} transition-all" style="width: {{ $level[2] }}%"></div>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-4 mt-5 text-center">
            <div class="bg-gray-50 rounded-lg p-3">
                <div class="text-xl font-bold text-gray-800">{{ $user->questions->count() }}</div>
                <div class="text-xs text-gray-500">Questions posées</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-3">
                <div class="text-xl font-bold text-gray-800">{{ $user->answers->count() }}</div>
                <div class="text-xs text-gray-500">Réponses données</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-3">
                <div class="text-xl font-bold text-gray-800">{{ $totalVotesReceived }}</div>
                <div class="text-xs text-gray-500">Votes reçus</div>
            </div>
        </div>
    </div>

    {{-- Dernières questions --}}
    @if($user->questions->count())
        <div class="bg-white rounded-xl border border-gray-200 p-5 mb-4">
            <h2 class="font-bold text-gray-800 mb-4">📝 Mes dernières questions</h2>
            <div class="space-y-3">
                @foreach($user->questions as $q)
                    <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                        <a href="{{ route('questions.show', $q) }}"
                           class="text-sm text-gray-700 hover:text-indigo-600 flex-1 mr-4">
                            {{ Str::limit($q->title, 60) }}
                        </a>
                        <div class="flex items-center gap-2 shrink-0">
                            @if($q->is_solved)
                                <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">✅ Résolue</span>
                            @endif
                            <span class="text-xs text-gray-400">{{ $q->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Dernières réponses --}}
    @if($user->answers->count())
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="font-bold text-gray-800 mb-4">💬 Mes dernières réponses</h2>
            <div class="space-y-3">
                @foreach($user->answers as $a)
                    <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                        <div class="flex-1 mr-4">
                            <a href="{{ route('questions.show', $a->question) }}"
                               class="text-sm text-gray-700 hover:text-indigo-600">
                                → {{ Str::limit($a->question->title, 55) }}
                            </a>
                            <p class="text-xs text-gray-400 mt-0.5">{{ Str::limit($a->body, 60) }}</p>
                        </div>
                        @if($a->is_accepted)
                            <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full shrink-0">✅ Acceptée</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection