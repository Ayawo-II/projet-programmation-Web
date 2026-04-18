@extends('layouts.app')
@section('title', 'Gestion des tags')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">🏷️ Tags</h1>
        @auth
            @if(auth()->user()->isModerator())
                <a href="{{ route('tags.create') }}"
                   class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700">
                    + Nouveau tag
                </a>
            @endif
        @endauth
    </div>

    <div class="grid gap-3">
        @foreach($tags as $tag)
            <div class="bg-white rounded-xl border border-gray-200 px-5 py-4 flex items-center justify-between">
                <div>
                    <span class="font-semibold text-indigo-700"># {{ $tag->name }}</span>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $tag->description ?? 'Aucune description' }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $tag->questions_count }} question(s)</p>
                </div>
                @auth
                    @if(auth()->user()->isModerator())
                        <div class="flex gap-3">
                            <a href="{{ route('tags.edit', $tag) }}" class="text-xs text-indigo-600 hover:underline">✏️ Modifier</a>
                            <form method="POST" action="{{ route('tags.destroy', $tag) }}"
                                  onsubmit="return confirm('Supprimer ce tag ?')">
                                @csrf @method('DELETE')
                                <button class="text-xs text-red-500 hover:underline">🗑️</button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        @endforeach
    </div>
    <div class="mt-4">{{ $tags->links() }}</div>
</div>
@endsection