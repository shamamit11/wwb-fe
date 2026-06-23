<main class="px-6 py-10 lg:px-8 lg:py-14">
    <section class="mx-auto max-w-7xl">
        <div class="rounded-2xl border border-slate-200 bg-white/90 p-8 shadow-sm backdrop-blur">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-3xl">
                    <span class="text-xs font-semibold uppercase tracking-[0.22em] text-[var(--brand-accent)]">Search</span>
                    <h1 class="mt-3 text-4xl font-extrabold tracking-tight text-slate-950 md:text-5xl">
                        @if ($query !== '')
                            Results for “{{ $query }}”
                        @else
                            Search Articles
                        @endif
                    </h1>
                    <p class="mt-4 text-lg leading-8 text-slate-600">
                        @if ($query !== '')
                            {{ $resultCount }} article{{ $resultCount === 1 ? '' : 's' }} matched your search.
                        @else
                            Search across editorial guides, AI systems, SEO analysis, and creator workflows.
                        @endif
                    </p>
                </div>

                <form action="{{ route('search.index') }}" method="GET" class="w-full max-w-xl">
                    <div class="flex flex-col gap-3 sm:flex-row">
                        <input
                            type="search"
                            name="q"
                            value="{{ $query }}"
                            placeholder="Search articles, topics, or authors"
                            class="min-w-0 flex-1 rounded-xl border border-slate-200 bg-white px-5 py-3 text-base text-slate-900 outline-none transition-all placeholder:text-slate-400 focus:border-[var(--brand-accent)] focus:ring-4 focus:ring-orange-100">
                        <button type="submit" class="rounded-xl bg-[var(--brand-ink)] px-6 py-3 text-sm font-semibold text-white transition-colors hover:bg-[var(--brand-accent)]">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if ($query === '')
            <div class="mt-10 rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center text-slate-500">
                Enter a search term to explore articles.
            </div>
        @elseif ($resultCount === 0)
            <div class="mt-10 rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center">
                <h2 class="text-2xl font-bold tracking-tight text-slate-950">No articles found</h2>
                <p class="mt-3 text-base leading-7 text-slate-600">
                    Try a broader phrase or browse the article archive instead.
                </p>
                <a href="{{ route('home') }}" class="mt-6 inline-flex rounded-xl bg-[var(--brand-ink)] px-6 py-3 text-sm font-semibold text-white transition-colors hover:bg-[var(--brand-accent)]">
                    View All Articles
                </a>
            </div>
        @else
            <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($results as $article)
                    <a href="{{ route('articles.show', $article['slug']) }}" class="group flex h-full flex-col overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition-all hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-900/10">
                        <div class="h-56 overflow-hidden">
                            <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                        </div>
                        <div class="flex flex-1 flex-col p-6">
                            <span class="text-xs font-semibold uppercase tracking-[0.22em] text-[var(--brand-accent)]">{{ $article['category'] }}</span>
                            <h2 class="mt-4 text-2xl font-bold leading-tight tracking-tight text-slate-950">
                                {{ $article['title'] }}
                            </h2>
                            <p class="mt-4 text-base leading-7 text-slate-600">
                                {{ $article['excerpt'] }}
                            </p>
                            <div class="mt-auto flex items-center justify-between gap-4 pt-6 text-sm text-slate-500">
                                <span>{{ $article['author'] }} • {{ $article['read_time'] }}</span>
                                <x-site.icon name="arrow_forward" />
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </section>
</main>
