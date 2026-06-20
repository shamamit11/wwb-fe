@props([
    'navigation' => config('site.navigation', []),
    'active' => 'home',
])

<header data-site-header class="sticky top-0 z-50 border-b border-slate-200/70 bg-white/80 backdrop-blur-md transition-all duration-300">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-6 px-6 py-5 lg:px-8">
        <x-site.brand compact />

        <nav class="hidden items-center gap-6 xl:flex" aria-label="Primary">
            @foreach ($navigation as $item)
                <a href="{{ $item['href'] }}"
                    @class([
                        'border-b-2 pb-1 text-sm font-medium tracking-wide transition-colors',
                        'border-[#c2410c] text-[#c2410c]' => ($item['key'] ?? null) === $active,
                        'border-transparent text-slate-600 hover:text-[#c2410c]' => ($item['key'] ?? null) !== $active,
                    ])>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="flex items-center gap-3">
            <button type="button" aria-label="Search" class="rounded-full p-2 text-slate-600 transition-colors hover:bg-slate-100 hover:text-[#c2410c]">
                <x-site.icon name="search" class="align-middle" />
            </button>
            <a href="#newsletter" class="hidden rounded-xl bg-[#141b2b] px-6 py-2 text-sm font-semibold text-white transition-colors hover:bg-[#c2410c] md:inline-flex">
                Subscribe
            </a>
            <button
                type="button"
                data-mobile-toggle
                aria-controls="mobile-primary-nav"
                aria-expanded="false"
                class="rounded-full p-2 text-slate-700 xl:hidden">
                <x-site.icon name="menu" class="align-middle" />
            </button>
        </div>
    </div>

    <div id="mobile-primary-nav" data-mobile-nav class="hidden border-t border-slate-200 bg-white xl:hidden">
        <nav class="mx-auto flex max-w-7xl flex-col px-6 py-4" aria-label="Mobile primary">
            @foreach ($navigation as $item)
                <a href="{{ $item['href'] }}"
                    @class([
                        'rounded-lg px-3 py-3 text-sm font-medium transition-colors',
                        'bg-orange-50 text-[#c2410c]' => ($item['key'] ?? null) === $active,
                        'text-slate-700 hover:bg-slate-50 hover:text-[#c2410c]' => ($item['key'] ?? null) !== $active,
                    ])>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>
    </div>
</header>
