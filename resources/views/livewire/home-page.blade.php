@php
    $heroTitle = data_get($payload, 'hero.title', config('app.name'));
    $heroSummary = data_get($payload, 'hero.summary', 'Cached content will be pulled from the Wide Web Blog service.');
    $featured = data_get($payload, 'featured', []);
@endphp

<div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(251,191,36,0.18),_transparent_32%),linear-gradient(180deg,_#111827_0%,_#0c0a09_50%,_#020617_100%)]">
    <div class="mx-auto flex min-h-screen max-w-6xl flex-col px-6 py-10 sm:px-10">
        <header class="flex items-center justify-between border-b border-white/10 pb-6">
            <div>
                <p class="text-xs uppercase tracking-[0.35em] text-amber-300/80">Wide Web Blog</p>
                <h1 class="mt-3 text-3xl font-semibold text-white sm:text-5xl">{{ $heroTitle }}</h1>
            </div>
            <span class="rounded-full border border-emerald-400/30 bg-emerald-400/10 px-4 py-2 text-xs uppercase tracking-[0.3em] text-emerald-200">
                Cached FE
            </span>
        </header>

        <main class="grid flex-1 gap-8 py-10 lg:grid-cols-[1.3fr_0.7fr]">
            <section class="rounded-[2rem] border border-white/10 bg-white/5 p-8 shadow-2xl shadow-black/30 backdrop-blur">
                <p class="max-w-3xl text-lg leading-8 text-stone-200 sm:text-xl">{{ $heroSummary }}</p>

                @if ($unavailable)
                    <div class="mt-8 rounded-2xl border border-amber-400/30 bg-amber-300/10 p-4 text-sm text-amber-100">
                        The upstream API is not reachable yet. This screen is using a safe fallback payload.
                    </div>
                @endif

                <div class="mt-10 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-2xl border border-white/10 bg-black/20 p-5">
                        <p class="text-xs uppercase tracking-[0.3em] text-stone-400">Transport</p>
                        <p class="mt-3 text-lg font-medium text-white">Guzzle Client</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-black/20 p-5">
                        <p class="text-xs uppercase tracking-[0.3em] text-stone-400">Cache Store</p>
                        <p class="mt-3 text-lg font-medium text-white">{{ config('cache.default') }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-black/20 p-5">
                        <p class="text-xs uppercase tracking-[0.3em] text-stone-400">Homepage TTL</p>
                        <p class="mt-3 text-lg font-medium text-white">{{ config('services.wideweb_blog.cache_ttl') }}s</p>
                    </div>
                </div>
            </section>

            <aside class="rounded-[2rem] border border-white/10 bg-stone-900/80 p-8">
                <p class="text-xs uppercase tracking-[0.3em] text-stone-400">Featured Payload</p>
                <div class="mt-6 space-y-4">
                    @forelse ($featured as $item)
                        <article class="rounded-2xl border border-white/10 bg-white/5 p-5">
                            <h2 class="text-lg font-medium text-white">{{ data_get($item, 'title', 'Untitled article') }}</h2>
                            <p class="mt-2 text-sm leading-6 text-stone-300">{{ data_get($item, 'excerpt', 'No excerpt returned by the upstream service.') }}</p>
                        </article>
                    @empty
                        <article class="rounded-2xl border border-dashed border-white/15 bg-white/[0.03] p-5 text-sm leading-6 text-stone-400">
                            Configure `WIDEWEB_BLOG_API_BASE_URL` and `WIDEWEB_BLOG_API_HOMEPAGE_PATH` to render live blog content here.
                        </article>
                    @endforelse
                </div>
            </aside>
        </main>
    </div>
</div>
