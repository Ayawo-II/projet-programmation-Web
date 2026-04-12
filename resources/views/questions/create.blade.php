<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-primary">
                    <i class="fas fa-pen-fancy mr-1"></i> AskCampus
                </p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    Poser une question
                </h2>
                <p class="mt-3 max-w-2xl text-sm text-gray-500 leading-relaxed">
                    Pose ta question pour obtenir l'aide de la communauté. Les meilleures questions reçoivent les meilleures réponses !
                </p>
            </div>

            <a href="{{ route('questions.index') }}" class="inline-flex items-center gap-2 rounded-2xl bg-gray-100 px-5 py-3 text-sm font-semibold text-gray-900 shadow-lg transition-all hover:bg-gray-200">
                <i class="fas fa-arrow-left"></i>
                Retour
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-6xl space-y-8 px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 lg:grid-cols-3">
                <!-- Formulaire (colonne principale) -->
                <div class="lg:col-span-2">
                    <form method="POST" action="{{ route('questions.store') }}" class="rounded-2xl bg-white p-8 shadow-lg space-y-6">
                        @csrf

                        <!-- Titre -->
                        <div>
                            <label for="title" class="block text-sm font-bold text-gray-900">
                                <i class="fas fa-heading mr-2 text-primary"></i> Quel est votre problème principal ?
                            </label>
                            <input 
                                type="text" 
                                id="title"
                                name="title"
                                value="{{ old('title') }}"
                                maxlength="180"
                                placeholder="Ex: Comment utiliser les middlewares dans Laravel ?"
                                class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-900 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                                required
                            />
                            <div class="mt-2 flex items-center justify-between text-xs">
                                <p class="text-gray-600">Min: 15 caractères | Max: 180</p>
                                <span id="titleCount" class="font-semibold text-gray-600">0/180</span>
                            </div>
                            @error('title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="body" class="block text-sm font-bold text-gray-900">
                                <i class="fas fa-align-left mr-2 text-primary"></i> Décrivez précisément votre question
                            </label>
                            <textarea 
                                id="body"
                                name="body"
                                rows="8"
                                placeholder="Entrez les détails ici... (minimum 50 caractères)"
                                class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-900 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                                required
                            ></textarea>
                            <div class="mt-2 flex items-center justify-between text-xs">
                                <p class="text-gray-600">Minimum 50 caractères</p>
                                <span id="bodyCount" class="font-semibold text-gray-600">0</span>
                            </div>
                            @error('body')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tags -->
                        <div>
                            <label class="block text-sm font-bold text-gray-900">
                                <i class="fas fa-tags mr-2 text-primary"></i> Ajoutez 2 à 5 tags pertinents
                            </label>
                            <div class="mt-2 rounded-xl border border-gray-300 bg-white p-4">
                                <div id="tagsContainer" class="mb-4 flex flex-wrap gap-2">
                                    @if(old('tags'))
                                        @foreach(old('tags') as $tag)
                                            <div class="inline-flex items-center gap-2 rounded-full bg-primary px-4 py-2 text-sm text-white">
                                                {{ $tag }}
                                                <button type="button" class="removeTag text-white hover:opacity-70">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <input 
                                    type="text" 
                                    id="tagInput"
                                    placeholder="Tapez un tag et appuyez sur Entrée"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                                />
                            </div>
                            <div class="mt-2 text-xs text-gray-600">
                                <span id="tagCount">0</span> / 5 tags
                            </div>
                            <div id="tagsHidden"></div>
                            @error('tags')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Guide qualité -->
                        <div class="rounded-xl border border-green-200 bg-green-50 p-6">
                            <p class="mb-3 font-semibold text-green-900">
                                <i class="fas fa-check-circle mr-2 text-green-600"></i> Une bonne question contient :
                            </p>
                            <ul class="space-y-2 text-sm text-green-800">
                                <li><input type="checkbox" id="guide1" disabled /> Titre précis (15+ caractères)</li>
                                <li><input type="checkbox" id="guide2" disabled /> Description détaillée (50+ caractères)</li>
                                <li><input type="checkbox" id="guide3" disabled /> Ce que vous avez essayé</li>
                                <li><input type="checkbox" id="guide4" disabled /> 2-5 tags pertinents</li>
                            </ul>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-3">
                            <button 
                                type="submit"
                                id="submitBtn"
                                class="inline-flex items-center gap-2 rounded-xl bg-primary px-6 py-3 text-sm font-semibold text-white shadow-lg transition-all hover:bg-primary-dark disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                <i class="fas fa-paper-plane"></i> Publier la question
                            </button>
                            <button 
                                type="reset"
                                class="inline-flex items-center gap-2 rounded-xl bg-gray-200 px-6 py-3 text-sm font-semibold text-gray-900 hover:bg-gray-300"
                            >
                                <i class="fas fa-redo"></i> Réinitialiser
                            </button>
                            <a href="{{ route('questions.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-gray-300 px-6 py-3 text-sm font-semibold text-gray-900 hover:bg-gray-50">
                                <i class="fas fa-times"></i> Annuler
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Sidebar Droite - Questions similaires -->
                <div class="lg:col-span-1">
                    <div class="sticky top-20 rounded-2xl border border-blue-200 bg-blue-50 p-6 shadow-md">
                        <h3 class="flex items-center gap-2 text-sm font-bold text-blue-900 mb-4">
                            <i class="fas fa-lightbulb text-blue-600"></i>
                            Questions similaires
                        </h3>
                        <div id="similarPanel" class="space-y-3">
                            <p class="text-xs text-blue-700">En train de taper votre question...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const titleInp = document.getElementById('title');
        const bodyInp = document.getElementById('body');
        const tagInp = document.getElementById('tagInput');
        const tagsCont = document.getElementById('tagsContainer');
        const tagsHidden = document.getElementById('tagsHidden');
        const tagCountEl = document.querySelector('#tagCount');
        const submitBtn = document.getElementById('submitBtn');
        const titleCountEl = document.getElementById('titleCount');
        const bodyCountEl = document.getElementById('bodyCount');
        const similarPanel = document.getElementById('similarPanel');
        
        let tags = [];
        let debounceTimer = null;

        @if(old('tags'))
            tags = @json(old('tags'));
            renderTags();
        @endif

        titleInp.addEventListener('input', () => {
            titleCountEl.textContent = titleInp.value.length + '/180';
            updateGuide();
            
            // Debounce la recherche de questions similaires (1 seconde)
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                searchSimilarQuestions();
            }, 1000);
        });

        bodyInp.addEventListener('input', () => {
            bodyCountEl.textContent = bodyInp.value.length;
            updateGuide();
        });

        tagInp.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                const tag = tagInp.value.trim();
                if (tag && !tags.includes(tag) && tags.length < 5) {
                    tags.push(tag);
                    renderTags();
                    tagInp.value = '';
                    updateGuide();
                }
            }
        });

        function renderTags() {
            tagsCont.innerHTML = tags.map((tag, idx) => `
                <div class="inline-flex items-center gap-2 rounded-full bg-primary px-4 py-2 text-sm text-white">
                    ${tag}
                    <button type="button" data-idx="${idx}" class="removeTag text-white hover:opacity-70">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `).join('');

            tagsHidden.innerHTML = tags.map((tag, idx) => 
                `<input type="hidden" name="tags[${idx}]" value="${tag.replace(/"/g, '&quot;')}">`
            ).join('');

            tagCountEl.textContent = tags.length;

            document.querySelectorAll('.removeTag').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const idx = parseInt(btn.dataset.idx);
                    tags.splice(idx, 1);
                    renderTags();
                    updateGuide();
                });
            });
        }

        function updateGuide() {
            document.getElementById('guide1').checked = titleInp.value.length >= 15;
            document.getElementById('guide2').checked = bodyInp.value.length >= 50;
            document.getElementById('guide3').checked = bodyInp.value.length > 0;
            document.getElementById('guide4').checked = tags.length >= 2 && tags.length <= 5;

            const allOk = document.getElementById('guide1').checked &&
                         document.getElementById('guide2').checked &&
                         document.getElementById('guide4').checked;
            submitBtn.disabled = !allOk;
        }

        // Recherche de questions similaires avec AJAX
        async function searchSimilarQuestions() {
            const title = titleInp.value.trim();
            
            if (title.length < 10) {
                similarPanel.innerHTML = '<p class="text-xs text-blue-700">Tapez au moins 10 caractères...</p>';
                return;
            }

            try {
                const response = await fetch(`{{ route('api.questions.similar') }}?title=${encodeURIComponent(title)}`);
                const data = await response.json();
                
                if (!data.questions || data.questions.length === 0) {
                    similarPanel.innerHTML = '<p class="text-xs text-blue-700 italic">Aucune question similaire trouvée</p>';
                    return;
                }

                similarPanel.innerHTML = data.questions.map(q => `
                    <a href="${q.url}" target="_blank" class="block rounded-lg border border-blue-200 bg-white p-3 hover:border-blue-300 hover:shadow-sm transition-all">
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-gray-900 line-clamp-2">${q.title}</p>
                                <p class="mt-1 text-xs text-gray-600 line-clamp-1">${q.excerpt}</p>
                            </div>
                            ${q.is_solved ? '<span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2 py-0.5 text-xs font-semibold text-green-700 whitespace-nowrap"><i class="fas fa-check-circle"></i> Résolu</span>' : ''}
                        </div>
                    </a>
                `).join('');
            } catch (error) {
                console.error('Erreur lors de la recherche:', error);
                similarPanel.innerHTML = '<p class="text-xs text-red-700">Erreur lors de la recherche</p>';
            }
        }

        updateGuide();
    </script>
</x-app-layout>
