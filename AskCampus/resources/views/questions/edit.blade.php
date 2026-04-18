@extends('layouts.app')
@section('title', 'Modifier la question')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">✏️ Modifier la question</h1>

        <form method="POST" action="{{ route('questions.update', $question) }}">
            @csrf @method('PUT')

            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Titre</label>
                <input type="text" name="title" value="{{ old('title', $question->title) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
                <textarea name="body" rows="8"
                          class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">{{ old('body', $question->body) }}</textarea>
                @error('body') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tags</label>
                <div class="flex flex-wrap gap-2">
                    @foreach($tags as $tag)
                        <label class="cursor-pointer">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="hidden peer"
                                   {{ $question->tags->contains($tag->id) ? 'checked' : '' }}>
                            <span class="inline-block px-3 py-1.5 rounded-full text-sm border border-gray-300
                                         text-gray-600 peer-checked:bg-indigo-600 peer-checked:text-white
                                         peer-checked:border-indigo-600 hover:border-indigo-400 transition">
                                # {{ $tag->name }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg font-medium hover:bg-indigo-700">
                    💾 Enregistrer
                </button>
                <a href="{{ route('questions.show', $question) }}"
                   class="bg-gray-100 text-gray-700 px-6 py-2.5 rounded-lg font-medium hover:bg-gray-200">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection