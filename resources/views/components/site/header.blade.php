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
            <button type="button" data-search-open aria-label="Search" class="rounded-full p-2 text-slate-600 transition-colors hover:bg-slate-100 hover:text-[#c2410c]">
                <x-site.icon name="search" class="align-middle" />
            </button>
            <a href="{{ route('home') }}#newsletter" class="hidden rounded-xl bg-[#141b2b] px-6 py-2 text-sm font-semibold text-white transition-colors hover:bg-[#c2410c] md:inline-flex">
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

    <div data-search-dialog class="pointer-events-none fixed inset-0 z-[60] hidden">
        <div data-search-close class="absolute inset-0 bg-slate-950/40 backdrop-blur-sm"></div>
        <div class="relative mx-auto mt-24 w-full max-w-2xl px-6">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-2xl">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold tracking-tight text-slate-950">Search Articles</h2>
                        <p class="mt-1 text-sm text-slate-500">Find articles by topic, title, or author.</p>
                    </div>
                    <button type="button" data-search-close aria-label="Close search" class="rounded-full p-2 text-slate-500 transition-colors hover:bg-slate-100 hover:text-[#c2410c]">
                        <x-site.icon name="close" />
                    </button>
                </div>

                <form action="{{ route('search.index') }}" method="GET" class="mt-6">
                    <div class="flex flex-col gap-3 sm:flex-row">
                        <input
                            type="search"
                            name="q"
                            data-search-input
                            placeholder="Search articles, topics, or authors"
                            class="min-w-0 flex-1 rounded-xl border border-slate-200 bg-white px-5 py-3 text-base text-slate-900 outline-none transition-all placeholder:text-slate-400 focus:border-[#c2410c] focus:ring-4 focus:ring-orange-100">
                        <button type="submit" class="rounded-xl bg-[#141b2b] px-6 py-3 text-sm font-semibold text-white transition-colors hover:bg-[#c2410c]">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</header>
