<main class="px-6 py-10 lg:px-8 lg:py-14">
    <article class="mx-auto max-w-7xl">
        <nav class="mb-8 flex flex-wrap items-center gap-2 text-sm text-slate-500">
            <a href="{{ route('home') }}" class="transition-colors hover:text-[#c2410c]">Home</a>
            <span>•</span>
            <a href="{{ route('articles.index') }}" class="transition-colors hover:text-[#c2410c]">Articles</a>
            <span>•</span>
            <span>{{ $article['category'] }}</span>
        </nav>

        <header class="max-w-5xl">
            <h1 class="text-4xl font-extrabold leading-tight tracking-tight text-slate-950 md:text-6xl">
                {{ $article['title'] }}
            </h1>

            <div class="mt-8 flex flex-wrap items-center gap-x-8 gap-y-5 text-sm text-slate-500">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-orange-100 text-sm font-bold text-[#c2410c]">
                        {{ collect(explode(' ', $article['author']))->map(fn (string $part): string => strtoupper(substr($part, 0, 1)))->implode('') }}
                    </span>
                    <div>
                        <div class="font-semibold text-slate-900">{{ $article['author'] }}</div>
                        <div class="uppercase tracking-[0.14em]">{{ $article['author_role'] ?? 'Editorial Team' }}</div>
                    </div>
                </div>

                <div>
                    <div class="uppercase tracking-[0.14em]">Published</div>
                    <div class="mt-1 text-slate-700">{{ $article['date'] }}</div>
                </div>

                <div>
                    <div class="uppercase tracking-[0.14em]">Read time</div>
                    <div class="mt-1 text-slate-700">{{ $article['read_time'] }}</div>
                </div>

                <div class="flex items-center gap-3 text-slate-400">
                    <button type="button" aria-label="Save article" class="rounded-full border border-slate-200 p-2 transition-colors hover:border-orange-200 hover:text-[#c2410c]">
                        <x-site.icon name="bookmark" />
                    </button>
                    <button type="button" aria-label="Share article" class="rounded-full border border-slate-200 p-2 transition-colors hover:border-orange-200 hover:text-[#c2410c]">
                        <x-site.icon name="share" />
                    </button>
                </div>
            </div>
        </header>

        <div class="mt-10 grid gap-12 xl:grid-cols-[minmax(0,1fr)_280px] xl:items-start">
            <div class="min-w-0">
                @if ($article['excerpt'] !== '')
                    <div class="max-w-3xl text-lg leading-9 text-slate-700">
                        <p>{{ $article['excerpt'] }}</p>
                    </div>
                @endif

                @if ($article['image'] !== '')
                    <figure class="mt-10 max-w-4xl overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                        <img src="{{ $article['image'] }}" alt="{{ $article['image_alt'] }}" class="h-auto w-full object-cover">
                    </figure>
                @endif

                @if (! empty($article['caption']))
                    <figcaption class="mt-3 max-w-4xl text-sm italic text-slate-500">
                        {{ $article['caption'] }}
                    </figcaption>
                @endif
                @if (($article['has_content_sections'] ?? false) === true)
                    <div class="article-sections mt-12 max-w-4xl space-y-8">
                        @foreach ($article['sections'] as $section)
                            @if (($section['type'] ?? null) === 'section')
                                <section @class([
                                    'article-section',
                                    'article-section--summary' => ($section['variant'] ?? 'standard') === 'summary',
                                    'article-section--checklist' => ($section['variant'] ?? 'standard') === 'checklist',
                                    'article-section--recommendations' => ($section['variant'] ?? 'standard') === 'recommendations',
                                ])>
                                    @if (($section['title'] ?? '') !== '')
                                        <div class="article-section__header">
                                            @if (($section['variant'] ?? 'standard') === 'summary')
                                                <span class="article-section__eyebrow">Quick Take</span>
                                            @elseif (($section['variant'] ?? 'standard') === 'checklist')
                                                <span class="article-section__eyebrow">Execution Plan</span>
                                            @elseif (($section['variant'] ?? 'standard') === 'recommendations')
                                                <span class="article-section__eyebrow">Shortlist</span>
                                            @endif

                                            @if (($section['level'] ?? 2) === 3)
                                                <h3 class="article-section__title">{{ $section['title'] }}</h3>
                                            @elseif (($section['level'] ?? 2) >= 4)
                                                <h4 class="article-section__title">{{ $section['title'] }}</h4>
                                            @else
                                                <h2 class="article-section__title">{{ $section['title'] }}</h2>
                                            @endif
                                        </div>
                                    @endif

                                    <div class="article-section__body">
                                        @foreach (($section['blocks'] ?? []) as $block)
                                            @if (in_array(($block['type'] ?? null), ['paragraph', 'list'], true))
                                                <div class="article-block article-block--{{ $block['type'] }} article-richtext">
                                                    {!! $block['html'] !!}
                                                </div>
                                            @endif

                                            @if (($block['type'] ?? null) === 'quote')
                                                <div class="article-block article-block--quote">
                                                    <div class="article-richtext">
                                                        {!! $block['html'] !!}
                                                    </div>
                                                    @if (($block['citation'] ?? '') !== '')
                                                        <div class="article-block__citation">{{ $block['citation'] }}</div>
                                                    @endif
                                                </div>
                                            @endif

                                            @if (($block['type'] ?? null) === 'callout')
                                                <div class="article-block article-block--callout article-block--callout-{{ $block['tone'] ?? 'insight' }}">
                                                    <div class="article-block__callout-title">{{ $block['title'] }}</div>
                                                    <div class="article-richtext">
                                                        {!! $block['html'] !!}
                                                    </div>
                                                </div>
                                            @endif

                                            @if (($block['type'] ?? null) === 'code')
                                                <div class="article-block article-block--code">
                                                    @if (($block['label'] ?? '') !== '' || ($block['language'] ?? '') !== '')
                                                        <div class="article-block__code-meta">
                                                            @if (($block['label'] ?? '') !== '')
                                                                <span>{{ $block['label'] }}</span>
                                                            @endif
                                                            @if (($block['language'] ?? '') !== '')
                                                                <span>{{ strtoupper($block['language']) }}</span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                    <pre><code>{{ $block['code'] }}</code></pre>
                                                </div>
                                            @endif

                                            @if (($block['type'] ?? null) === 'image')
                                                <figure class="article-block article-block--image">
                                                    <img src="{{ $block['src'] }}" alt="{{ $block['alt'] }}">
                                                    @if (($block['caption'] ?? '') !== '')
                                                        <figcaption>{{ $block['caption'] }}</figcaption>
                                                    @endif
                                                </figure>
                                            @endif
                                        @endforeach
                                    </div>
                                </section>
                            @endif

                        @endforeach
                    </div>
                @elseif ($article['body_html'] !== '')
                    <div class="article-richtext mt-12 max-w-3xl">
                        {!! $article['body_html'] !!}
                    </div>
                @endif

                @if (($article['sections'] ?? []) !== [])
                    <div class="mt-14 max-w-4xl space-y-5">
                        @foreach ($article['sections'] as $section)
                            @if (($section['type'] ?? null) === 'faq')
                                <section class="space-y-5">
                                    <div class="article-section__header">
                                        <span class="article-section__eyebrow">FAQ</span>
                                        <h2 class="article-section__title">{{ $section['title'] }}</h2>
                                    </div>

                                    <div class="space-y-4">
                                        @foreach (($section['items'] ?? []) as $item)
                                            <details class="article-faq rounded-2xl border border-slate-200 bg-white p-0 shadow-sm" @if($item['open'] ?? false) open @endif>
                                                <summary class="article-faq__summary list-none cursor-pointer px-6 py-5 text-lg font-semibold text-slate-950">
                                                    <h3 class="article-faq__question">{{ $item['question'] }}</h3>
                                                    <span class="article-faq__icon" aria-hidden="true">+</span>
                                                </summary>
                                                <div class="article-faq__body article-richtext border-t border-slate-100 px-6 py-5">
                                                    {!! $item['answer_html'] !!}
                                                </div>
                                            </details>
                                        @endforeach
                                    </div>
                                </section>
                            @endif
                        @endforeach
                    </div>
                @endif

                @if ($article['tags'] !== [])
                    <div class="mt-10 flex flex-wrap gap-3">
                        @foreach ($article['tags'] as $tag)
                            <span class="rounded-full bg-slate-100 px-4 py-2 text-sm font-medium text-slate-600">
                                {{ $tag }}
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>

            @if ($sidebarTopics !== [] || $relatedArticles !== [])
                <aside class="xl:sticky xl:top-28">
                    <div class="space-y-6">
                        @if ($sidebarTopics !== [])
                            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                                <h2 class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Tags</h2>
                                <div class="mt-6 flex flex-wrap gap-3">
                                    @foreach ($sidebarTopics as $topic)
                                        <span class="rounded-full bg-orange-50 px-4 py-2 text-sm font-medium text-[#c2410c] ring-1 ring-orange-100">
                                            {{ $topic }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if ($relatedArticles !== [])
                            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                                <h2 class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Related Articles</h2>
                                <div class="mt-6 space-y-4">
                                    @foreach ($relatedArticles as $related)
                                        <a href="{{ route('articles.show', $related['slug']) }}" class="group block rounded-lg border border-slate-100 p-4 transition-colors hover:border-orange-200 hover:bg-orange-50/50">
                                            <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                                                {{ $related['category'] }} • {{ $related['read_time'] }}
                                            </div>
                                            <div class="mt-2 text-base font-semibold leading-6 text-slate-900 group-hover:text-[#c2410c]">
                                                {{ $related['title'] }}
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </aside>
            @endif
        </div>

        @if ($relatedArticles !== [])
            <section class="mt-20 xl:hidden">
                <div class="flex flex-col gap-3 border-t border-slate-200 pt-10 md:flex-row md:items-end md:justify-between">
                    <div>
                        <h2 class="text-3xl font-bold tracking-tight text-slate-950">Related Articles</h2>
                        <p class="mt-2 text-base text-slate-600">More insights on design and technology.</p>
                    </div>
                    <a href="{{ route('articles.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#c2410c]">
                        View all articles
                        <x-site.icon name="arrow_forward" />
                    </a>
                </div>

                <div class="mt-8 grid gap-6 md:grid-cols-3">
                    @foreach ($relatedArticles as $related)
                        <a href="{{ route('articles.show', $related['slug']) }}" class="group block overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition-all hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-900/10">
                            <div class="h-52 overflow-hidden">
                                <img src="{{ $related['image'] }}" alt="{{ $related['title'] }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                            </div>
                            <div class="p-5">
                                <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                                    {{ $related['category'] }} • {{ $related['read_time'] }}
                                </div>
                                <h3 class="mt-3 text-2xl font-bold leading-tight tracking-tight text-slate-950">
                                    {{ $related['title'] }}
                                </h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </article>
</main>
