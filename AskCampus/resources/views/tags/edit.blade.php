@extends('layouts.app')
@section('title', 'Modifier le tag')

@section('content')
<div class="max-w-lg mx-auto bg-white rounded-xl border border-gray-200 p-6">
    <h1 class="text-xl font-bold text-gray-900 mb-5">✏️ Modifier le tag</h1>
    <form method="POST" action="{{ route('tags.update', $tag) }}">
        @csrf @method('PUT')
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Nom du tag</label>
            <input type="text" name="name" value="{{ old('name', $tag->name) }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
            <input type="text" name="description" value="{{ old('description', $tag->description) }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <div class="flex gap-3">
            <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg font-medium hover:bg-indigo-700">
                💾 Enregistrer
            </button>
            <a href="{{ route('tags.index') }}"
               class="bg-gray-100 text-gray-700 px-6 py-2.5 rounded-lg font-medium hover:bg-gray-200">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection