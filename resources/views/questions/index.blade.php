<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-primary">
                    <i class="fas fa-list mr-1"></i> Questions
                </p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    Toutes les questions
                </h2>
            </div>

            <a href="{{ route('questions.create') }}" class="inline-flex items-center gap-2 rounded-2xl bg-primary px-5 py-3 text-sm font-semibold text-white shadow-lg transition-all hover:bg-primary-dark">
                <i class="fas fa-pen-fancy"></i>
                Poser une question
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 lg:grid-cols-4">
                <!-- Sidebar Gauche - Tags -->
                <div class="lg:col-span-1">
                    <div class="sticky top-20">
                        <!-- Recherche -->
                        <form method="GET" class="mb-6">
                            <div class="relative">
                                <input 
                                    type="text" 
                                    name="search" 
                                    value="{{ $search }}"
                                    placeholder="Rechercher..." 
                                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder-gray-500 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                                />
                                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>

                        <!-- Tags populaires -->
                        <div class="rounded-2xl bg-white p-6 shadow-lg">
                            <h3 class="text-sm font-bold uppercase tracking-wider text-gray-900">Tags populaires</h3>
                            <div class="mt-4 flex flex-wrap gap-2">
                                @forelse($tags as $tag)
                                    <a 
                                        href="{{ route('questions.index', ['tag' => $tag->slug]) }}"
                                        class="inline-flex items-center gap-1 rounded-full {{ $selectedTag === $tag->slug ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} px-3 py-1 text-xs font-medium transition-colors"
                                    >
                                        <i class="fas fa-tag"></i>
                                        {{ $tag->name }}
                                    </a>
                                @empty
                                    <p class="text-sm text-gray-500">Aucun tag disponible</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenu Principal -->
                <div class="lg:col-span-3">
                    @if($questions->count() > 0)
                        <div class="space-y-4">
                            @foreach($questions as $question)
                                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-md transition-all hover:shadow-lg">
                                    <div class="flex gap-4">
                                        <!-- Statistiques -->
                                        <div class="flex flex-col items-center gap-3 rounded-xl bg-gray-50 px-4 py-3 min-w-fit">
                                            <div class="text-center">
                                                <div class="text-2xl font-bold text-gray-900">
                                                    {{ $question->score ?? 0 }}
                                                </div>
                                                <div class="text-xs text-gray-600">votes</div>
                                            </div>
                                            <div class="h-px w-8 bg-gray-200"></div>
                                            <div class="text-center">
                                                <div class="text-2xl font-bold text-gray-900">
                                                    {{ $question->answers_count ?? 0 }}
                                                </div>
                                                <div class="text-xs text-gray-600">réponses</div>
                                            </div>
                                        </div>

                                        <!-- Contenu -->
                                        <div class="flex-1">
                                            <div class="flex items-start justify-between gap-4">
                                                <div class="flex-1">
                                                    <a 
                                                        href="{{ route('questions.show', $question) }}"
                                                        class="text-lg font-bold text-gray-900 hover:text-primary transition-colors"
                                                    >
                                                        {{ $question->title }}
                                                    </a>
                                                    <p class="mt-2 text-sm text-gray-600 line-clamp-2">
                                                        {{ Str::limit(strip_tags($question->body), 150) }}
                                                    </p>
                                                </div>
                                                @if($question->is_solved)
                                                    <div class="flex items-center gap-1 rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                                        <i class="fas fa-check-circle"></i>
                                                        Résolu
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Tags -->
                                            <div class="mt-4 flex flex-wrap gap-2">
                                                @foreach($question->tags as $tag)
                                                    <a 
                                                        href="{{ route('questions.index', ['tag' => $tag->slug]) }}"
                                                        class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700 hover:bg-blue-100 transition-colors"
                                                    >
                                                        <i class="fas fa-tag text-xs"></i>
                                                        {{ $tag->name }}
                                                    </a>
                                                @endforeach
                                            </div>

                                            <!-- Meta -->
                                            <div class="mt-4 flex items-center justify-between text-xs text-gray-500">
                                                <span>
                                                    <i class="fas fa-user-circle mr-1"></i>
                                                    {{ $question->user->name }}
                                                </span>
                                                <span>
                                                    <i class="fas fa-calendar mr-1"></i>
                                                    {{ $question->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-8">
                            {{ $questions->links() }}
                        </div>
                    @else
                        <div class="rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50 px-6 py-12 text-center">
                            <i class="fas fa-inbox text-4xl text-gray-400 mb-3"></i>
                            <p class="text-lg font-semibold text-gray-900">Aucune question trouvée</p>
                            <p class="mt-2 text-sm text-gray-600">
                                @if($search)
                                    Essayez de modifier votre recherche
                                @else
                                    Soyez le premier à poser une question !
                                @endif
                            </p>
                            @if(!$search)
                                <a href="{{ route('questions.create') }}" class="mt-4 inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white hover:bg-primary-dark transition-colors">
                                    <i class="fas fa-plus"></i>
                                    Poser une question
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
