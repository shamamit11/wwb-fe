<main class="px-6 py-8 lg:px-8 lg:py-12">
    <section class="archive-shell">
        <div class="archive-hero flex flex-col gap-6 border-b border-slate-200/80 pb-8 md:pb-10">
            <div class="w-full">
                <span class="archive-kicker">{{ $activeCategory === 'all' ? 'Editorial archive' : 'Category archive' }}</span>
                <h1 class="archive-title">{{ $pageTitle }}</h1>
                <p class="archive-description mt-5">
                    {{ $pageDescription }}
                </p>
            </div>
        </div>

        <div class="mt-7 flex flex-wrap gap-3 md:gap-3.5">
            @foreach ($filters as $filter)
                <a href="{{ $filter['slug'] === 'all' ? route('home') : route('articles.category', ['category' => $filter['slug']]) }}"
                    wire:navigate @class([
                        'archive-filter',
                        'archive-filter--active' => $activeCategory === $filter['slug'],
                        'archive-filter--inactive' => $activeCategory !== $filter['slug'],
                    ])>
                    {{ $filter['label'] }}
                </a>
            @endforeach
        </div>

        @if ($leadArticle)
            <div class="mt-9 grid gap-6 xl:grid-cols-[minmax(0,1.72fr)_minmax(320px,1fr)]">
                <article class="archive-card archive-card--featured group flex h-full flex-col">
                    <div class="archive-card__media archive-card__media--featured">
                        <a href="{{ route('articles.show', $leadArticle['slug']) }}">
                            <img src="{{ $leadArticle['image'] }}" alt="{{ $leadArticle['title'] }}"
                                width="1200"
                                height="675"
                                fetchpriority="high"
                                loading="eager"
                                decoding="async"
                                sizes="(min-width: 1280px) 66rem, 100vw"
                                class="archive-card__image">
                        </a>
                    </div>
                    <div class="archive-card__body archive-card__body--featured p-7 md:p-8 lg:p-9">
                        <span class="archive-card__eyebrow">{{ $leadArticle['category'] }}</span>
                        <h2 class="archive-card__title archive-card__title--lead mt-4">
                            <a href="{{ route('articles.show', $leadArticle['slug']) }}"
                                class="transition-colors hover:text-[var(--brand-accent)]">
                                {{ $leadArticle['title'] }}
                            </a>
                        </h2>
                        <p class="archive-card__excerpt archive-card__excerpt--lead mt-4">
                            {{ $leadArticle['excerpt'] }}
                        </p>
                        <div class="archive-card__meta pt-7">
                            <div class="archive-card__meta-copy">
                                <div class="flex items-center gap-3 text-sm font-medium text-slate-600">
                                    <span class="h-2.5 w-2.5 rounded-full bg-orange-200"></span>
                                    <span>{{ $leadArticle['author'] }}</span>
                                </div>
                                <span class="mt-1 text-sm text-slate-500">
                                    {{ $leadArticle['date'] }} • {{ $leadArticle['read_time'] }}
                                </span>
                            </div>
                            <span class="archive-card__arrow">
                                <x-site.icon name="arrow_forward" />
                            </span>
                        </div>
                    </div>
                </article>

                @if ($spotlightArticle)
                    <article
                        class="archive-card group flex h-full flex-col">
                        <div class="archive-card__media h-64 md:h-72 xl:h-80">
                            <a href="{{ route('articles.show', $spotlightArticle['slug']) }}">
                                <img src="{{ $spotlightArticle['image'] }}" alt="{{ $spotlightArticle['title'] }}"
                                    width="800"
                                    height="600"
                                    loading="lazy"
                                    decoding="async"
                                    sizes="(min-width: 1280px) 22rem, (min-width: 768px) 50vw, 100vw"
                                    class="archive-card__image">
                            </a>
                        </div>
                        <div class="archive-card__body p-6 md:p-7">
                            <span class="archive-card__eyebrow">{{ $spotlightArticle['category'] }}</span>
                            <h3 class="archive-card__title archive-card__title--spotlight mt-4">
                                <a href="{{ route('articles.show', $spotlightArticle['slug']) }}"
                                    class="transition-colors hover:text-[var(--brand-accent)]">
                                    {{ $spotlightArticle['title'] }}
                                </a>
                            </h3>
                            <p class="archive-card__excerpt archive-card__excerpt--grid mt-4">
                                {{ $spotlightArticle['excerpt'] }}
                            </p>
                            <div class="archive-card__meta pt-6">
                                <div class="archive-card__meta-copy">
                                    <span>{{ $spotlightArticle['author'] }} • {{ $spotlightArticle['read_time'] }}</span>
                                </div>
                                <span class="archive-card__arrow">
                                    <x-site.icon name="arrow_forward" />
                                </span>
                            </div>
                        </div>
                    </article>
                @endif
            </div>
        @endif

        <div class="mt-6 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($gridArticles as $article)
                <article
                    class="archive-card group flex h-full flex-col">
                    <div class="archive-card__media aspect-[4/3]">
                        <a href="{{ route('articles.show', $article['slug']) }}">
                            <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}"
                                width="800"
                                height="600"
                                loading="lazy"
                                decoding="async"
                                sizes="(min-width: 1280px) 25rem, (min-width: 768px) 50vw, 100vw"
                                class="archive-card__image">
                        </a>
                    </div>
                    <div class="archive-card__body p-6 md:p-7">
                        <span class="archive-card__eyebrow">{{ $article['category'] }}</span>
                        <h2 class="archive-card__title archive-card__title--grid mt-4">
                            <a href="{{ route('articles.show', $article['slug']) }}"
                                class="transition-colors hover:text-[var(--brand-accent)]">
                                {{ $article['title'] }}
                            </a>
                        </h2>
                        <p class="archive-card__excerpt archive-card__excerpt--grid mt-4">
                            {{ $article['excerpt'] }}
                        </p>
                        <div class="archive-card__meta pt-6">
                            <div class="archive-card__meta-copy">
                                <span>{{ $article['author'] }} • {{ $article['read_time'] }}</span>
                            </div>
                            <span class="archive-card__arrow">
                                <x-site.icon name="arrow_forward" />
                            </span>
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
                    class="archive-button archive-button--primary">
                    <span>Load More Articles</span>
                    <x-site.icon name="keyboard_arrow_down" />
                </button>
            @endif

            <p class="mt-3 text-sm text-slate-500">
                Showing {{ $visibleTotal }} of {{ $totalFiltered }} articles
            </p>
        </div>

        @if ($newsletterSection['enabled'])
            <section id="newsletter" class="mt-18 border-t border-slate-200 px-2 pt-14 md:mt-20 md:pt-16">
                <div class="archive-newsletter mx-auto max-w-3xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-slate-950 md:text-4xl">
                        {{ $newsletterSection['title'] }}
                    </h2>
                    <p class="mt-5 text-lg leading-8 text-slate-600">{{ $newsletterSection['description'] }}</p>

                    @if ($newsletterToastVisible)
                        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3200)" x-show="show" x-transition
                            @class([
                                'mx-auto mt-8 max-w-xl rounded-2xl border px-5 py-4 text-left text-sm shadow-sm',
                                'border-emerald-200 bg-emerald-50 text-emerald-900' =>
                                    $newsletterToastType === 'success',
                                'border-red-200 bg-red-50 text-red-900' =>
                                    $newsletterToastType !== 'success',
                            ])>
                            {{ $newsletterToastMessage }}
                        </div>
                    @endif

                    <form class="mt-10 flex flex-col gap-4 md:flex-row md:items-stretch" wire:submit="subscribe">
                        <input type="email" wire:model.blur="newsletterEmail"
                            placeholder="{{ $newsletterSection['placeholder'] }}"
                            class="archive-newsletter__field min-w-0 flex-1 rounded-2xl border-2 border-slate-200 bg-white px-6 py-4 text-slate-900 outline-none transition-all placeholder:text-slate-400 focus:border-[var(--brand-accent)] focus:ring-4 focus:ring-orange-100">
                        <button type="submit"
                            class="archive-button archive-button--primary archive-newsletter__field px-10">
                            {{ $newsletterSection['button'] }}
                        </button>
                    </form>
                    @error('newsletterEmail')
                        <p class="mt-3 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <p class="mt-6 text-sm italic text-slate-500">{{ $newsletterSection['note'] }}</p>
                </div>
            </section>
        @endif
    </section>
</main>
