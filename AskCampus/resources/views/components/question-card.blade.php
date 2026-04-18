@props(['question'])
<div class="bg-white rounded-xl border border-gray-200 p-5 hover:border-indigo-300 hover:shadow-sm transition">
    <div class="flex gap-4">

        {{-- Stats --}}
        <div class="hidden sm:flex flex-col items-center gap-2 min-w-[60px] text-center text-sm text-gray-500">
            <div class="{{ $question->voteScore() > 0 ? 'text-indigo-600 font-bold' : '' }}">
                <div class="text-lg font-bold">{{ $question->voteScore() }}</div>
                <div class="text-xs">votes</div>
            </div>
            <div class="{{ $question->is_solved ? 'text-green-600 font-bold' : 'text-gray-400' }}">
                <div class="text-lg font-bold">{{ $question->answers_count }}</div>
                <div class="text-xs">{{ $question->is_solved ? '✅ résolu' : 'réponses' }}</div>
            </div>
        </div>

        {{-- Contenu --}}
        <div class="flex-1 min-w-0">
            <div class="flex items-start gap-2 flex-wrap mb-1">
                @if($question->is_closed)
                    <span class="text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded-full font-medium">🔒 Fermée</span>
                @endif
                @if($question->is_solved)
                    <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-medium">✅ Résolue</span>
                @endif
            </div>

            <a href="{{ route('questions.show', $question) }}"
               class="text-base font-semibold text-gray-900 hover:text-indigo-600 leading-snug block mb-2">
                {{ $question->title }}
            </a>

            <p class="text-sm text-gray-500 mb-3 line-clamp-2">
                {{ Str::limit(strip_tags($question->body), 120) }}
            </p>

            <div class="flex items-center justify-between flex-wrap gap-2">
                <div class="flex flex-wrap gap-1">
                    @foreach($question->tags as $tag)
                        <x-tag-badge :tag="$tag" />
                    @endforeach
                </div>
                <div class="text-xs text-gray-400">
                    par <span class="font-medium text-gray-600">{{ $question->user->name }}</span>
                    · {{ $question->created_at->diffForHumans() }}
                    · 👁 {{ $question->views }}
                </div>
            </div>
        </div>
    </div>
</div>