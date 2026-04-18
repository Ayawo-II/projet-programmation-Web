@extends('layouts.app')
@section('title', 'Poser une question')

@section('content')
<div class="max-w-3xl mx-auto">

    {{-- Guide utilisateur --}}
    <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-5 mb-6">
        <h2 class="font-bold text-indigo-800 mb-2">✍️ Comment poser une bonne question ?</h2>
        <ul class="text-sm text-indigo-700 space-y-1 list-disc list-inside">
            <li>Résumez votre problème en <strong>une phrase claire</strong> dans le titre</li>
            <li>Décrivez ce que vous avez déjà essayé</li>
            <li>Ajoutez le contexte : cours, chapitre, exercice concerné</li>
            <li>Choisissez les tags qui correspondent à votre matière</li>
        </ul>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Poser une question</h1>

        <form method="POST" action="{{ route('questions.store') }}" id="questionForm">
            @csrf

            {{-- Titre --}}
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Titre de votre question <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="title"
                    id="titleInput"
                    value="{{ old('title') }}"
                    placeholder="Ex : Comment résoudre une équation différentielle du second ordre ?"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 @error('title') border-red-400 @enderror"
                    minlength="15"
                    maxlength="255"
                >
                <div class="flex justify-between mt-1">
                    @error('title')
                        <p class="text-red-500 text-xs">{{ $message }}</p>
                    @else
                        <p class="text-gray-400 text-xs">Minimum 15 caractères. Soyez précis et concis.</p>
                    @enderror
                    <span id="titleCount" class="text-xs text-gray-400">0/255</span>
                </div>

                {{-- Suggestions de questions similaires --}}
                <div id="similarQuestions" class="hidden mt-2 bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                    <p class="text-xs font-semibold text-yellow-800 mb-2">⚠️ Des questions similaires existent déjà :</p>
                    <ul id="similarList" class="space-y-1"></ul>
                </div>
            </div>

            {{-- Description --}}
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Description détaillée <span class="text-red-500">*</span>
                </label>
                <textarea
                    name="body"
                    id="bodyInput"
                    rows="8"
                    placeholder="Expliquez votre problème en détail. Qu'est-ce que vous ne comprenez pas ? Qu'avez-vous déjà essayé ?..."
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 @error('body') border-red-400 @enderror"
                >{{ old('body') }}</textarea>
                <div class="flex justify-between mt-1">
                    @error('body')
                        <p class="text-red-500 text-xs">{{ $message }}</p>
                    @else
                        <p class="text-gray-400 text-xs">Minimum 30 caractères.</p>
                    @enderror
                    <span id="bodyCount" class="text-xs text-gray-400">0 caractères</span>
                </div>
            </div>

            {{-- Tags --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Tags <span class="text-red-500">*</span>
                    <span class="font-normal text-gray-400">(1 à 5 tags)</span>
                </label>
                @error('tags')
                    <p class="text-red-500 text-xs mb-2">{{ $message }}</p>
                @enderror
                <div class="flex flex-wrap gap-2">
                    @foreach($tags as $tag)
                        <label class="cursor-pointer">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                   class="hidden peer"
                                   {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                            <span class="inline-block px-3 py-1.5 rounded-full text-sm border border-gray-300
                                         text-gray-600 peer-checked:bg-indigo-600 peer-checked:text-white
                                         peer-checked:border-indigo-600 hover:border-indigo-400 transition">
                                # {{ $tag->name }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>

            <button type="submit"
                    class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                Publier ma question 🚀
            </button>
        </form>
    </div>
</div>

<script>
// Compteur de caractères
const titleInput = document.getElementById('titleInput');
const bodyInput  = document.getElementById('bodyInput');
const titleCount = document.getElementById('titleCount');
const bodyCount  = document.getElementById('bodyCount');

titleInput.addEventListener('input', () => {
    titleCount.textContent = titleInput.value.length + '/255';
});
bodyInput.addEventListener('input', () => {
    bodyCount.textContent = bodyInput.value.length + ' caractères';
});

// Suggestions de questions similaires
let searchTimeout;
titleInput.addEventListener('input', () => {
    clearTimeout(searchTimeout);
    const query = titleInput.value.trim();

    if (query.length < 15) {
        document.getElementById('similarQuestions').classList.add('hidden');
        return;
    }

    searchTimeout = setTimeout(async () => {
        const response = await fetch(`/api/questions/search?q=${encodeURIComponent(query)}`);
        const data = await response.json();

        if (data.length > 0) {
            const list = document.getElementById('similarList');
            list.innerHTML = data.map(q =>
                `<li><a href="/questions/${q.id}" target="_blank"
                        class="text-xs text-yellow-900 hover:underline">→ ${q.title}</a></li>`
            ).join('');
            document.getElementById('similarQuestions').classList.remove('hidden');
        } else {
            document.getElementById('similarQuestions').classList.add('hidden');
        }
    }, 600);
});
</script>
@endsection