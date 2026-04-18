@props(['model', 'type'])
<div class="flex flex-col items-center gap-1">
    {{-- Upvote --}}
    <form method="POST" action="{{ route('votes.store', [$type, $model->id]) }}">
        @csrf
        <input type="hidden" name="value" value="1">
        <button type="submit"
                class="w-9 h-9 rounded-lg flex items-center justify-center transition
                       {{ $model->userVote() === 1
                          ? 'bg-indigo-600 text-white'
                          : 'bg-gray-100 text-gray-500 hover:bg-indigo-50 hover:text-indigo-600' }}">
            ▲
        </button>
    </form>

    {{-- Score --}}
    <span class="font-bold text-lg {{ $model->voteScore() > 0 ? 'text-indigo-600' : ($model->voteScore() < 0 ? 'text-red-500' : 'text-gray-500') }}">
        {{ $model->voteScore() }}
    </span>

    {{-- Downvote --}}
    <form method="POST" action="{{ route('votes.store', [$type, $model->id]) }}">
        @csrf
        <input type="hidden" name="value" value="-1">
        <button type="submit"
                class="w-9 h-9 rounded-lg flex items-center justify-center transition
                       {{ $model->userVote() === -1
                          ? 'bg-red-500 text-white'
                          : 'bg-gray-100 text-gray-500 hover:bg-red-50 hover:text-red-500' }}">
            ▼
        </button>
    </form>
</div>