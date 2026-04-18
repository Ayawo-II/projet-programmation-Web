@props(['tag'])
<a href="{{ route('home', ['tag' => $tag->slug]) }}"
   class="inline-block bg-indigo-50 text-indigo-700 text-xs font-medium px-2.5 py-1 rounded-full hover:bg-indigo-100 transition">
    # {{ $tag->name }}
</a>