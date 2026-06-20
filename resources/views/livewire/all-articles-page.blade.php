<main class="px-6 py-10 lg:px-8 lg:py-14">
    <section class="mx-auto max-w-7xl">
        <div class="flex flex-col gap-6 border-b border-slate-200 pb-10 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-2xl">
                <h1 @class([
                    'font-extrabold tracking-tight text-slate-950',
                    'text-4xl md:text-6xl' => $activeCategory === 'all',
                    'text-4xl md:text-5xl lg:text-[3.25rem]' => $activeCategory !== 'all',
                ])>{{ $pageTitle }}</h1>
                <p class="mt-4 text-lg leading-8 text-slate-600">
                    {{ $pageDescription }}
                </p>
            </div>

        </div>

        <div class="mt-8 flex flex-wrap gap-3">
            @foreach ($filters as $filter)
                <a href="{{ $filter['slug'] === 'all' ? route('articles.index') : route('articles.category', ['category' => $filter['slug']]) }}"
                    wire:navigate @class([
                        'rounded-full border px-4 py-2 text-sm font-semibold transition-colors',
                        'border-[#c2410c] bg-[#c2410c] text-white shadow-sm' =>
                            $activeCategory === $filter['slug'],
                        'border-slate-200 bg-white text-slate-600 hover:border-orange-200 hover:text-[#c2410c]' =>
                            $activeCategory !== $filter['slug'],
                    ])>
                    {{ $filter['label'] }}
                </a>
            @endforeach
        </div>

        @if ($leadArticle)
            <div class="mt-10 grid gap-6 xl:grid-cols-[minmax(0,2fr)_minmax(320px,1fr)]">
                <article class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                    <div class="grid xl:grid-cols-[1.4fr_0.9fr]">
                        <div class="min-h-80 overflow-hidden">
                            <a href="{{ route('articles.show', $leadArticle['slug']) }}">
                                <img src="{{ $leadArticle['image'] }}" alt="{{ $leadArticle['title'] }}"
                                    class="h-full w-full object-cover">
                            </a>
                        </div>
                        <div class="flex flex-col p-8">
                            <span
                                class="text-xs font-semibold uppercase tracking-[0.22em] text-[#c2410c]">{{ $leadArticle['category'] }}</span>
                            <h2 class="mt-4 text-3xl font-bold leading-tight tracking-tight text-slate-950">
                                <a href="{{ route('articles.show', $leadArticle['slug']) }}"
                                    class="transition-colors hover:text-[#c2410c]">
                                    {{ $leadArticle['title'] }}
                                </a>
                            </h2>
                            <p class="mt-4 text-base leading-7 text-slate-600">
                                {{ $leadArticle['excerpt'] }}
                            </p>
                            <div class="mt-auto pt-8 text-sm text-slate-500">
                                <div class="flex items-center gap-3">
                                    <span class="h-4 w-4 rounded-full bg-orange-100"></span>
                                    <span>{{ $leadArticle['author'] }}</span>
                                </div>
                                <div class="mt-1">
                                    {{ $leadArticle['date'] }} • {{ $leadArticle['read_time'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </article>

                @if ($spotlightArticle)
                    <article
                        class="group flex h-full flex-col overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition-all hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-900/10">
                        <div class="h-64 overflow-hidden">
                            <a href="{{ route('articles.show', $spotlightArticle['slug']) }}">
                                <img src="{{ $spotlightArticle['image'] }}" alt="{{ $spotlightArticle['title'] }}"
                                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                            </a>
                        </div>
                        <div class="flex flex-1 flex-col p-6">
                            <span
                                class="text-xs font-semibold uppercase tracking-[0.22em] text-[#c2410c]">{{ $spotlightArticle['category'] }}</span>
                            <h3 class="mt-4 text-3xl font-bold leading-tight tracking-tight text-slate-950">
                                <a href="{{ route('articles.show', $spotlightArticle['slug']) }}"
                                    class="transition-colors hover:text-[#c2410c]">
                                    {{ $spotlightArticle['title'] }}
                                </a>
                            </h3>
                            <p class="mt-4 text-base leading-7 text-slate-600">
                                {{ $spotlightArticle['excerpt'] }}
                            </p>
                            <div class="mt-auto flex items-center justify-between gap-4 pt-6 text-sm text-slate-500">
                                <span>{{ $spotlightArticle['author'] }} • {{ $spotlightArticle['read_time'] }}</span>
                                <x-site.icon name="arrow_forward" />
                            </div>
                        </div>
                    </article>
                @endif
            </div>
        @endif

        <div class="mt-6 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($gridArticles as $article)
                <article
                    class="group flex h-full flex-col overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition-all hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-900/10">
                    <div class="h-60 overflow-hidden">
                        <a href="{{ route('articles.show', $article['slug']) }}">
                            <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                        </a>
                    </div>
                    <div class="flex flex-1 flex-col p-6">
                        <span
                            class="text-xs font-semibold uppercase tracking-[0.22em] text-[#c2410c]">{{ $article['category'] }}</span>
                        <h2 class="mt-4 text-2xl font-bold leading-tight tracking-tight text-slate-950">
                            <a href="{{ route('articles.show', $article['slug']) }}"
                                class="transition-colors hover:text-[#c2410c]">
                                {{ $article['title'] }}
                            </a>
                        </h2>
                        <p class="mt-4 text-base leading-7 text-slate-600">
                            {{ $article['excerpt'] }}
                        </p>
                        <div class="mt-auto flex items-center justify-between gap-4 pt-6 text-sm text-slate-500">
                            <span>{{ $article['author'] }} • {{ $article['read_time'] }}</span>
                            <x-site.icon name="arrow_forward" />
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        @if ($totalFiltered === 0)
            <div class="mt-10 rounded-xl border border-dashed border-slate-300 bg-white p-8 text-center text-slate-500">
                No articles match this category yet.
            </div>
        @endif

        <div class="mt-10 flex flex-col items-center">
            @if ($hasMore)
                <button type="button" wire:click="loadMore"
                    class="inline-flex items-center gap-2 rounded-xl bg-[#141b2b] px-8 py-4 text-sm font-semibold text-white shadow-lg shadow-slate-900/10 transition-colors hover:bg-[#c2410c]">
                    <span>Load More Articles</span>
                    <x-site.icon name="keyboard_arrow_down" />
                </button>
            @endif

            <p class="mt-4 text-sm text-slate-500">
                Showing {{ $visibleTotal }} of {{ $totalFiltered }} articles
            </p>
        </div>
    </section>
</main>
