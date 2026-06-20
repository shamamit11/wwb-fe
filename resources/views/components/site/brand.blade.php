@props([
    'compact' => false,
    'name' => config('site.name', config('app.name')),
])

<a href="/" class="flex items-center gap-3 text-[#141b2b]">
    <span @class([
        'flex items-center justify-center rounded-xl bg-[#c2410c] font-bold text-white shadow-sm',
        'h-8 w-8 text-sm' => $compact,
        'h-10 w-10 text-xl' => ! $compact,
    ])>W</span>
    <span class="font-semibold tracking-tight {{ $compact ? 'text-xl' : 'text-2xl' }}">
        {{ $name }}
    </span>
</a>
