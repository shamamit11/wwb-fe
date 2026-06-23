@props([
    'compact' => false,
    'name' => config('site.name', config('app.name')),
])

<a href="/" class="flex items-center gap-3 text-[var(--brand-ink)]">
    <img
        src="{{ asset('images/wide-web-blog-icon.svg') }}"
        alt="Wide Web Blog"
        @class([
            'shrink-0 drop-shadow-[0_10px_18px_rgba(240,74,20,0.18)]',
            'h-8 w-8' => $compact,
            'h-10 w-10' => ! $compact,
        ])
    >
    <span class="font-semibold tracking-tight {{ $compact ? 'text-2xl' : 'text-3xl' }}">
        {{ $name }}
    </span>
</a>
