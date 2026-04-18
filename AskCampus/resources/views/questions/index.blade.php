@extends('layouts.app')

@section('title', 'Questions')

@section('content')
<div class="flex gap-6">

    {{-- ── Colonne principale ── --}}
    <div class="flex-1 min-w-0">

        {{-- En-tête --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    @if(request('search'))
                        Résultats pour « {{ request('search') }} »
                    @elseif(request('tag'))
                        Questions : #{{ request('tag') }}
                    @else
                        Toutes les questions
                    @endif
                </h1>
                <p class="text-sm text-gray-500 mt-1">{{ $questions->total() }} question(s) trouvée(s)</p>
            </div>
            @auth
                <a href="{{ route('questions.create') }}"
                   class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg font-medium hover:bg-indigo-700 text-sm">
                    + Poser une question
                </a>
            @endauth
        </div>

        {{-- Filtres de tri --}}
        <div class="flex gap-2 mb-4 border-b border-gray-200 pb-3">
            @foreach(['recent' => '🕐 Récentes', 'votes' => '⭐ Mieux votées', 'unsolved' => '❓ Non résolues'] as $key => $label)
                <a href="{{ request()->fullUrlWithQuery(['sort' => $key]) }}"
                   class="px-4 py-1.5 rounded-full text-sm font-medium transition
                          {{ $sort === $key
                             ? 'bg-indigo-600 text-white'
                             : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- Liste des questions --}}
        @forelse($questions as $question)
            <div class="mb-3">
                <x-question-card :question="$question" />
            </div>
        @empty
            <div class="text-center py-16 text-gray-400">
                <div class="text-5xl mb-4">🔍</div>
                <p class="text-lg font-medium">Aucune question trouvée</p>
                <p class="text-sm mt-1">Soyez le premier à poser une question !</p>
                @auth
                    <a href="{{ route('questions.create') }}"
                       class="mt-4 inline-block bg-indigo-600 text-white px-5 py-2 rounded-lg text-sm">
                        Poser une question
                    </a>
                @endauth
            </div>
        @endforelse

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $questions->links() }}
        </div>
    </div>

    {{-- ── Sidebar tags ── --}}
    <aside class="hidden lg:block w-64 shrink-0">
        <div class="bg-white rounded-xl border border-gray-200 p-4 sticky top-20">
            <h2 class="font-semibold text-gray-800 mb-3">🏷️ Tags populaires</h2>
            <div class="flex flex-wrap gap-2">
                @foreach($tags as $tag)
                    <x-tag-badge :tag="$tag" />
                @endforeach
            </div>

            @if(request('tag') || request('search'))
                <a href="{{ route('home') }}"
                   class="mt-4 block text-center text-sm text-indigo-600 hover:underline">
                    ← Voir toutes les questions
                </a>
            @endif
        </div>
    </aside>

</div>
@endsection