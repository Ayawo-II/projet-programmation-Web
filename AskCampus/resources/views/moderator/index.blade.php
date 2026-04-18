@extends('layouts.app')
@section('title', 'Modération')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">🛡️ Espace Modération</h1>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Question</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Auteur</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Statut</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($questions as $question)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <a href="{{ route('questions.show', $question) }}"
                           class="text-indigo-600 hover:underline font-medium">
                            {{ Str::limit($question->title, 50) }}
                        </a>
                    </td>
                    <td class="px-4 py-3 text-gray-500">{{ $question->user->name }}</td>
                    <td class="px-4 py-3">
                        <div class="flex gap-1 flex-wrap">
                            @if($question->is_solved)
                                <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">✅ Résolue</span>
                            @endif
                            @if($question->is_closed)
                                <span class="text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded-full">🔒 Fermée</span>
                            @endif
                            @if(!$question->is_solved && !$question->is_closed)
                                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">Ouverte</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex gap-2">
                            <form method="POST" action="{{ route('moderator.toggleClose', $question) }}">
                                @csrf @method('PATCH')
                                <button class="text-xs text-orange-600 hover:underline">
                                    {{ $question->is_closed ? '🔓 Rouvrir' : '🔒 Fermer' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('moderator.destroyQuestion', $question) }}"
                                  onsubmit="return confirm('Supprimer ?')">
                                @csrf @method('DELETE')
                                <button class="text-xs text-red-600 hover:underline">🗑️ Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-4 py-3 border-t border-gray-100">
            {{ $questions->links() }}
        </div>
    </div>

    <div class="mt-6 flex gap-3">
        <a href="{{ route('tags.index') }}"
           class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-indigo-700">
            🏷️ Gérer les tags
        </a>
    </div>
</div>
@endsection