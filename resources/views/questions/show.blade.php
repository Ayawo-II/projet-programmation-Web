<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-primary">
                    <i class="fas fa-book-open mr-1"></i> Question
                </p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    {{ $question->title }}
                </h2>
            </div>

            <a href="{{ route('questions.index') }}" class="inline-flex items-center gap-2 rounded-2xl bg-gray-100 px-5 py-3 text-sm font-semibold text-gray-900 shadow-lg transition-all hover:bg-gray-200">
                <i class="fas fa-arrow-left"></i>
                Retour
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <!-- Question -->
            <div class="rounded-2xl border border-gray-200 bg-white p-8 shadow-lg">
                <!-- Entête -->
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3">
                            <img 
                                src="https://ui-avatars.com/api/?name={{ urlencode($question->user->name) }}&background=7c3aed&color=fff"
                                alt="{{ $question->user->name }}"
                                class="h-10 w-10 rounded-full"
                            />
                            <div>
                                <p class="font-semibold text-gray-900">{{ $question->user->name }}</p>
                                <p class="text-xs text-gray-600">
                                    {{ $question->created_at->format('d M Y \à H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($question->is_solved)
                        <div class="flex items-center gap-1 rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                            <i class="fas fa-check-circle"></i>
                            Résolu
                        </div>
                    @endif
                </div>

                <!-- Corps -->
                <div class="prose prose-sm max-w-none mt-6 text-gray-700">
                    {{ nl2br(e($question->body)) }}
                </div>

                <!-- Tags -->
                <div class="mt-6 flex flex-wrap gap-2">
                    @foreach($question->tags as $tag)
                        <a 
                            href="{{ route('questions.index', ['tag' => $tag->slug]) }}"
                            class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 hover:bg-blue-100 transition-colors"
                        >
                            <i class="fas fa-tag"></i>
                            {{ $tag->name }}
                        </a>
                    @endforeach
                </div>

                <!-- Votes & Actions -->
                <div class="mt-8 flex items-center justify-between border-t border-gray-200 pt-6">
                    <div class="flex items-center gap-4">
                        <!-- Votes -->
                        <div class="flex items-center gap-2 rounded-xl bg-gray-50 px-4 py-2">
                            <form method="POST" action="{{ route('votes.question', $question) }}" class="inline">
                                @csrf
                                <input type="hidden" name="value" value="1">
                                <button 
                                    type="submit"
                                    class="text-gray-600 hover:text-primary transition-colors"
                                    title="Voter positif"
                                >
                                    <i class="fas fa-thumbs-up"></i>
                                </button>
                            </form>
                            <span class="font-semibold text-gray-900">{{ $question->score ?? 0 }}</span>
                            <form method="POST" action="{{ route('votes.question', $question) }}" class="inline">
                                @csrf
                                <input type="hidden" name="value" value="-1">
                                <button 
                                    type="submit"
                                    class="text-gray-600 hover:text-red-600 transition-colors"
                                    title="Voter négatif"
                                >
                                    <i class="fas fa-thumbs-down"></i>
                                </button>
                            </form>
                        </div>

                        <!-- Vues -->
                        <div class="flex items-center gap-2 rounded-xl bg-gray-50 px-4 py-2">
                            <i class="fas fa-eye text-gray-600"></i>
                            <span class="text-sm text-gray-600">{{ $question->views ?? 0 }} vues</span>
                        </div>
                    </div>

                    @if(Auth::check() && (Auth::id() === $question->user_id || Auth::user()->isModerator()))
                        <div class="flex items-center gap-2">
                            <button class="rounded-lg text-gray-600 hover:text-primary transition-colors p-2">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="rounded-lg text-gray-600 hover:text-red-600 transition-colors p-2">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Réponses -->
            <div class="mt-12">
                <h3 class="text-2xl font-bold text-gray-900">
                    {{ count($answers) }} 
                    {{ count($answers) === 1 ? 'Réponse' : 'Réponses' }}
                </h3>

                @if(count($answers) > 0)
                    <div class="mt-6 space-y-6">
                        @foreach($answers as $answer)
                            <div class="rounded-2xl border {{ $answer->is_accepted ? 'border-green-200 bg-green-50' : 'border-gray-200 bg-white' }} p-6 shadow-md">
                                <!-- Badge "Meilleure réponse" -->
                                @if($answer->is_accepted)
                                    <div class="mb-4 inline-flex items-center gap-2 rounded-full bg-green-600 px-4 py-1.5 text-sm font-bold text-white">
                                        <i class="fas fa-check-circle"></i>
                                        Meilleure réponse
                                    </div>
                                @elseif($answer->score >= 5)
                                    <div class="mb-4 inline-flex items-center gap-2 rounded-full bg-orange-500 px-4 py-1.5 text-sm font-bold text-white">
                                        <i class="fas fa-star"></i>
                                        Réponse utile
                                    </div>
                                @endif

                                <!-- Entête -->
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3">
                                            <img 
                                                src="https://ui-avatars.com/api/?name={{ urlencode($answer->user->name) }}&background=7c3aed&color=fff"
                                                alt="{{ $answer->user->name }}"
                                                class="h-10 w-10 rounded-full"
                                            />
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $answer->user->name }}</p>
                                                <p class="text-xs text-gray-600">
                                                    {{ $answer->created_at->format('d M Y \à H:i') }}
                                                    @if($answer->updated_at->ne($answer->created_at))
                                                        <span class="text-gray-500 ml-2">(modifié le {{ $answer->updated_at->format('d M Y \à H:i') }})</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Corps -->
                                <div class="prose prose-sm max-w-none mt-4 text-gray-700">
                                    {{ nl2br(e($answer->body)) }}
                                </div>

                                <!-- Votes & Actions -->
                                <div class="mt-6 flex items-center justify-between border-t border-gray-200 pt-4">
                                    <div class="flex items-center gap-2 rounded-xl bg-gray-50 px-4 py-2">
                                        <form method="POST" action="{{ route('votes.answer', $answer) }}" class="inline">
                                            @csrf
                                            <input type="hidden" name="value" value="1">
                                            <button 
                                                type="submit"
                                                class="text-gray-600 hover:text-primary transition-colors"
                                            >
                                                <i class="fas fa-thumbs-up"></i>
                                            </button>
                                        </form>
                                        <span class="font-semibold text-gray-900">{{ $answer->score ?? 0 }}</span>
                                        <form method="POST" action="{{ route('votes.answer', $answer) }}" class="inline">
                                            @csrf
                                            <input type="hidden" name="value" value="-1">
                                            <button 
                                                type="submit"
                                                class="text-gray-600 hover:text-red-600 transition-colors"
                                            >
                                                <i class="fas fa-thumbs-down"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        @if(Auth::check() && Auth::id() === $question->user_id && !$question->is_solved)
                                            <form method="POST" action="{{ route('votes.accept', $answer) }}" class="inline">
                                                @csrf
                                                <button 
                                                    type="submit"
                                                    class="rounded-lg font-semibold text-green-600 hover:text-green-700 transition-colors p-2"
                                                    title="Accepter comme meilleure réponse"
                                                >
                                                    <i class="fas fa-check-circle"></i>
                                                    Accepter
                                                </button>
                                            </form>
                                        @endif

                                        @if(Auth::check() && (Auth::id() === $answer->user_id || Auth::user()->isModerator()))
                                            @php
                                                $minutesElapsed = $answer->created_at->diffInMinutes(now());
                                                $canEdit = Auth::user()->isModerator() || ($minutesElapsed <= 30 && !$answer->is_accepted);
                                            @endphp

                                            @if($canEdit)
                                                <button 
                                                    type="button"
                                                    class="editAnswerBtn rounded-lg text-gray-600 hover:text-primary transition-colors p-2"
                                                    data-answer-id="{{ $answer->id }}"
                                                    data-answer-body="{{ $answer->body }}"
                                                    title="Modifier la réponse"
                                                >
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            @else
                                                <button 
                                                    type="button"
                                                    class="rounded-lg text-gray-300 cursor-not-allowed p-2"
                                                    title="Impossible d'éditer (délai dépassé ou acceptée)"
                                                    disabled
                                                >
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            @endif

                                            @if(!$answer->is_accepted)
                                                <button 
                                                    type="button"
                                                    class="deleteAnswerBtn rounded-lg text-gray-600 hover:text-red-600 transition-colors p-2"
                                                    data-answer-id="{{ $answer->id }}"
                                                    title="Supprimer la réponse"
                                                >
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="mt-6 rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50 px-6 py-12 text-center">
                        <i class="fas fa-comments text-4xl text-gray-400 mb-3"></i>
                        <p class="text-lg font-semibold text-gray-900">Aucune réponse pour le moment</p>
                        <p class="mt-2 text-sm text-gray-600">Soyez le premier à répondre !</p>
                    </div>
                @endif
            </div>

            <!-- Formulaire Réponse -->
            @if(Auth::check())
                <div class="mt-12 rounded-2xl border border-gray-200 bg-white p-8 shadow-lg">
                    <h3 class="text-xl font-bold text-gray-900">Votre réponse</h3>

                    <form method="POST" action="{{ route('answers.store', $question) }}" class="mt-6 space-y-4">
                        @csrf

                        <div>
                            <textarea 
                                name="body"
                                rows="6"
                                placeholder="Écrivez votre réponse ici..."
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-900 placeholder-gray-500 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                                required
                            ></textarea>
                            @error('body')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-3">
                            <button 
                                type="submit"
                                class="inline-flex items-center gap-2 rounded-xl bg-primary px-6 py-3 text-sm font-semibold text-white shadow-lg transition-all hover:bg-primary-dark"
                            >
                                <i class="fas fa-paper-plane"></i>
                                Publier la réponse
                            </button>
                            <button 
                                type="reset"
                                class="inline-flex items-center gap-2 rounded-xl bg-gray-200 px-6 py-3 text-sm font-semibold text-gray-900 hover:bg-gray-300 transition-colors"
                            >
                                <i class="fas fa-times"></i>
                                Annuler
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="mt-12 rounded-2xl border-2 border-dashed border-blue-300 bg-blue-50 px-6 py-8 text-center">
                    <i class="fas fa-lock text-2xl text-blue-600 mb-3"></i>
                    <p class="text-lg font-semibold text-blue-900">Connectez-vous pour répondre</p>
                    <p class="mt-2 text-sm text-blue-700">
                        Vous devez être connecté pour publier une réponse.
                    </p>
                    <a href="{{ route('login') }}" class="mt-4 inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">
                        <i class="fas fa-sign-in-alt"></i>
                        Se connecter
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Édition Réponse -->
    @if(Auth::check())
        <div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
            <div class="mx-4 max-h-screen w-full max-w-2xl overflow-y-auto rounded-2xl bg-white p-8 shadow-2xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">
                        <i class="fas fa-edit mr-2 text-primary"></i> Modifier votre réponse
                    </h3>
                    <button id="closeEditModal" type="button" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>

                <form id="editForm" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <textarea 
                            id="editBody"
                            name="body"
                            rows="8"
                            placeholder="Modifiez votre réponse..."
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-900 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                            required
                        ></textarea>
                        <p class="mt-2 text-xs text-gray-600">Minimum 20 caractères</p>
                    </div>

                    <div class="flex gap-3">
                        <button 
                            type="submit"
                            class="inline-flex items-center gap-2 rounded-xl bg-primary px-6 py-3 text-sm font-semibold text-white hover:bg-primary-dark transition-colors"
                        >
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                        <button 
                            type="button"
                            id="closeEditBtn"
                            class="inline-flex items-center gap-2 rounded-xl bg-gray-200 px-6 py-3 text-sm font-semibold text-gray-900 hover:bg-gray-300"
                        >
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Suppression Réponse -->
        <div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
            <div class="mx-4 max-w-md rounded-2xl bg-white p-8 shadow-2xl">
                <div class="text-center">
                    <i class="fas fa-trash text-4xl text-red-600 mb-4"></i>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Supprimer la réponse ?</h3>
                    <p class="text-sm text-gray-600 mb-6">
                        Cette action est irréversible. La réponse sera complètement supprimée.
                    </p>
                </div>

                <form id="deleteForm" method="POST" class="space-y-4">
                    @csrf
                    @method('DELETE')

                    <div class="flex gap-3">
                        <button 
                            type="submit"
                            class="flex-1 rounded-xl bg-red-600 px-4 py-3 text-sm font-semibold text-white hover:bg-red-700 transition-colors"
                        >
                            <i class="fas fa-trash mr-1"></i> Supprimer
                        </button>
                        <button 
                            type="button"
                            id="closeDeleteBtn"
                            class="flex-1 rounded-xl bg-gray-200 px-4 py-3 text-sm font-semibold text-gray-900 hover:bg-gray-300"
                        >
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            const editModal = document.getElementById('editModal');
            const deleteModal = document.getElementById('deleteModal');
            const editForm = document.getElementById('editForm');
            const deleteForm = document.getElementById('deleteForm');
            const editBody = document.getElementById('editBody');

            // Boutons édition
            document.querySelectorAll('.editAnswerBtn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const answerId = btn.dataset.answerId;
                    const body = btn.dataset.answerBody;
                    
                    editBody.value = body;
                    editForm.action = `{{ route('answers.update', ':id') }}`.replace(':id', answerId);
                    editModal.classList.remove('hidden');
                    editModal.classList.add('flex');
                    editBody.focus();
                });
            });

            // Fermer modal édition
            document.getElementById('closeEditModal').addEventListener('click', closeEditModal);
            document.getElementById('closeEditBtn').addEventListener('click', closeEditModal);
            
            function closeEditModal() {
                editModal.classList.add('hidden');
                editModal.classList.remove('flex');
            }

            // Clic en dehors ferme la modal
            editModal.addEventListener('click', (e) => {
                if (e.target === editModal) closeEditModal();
            });

            // Boutons suppression
            document.querySelectorAll('.deleteAnswerBtn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const answerId = btn.dataset.answerId;
                    deleteForm.action = `{{ route('answers.destroy', ':id') }}`.replace(':id', answerId);
                    deleteModal.classList.remove('hidden');
                    deleteModal.classList.add('flex');
                });
            });

            // Fermer modal suppression
            document.getElementById('closeDeleteBtn').addEventListener('click', closeDeleteModal);
            
            function closeDeleteModal() {
                deleteModal.classList.add('hidden');
                deleteModal.classList.remove('flex');
            }

            // Clic en dehors ferme la modal
            deleteModal.addEventListener('click', (e) => {
                if (e.target === deleteModal) closeDeleteModal();
            });
        </script>
    @endif
</x-app-layout>
