@extends('layouts.app')
@section('title', $question->title)

@section('content')
<div class="flex gap-6">
<div class="flex-1 min-w-0">

{{-- ── La Question ── --}}
<div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">

    {{-- Badges statut --}}
    <div class="flex gap-2 mb-3 flex-wrap">
        @if($question->is_solved)
            <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full">✅ Résolue</span>
        @endif
        @if($question->is_closed)
            <span class="bg-red-100 text-red-700 text-xs font-bold px-3 py-1 rounded-full">🔒 Fermée</span>
        @endif
    </div>

    <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ $question->title }}</h1>

    {{-- Meta --}}
    <div class="flex items-center gap-4 text-xs text-gray-400 mb-5 flex-wrap">
        <span>par <strong class="text-gray-600">{{ $question->user->name }}</strong></span>
        <span>{{ $question->created_at->diffForHumans() }}</span>
        <span>👁 {{ $question->views }} vues</span>
        <span>💬 {{ $answers->count() }} réponse(s)</span>
    </div>

    <div class="flex gap-5">
        {{-- Votes question --}}
        @auth
            <x-vote-buttons :model="$question" type="question" />
        @else
            <div class="flex flex-col items-center gap-1 text-gray-400">
                <span class="text-2xl font-bold">{{ $question->voteScore() }}</span>
                <span class="text-xs">votes</span>
            </div>
        @endauth

        {{-- Corps de la question --}}
        <div class="flex-1 min-w-0">
            <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed">
                {!! nl2br(e($question->body)) !!}
            </div>

            {{-- Tags --}}
            <div class="flex flex-wrap gap-2 mt-5 pt-4 border-t border-gray-100">
                @foreach($question->tags as $tag)
                    <x-tag-badge :tag="$tag" />
                @endforeach
            </div>

            {{-- Actions auteur --}}
            @auth
                @if(auth()->id() === $question->user_id)
                    <div class="flex gap-3 mt-4 pt-3 border-t border-gray-100">
                        <a href="{{ route('questions.edit', $question) }}"
                           class="text-xs text-gray-500 hover:text-indigo-600">✏️ Modifier</a>
                        <form method="POST" action="{{ route('questions.destroy', $question) }}"
                              onsubmit="return confirm('Supprimer cette question ?')">
                            @csrf @method('DELETE')
                            <button class="text-xs text-gray-500 hover:text-red-600">🗑️ Supprimer</button>
                        </form>
                    </div>
                @endif

                {{-- Actions modérateur --}}
                @if(auth()->user()->isModerator())
                    <div class="flex gap-3 mt-3">
                        <form method="POST" action="{{ route('moderator.toggleClose', $question) }}">
                            @csrf @method('PATCH')
                            <button class="text-xs text-orange-600 hover:underline">
                                {{ $question->is_closed ? '🔓 Rouvrir' : '🔒 Fermer' }}
                            </button>
                        </form>
                        <form method="POST" action="{{ route('moderator.destroyQuestion', $question) }}"
                              onsubmit="return confirm('Supprimer cette question ?')">
                            @csrf @method('DELETE')
                            <button class="text-xs text-red-600 hover:underline">🗑️ Supprimer (mod)</button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</div>

