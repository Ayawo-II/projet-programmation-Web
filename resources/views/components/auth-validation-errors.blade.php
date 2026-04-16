@props(['errors'])

@if ($errors->any())
    <div {{ $attributes->merge(['class' => 'rounded-3xl border border-rose-300/20 bg-rose-500/10 p-4 text-sm text-rose-100']) }}>
        <div class="font-semibold text-rose-100">{{ __('Whoops! Something went wrong.') }}</div>
        <ul class="mt-3 list-disc space-y-1 pl-5 text-rose-200">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