{{-- ── Réponses ── --}}
<div class="mb-6">
    <h2 class="text-lg font-bold text-gray-800 mb-4">
        💬 {{ $answers->count() }} réponse(s)
    </h2>

    @forelse($answers as $answer)
        {{-- Mise en avant de la réponse acceptée --}}
        <div class="rounded-xl border p-5 mb-4 transition
                    {{ $answer->is_accepted
                       ? 'bg-green-50 border-green-400 shadow-md'
                       : 'bg-white border-gray-200' }}">

            @if($answer->is_accepted)
                <div class="flex items-center gap-2 mb-3">
                    <span class="bg-green-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                        ✅ Meilleure réponse
                    </span>
                </div>
            @endif

            <div class="flex gap-5">
                {{-- Votes réponse --}}
                @auth
                    <x-vote-buttons :model="$answer" type="answer" />
                @else
                    <div class="flex flex-col items-center gap-1 text-gray-400">
                        <span class="text-xl font-bold">{{ $answer->voteScore() }}</span>
                        <span class="text-xs">votes</span>
                    </div>
                @endauth

                {{-- Corps --}}
                <div class="flex-1 min-w-0">
                    <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed">
                        {!! nl2br(e($answer->body)) !!}
                    </div>

                    <div class="flex items-center justify-between mt-4 pt-3 border-t border-gray-100 flex-wrap gap-2">
                        <div class="text-xs text-gray-400">
                            par <strong class="text-gray-600">{{ $answer->user->name }}</strong>
                            · {{ $answer->created_at->diffForHumans() }}
                        </div>

                        <div class="flex gap-3">
                            {{-- Accepter la réponse (auteur de la question) --}}
                            @auth
                                @if(auth()->id() === $question->user_id && !$answer->is_accepted)
                                    <form method="POST" action="{{ route('answers.accept', $answer) }}">
                                        @csrf @method('PATCH')
                                        <button class="text-xs bg-green-600 text-white px-3 py-1 rounded-full hover:bg-green-700">
                                            ✅ Meilleure réponse
                                        </button>
                                    </form>
                                @endif

                                {{-- Supprimer sa réponse --}}
                                @if(auth()->id() === $answer->user_id)
                                    <form method="POST" action="{{ route('answers.destroy', $answer) }}"
                                          onsubmit="return confirm('Supprimer cette réponse ?')">
                                        @csrf @method('DELETE')
                                        <button class="text-xs text-gray-400 hover:text-red-500">🗑️ Supprimer</button>
                                    </form>
                                @endif

                                {{-- Supprimer (modérateur) --}}
                                @if(auth()->user()->isModerator() && auth()->id() !== $answer->user_id)
                                    <form method="POST" action="{{ route('moderator.destroyAnswer', $answer) }}"
                                          onsubmit="return confirm('Supprimer cette réponse ?')">
                                        @csrf @method('DELETE')
                                        <button class="text-xs text-red-500 hover:underline">🗑️ Mod</button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-10 text-gray-400 bg-white rounded-xl border border-gray-200">
            <p class="text-4xl mb-2">💭</p>
            <p>Aucune réponse pour l'instant. Soyez le premier !</p>
        </div>
    @endforelse
</div>

{{-- ── Formulaire de réponse ── --}}
@auth
    @if(!$question->is_closed)
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-bold text-gray-800 mb-4">✍️ Votre réponse</h3>
            <form method="POST" action="{{ route('answers.store', $question) }}">
                @csrf
                <textarea
                    name="body"
                    rows="6"
                    placeholder="Rédigez une réponse claire et détaillée. Expliquez votre raisonnement..."
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 @error('body') border-red-400 @enderror"
                >{{ old('body') }}</textarea>
                @error('body')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <button type="submit"
                        class="mt-3 bg-indigo-600 text-white px-6 py-2.5 rounded-lg font-medium hover:bg-indigo-700">
                    Publier ma réponse
                </button>
            </form>
        </div>
    @else
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-center text-red-700 text-sm">
            🔒 Cette question est fermée. Les nouvelles réponses ne sont pas acceptées.
        </div>
    @endif
@else
    <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 text-center">
        <p class="text-gray-600 mb-3">Connectez-vous pour répondre à cette question.</p>
        <a href="{{ route('login') }}" class="bg-indigo-600 text-white px-5 py-2 rounded-lg text-sm">Se connecter</a>
    </div>
@endauth

</div>

{{-- Sidebar --}}
<aside class="hidden lg:block w-64 shrink-0">
    <div class="bg-white rounded-xl border border-gray-200 p-4 sticky top-20">
        <h3 class="font-semibold text-gray-700 mb-2 text-sm">🏷️ Tags de cette question</h3>
        <div class="flex flex-wrap gap-2">
            @foreach($question->tags as $tag)
                <x-tag-badge :tag="$tag" />
            @endforeach
        </div>
    </div>
</aside>

</div>
@endsection