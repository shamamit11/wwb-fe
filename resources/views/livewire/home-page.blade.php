<main>
    <section class="relative flex min-h-[80vh] items-center overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ $hero['image'] }}" alt="{{ $hero['image_alt'] }}" class="h-full w-full object-cover">
            <div class="absolute inset-0 bg-slate-950/25"></div>
        </div>

        <div class="relative z-10 mx-auto w-full max-w-7xl px-6 py-20 lg:px-8">
            <div class="glass-card max-w-2xl rounded-xl p-8 shadow-2xl shadow-slate-900/20 md:p-12 lg:p-16">
                <span
                    class="inline-flex rounded-full bg-orange-100 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-[var(--brand-accent)]">
                    {{ $hero['eyebrow'] }}
                </span>
                <h1
                    class="mt-6 max-w-xl text-4xl font-extrabold leading-tight tracking-tight text-[var(--brand-ink)] md:text-6xl">
                    {{ $hero['title'] }}
                </h1>
                <p class="mt-6 text-lg leading-8 text-slate-600 md:text-xl">
                    {{ $hero['description'] }}
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ $hero['primary_cta_url'] }}"
                        class="inline-flex rounded-xl bg-[var(--brand-accent)] px-8 py-4 text-sm font-semibold text-white shadow-lg shadow-orange-900/20 transition-all hover:-translate-y-0.5 hover:bg-[var(--brand-accent-strong)]">
                        {{ $hero['primary_cta_label'] }}
                    </a>
                    <a href="{{ $hero['secondary_cta_url'] }}"
                        class="inline-flex rounded-xl border-2 border-slate-200 bg-white px-8 py-4 text-sm font-semibold text-slate-900 transition-all hover:border-[var(--brand-accent)] hover:text-[var(--brand-accent)]">
                        {{ $hero['secondary_cta_label'] }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="featured" class="bg-white px-6 py-16 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="mb-12 flex items-end justify-between gap-6 border-b border-slate-200 pb-8">
                <div class="max-w-2xl">
                    <h2 class="text-3xl font-bold tracking-tight text-slate-950 md:text-4xl">
                        {{ $featuredSection['title'] }}</h2>
                    <p class="mt-2 text-base italic text-slate-600">{{ $featuredSection['description'] }}</p>
                </div>
                <div class="hidden gap-2 md:flex">
                    <button type="button"
                        class="rounded-full border border-slate-200 p-2 transition-colors hover:border-[var(--brand-accent)] hover:text-[var(--brand-accent)]">
                        <x-site.icon name="chevron_left" />
                    </button>
                    <button type="button"
                        class="rounded-full border border-slate-200 p-2 transition-colors hover:border-[var(--brand-accent)] hover:text-[var(--brand-accent)]">
                        <x-site.icon name="chevron_right" />
                    </button>
                </div>
            </div>

            <div class="grid gap-8 lg:grid-cols-3">
                <a href="{{ $featuredSection['lead']['href'] }}"
                    class="group flex h-full flex-col overflow-hidden rounded-xl border border-slate-200 bg-white transition-all hover:-translate-y-1 hover:shadow-2xl hover:shadow-slate-900/10 lg:col-span-2">
                    <div class="relative h-112.5 overflow-hidden">
                        <img src="{{ $featuredSection['lead']['image'] }}"
                            alt="{{ $featuredSection['lead']['image_alt'] }}"
                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute left-6 top-6">
                            <span
                                class="rounded-xl bg-[var(--brand-accent)] px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-white shadow-lg">
                                {{ $featuredSection['lead']['category'] }}
                            </span>
                        </div>
                    </div>
                    <div class="flex flex-1 flex-col p-8 md:p-10">
                        <h3
                            class="text-3xl font-bold leading-tight tracking-tight text-slate-950 transition-colors group-hover:text-[var(--brand-accent)]">
                            {{ $featuredSection['lead']['title'] }}
                        </h3>
                        <p class="mt-5 text-base leading-7 text-slate-600">
                            {{ $featuredSection['lead']['excerpt'] }}
                        </p>
                        <div class="mt-auto flex items-center justify-between gap-4 border-t border-slate-200 pt-6">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-full bg-orange-100 text-sm font-bold text-[var(--brand-accent)]">
                                    {{ $featuredSection['lead']['author_initials'] }}
                                </div>
                                <span
                                    class="text-sm font-medium text-slate-600">{{ $featuredSection['lead']['author'] }}</span>
                            </div>
                            <span class="text-sm text-slate-500">{{ $featuredSection['lead']['read_time'] }}</span>
                        </div>
                    </div>
                </a>

                <div class="flex flex-col gap-8">
                    @foreach ($featuredSection['secondary'] as $item)
                        <a href="{{ $item['href'] }}"
                            class="group flex h-full flex-col overflow-hidden rounded-xl border border-slate-200 bg-white transition-all hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-900/10">
                            <div class="h-48 overflow-hidden">
                                <img src="{{ $item['image'] }}" alt="{{ $item['image_alt'] }}"
                                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                            </div>
                            <div class="p-6">
                                <span
                                    class="block text-xs font-semibold uppercase tracking-[0.2em] text-[var(--brand-accent)]">{{ $item['category'] }}</span>
                                <h3
                                    class="mt-3 text-2xl font-semibold leading-tight text-slate-950 transition-colors group-hover:text-[var(--brand-accent)]">
                                    {{ $item['title'] }}
                                </h3>
                                <div class="mt-5 flex items-center justify-between gap-4 text-sm text-slate-500">
                                    <span>{{ $item['meta_left'] }}</span>
                                    <span>{{ $item['meta_right'] }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section id="guides" class="bg-slate-50 px-6 py-16 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="mb-12 flex flex-col gap-4 md:mb-16 md:flex-row md:items-center md:justify-between">
                <div class="max-w-2xl">
                    <h2 class="text-3xl font-bold tracking-tight text-slate-950 md:text-4xl">
                        {{ $guideSection['title'] }}</h2>
                    <p class="mt-4 text-base leading-7 text-slate-600">{{ $guideSection['description'] }}</p>
                </div>
                <a href="/articles" class="group inline-flex items-center gap-2 text-sm font-semibold text-[var(--brand-accent)]">
                    Browse all articles
                    <x-site.icon name="arrow_forward" class="transition-transform group-hover:translate-x-1" />
                </a>
            </div>

            <div class="grid gap-8 md:grid-cols-2 xl:grid-cols-4">
                @foreach ($guideSection['items'] as $guide)
                    <a href="{{ $guide['href'] }}"
                        class="group flex flex-col overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition-all hover:-translate-y-1 hover:shadow-2xl hover:shadow-slate-900/10">
                        <div class="h-48 overflow-hidden">
                            <img src="{{ $guide['image'] }}" alt="{{ $guide['image_alt'] }}"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                        </div>
                        <div class="flex flex-1 flex-col p-6">
                            <span
                                class="text-xs font-semibold uppercase tracking-[0.2em] text-[var(--brand-accent)]">{{ $guide['category'] }}</span>
                            <h3 class="mt-3 text-2xl font-semibold leading-tight text-slate-950">{{ $guide['title'] }}
                            </h3>
                            <p class="mt-4 flex-1 text-base leading-7 text-slate-600">{{ $guide['excerpt'] }}</p>
                            <div
                                class="mt-6 flex items-center justify-between gap-4 border-t border-slate-200 pt-5 text-sm text-slate-500">
                                <span>{{ $guide['meta_left'] }}</span>
                                <span>{{ $guide['meta_right'] }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section id="topics" class="px-6 py-16 lg:px-8">
        <div data-topic-carousel class="mx-auto max-w-7xl">
            <div class="mb-10 flex flex-col gap-6 md:mb-12 md:flex-row md:items-end md:justify-between">
                <div class="max-w-3xl">
                    <h2 class="text-3xl font-bold tracking-tight text-slate-950 md:text-4xl">
                        {{ $topicSection['title'] }}</h2>
                    <p class="mt-4 text-lg leading-8 text-slate-600">
                        {{ $topicSection['description'] }}
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <button type="button" aria-label="Scroll topics left"
                        onclick="const track=this.closest('[data-topic-carousel]').querySelector('[data-topic-track]'); track.scrollBy({ left: -320, behavior: 'smooth' });"
                        class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-700 transition-colors hover:border-[var(--brand-accent)] hover:text-[var(--brand-accent)]">
                        <x-site.icon name="chevron_left" class="text-xl" />
                    </button>
                    <button type="button" aria-label="Scroll topics right"
                        onclick="const track=this.closest('[data-topic-carousel]').querySelector('[data-topic-track]'); track.scrollBy({ left: 320, behavior: 'smooth' });"
                        class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-700 transition-colors hover:border-[var(--brand-accent)] hover:text-[var(--brand-accent)]">
                        <x-site.icon name="chevron_right" class="text-xl" />
                    </button>
                </div>
            </div>

            <div class="relative">
                <div data-topic-track
                    class="flex snap-x snap-mandatory gap-6 overflow-x-auto pb-4 scrollbar-none [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
                    @foreach ($topicSection['items'] as $topic)
                        <a href="{{ $topic['href'] }}"
                            class="group flex min-h-55 min-w-55 flex-none snap-start flex-col items-center justify-center rounded-xl border border-slate-200 bg-white px-8 py-10 text-center transition-all hover:-translate-y-1 hover:shadow-lg hover:shadow-slate-900/10">
                            <x-site.icon :name="$topic['icon']"
                                class="mb-5 text-6xl text-[var(--brand-accent)] transition-transform group-hover:scale-110" />
                            <span
                                class="text-base font-semibold tracking-wide text-slate-900">{{ $topic['label'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    @if ($promoSection['enabled'])
        <section id="resources" class="px-6 py-6 lg:px-8">
            <div
                class="mx-auto max-w-7xl overflow-hidden rounded-xl bg-[var(--brand-ink)] px-8 py-12 text-white shadow-2xl shadow-slate-900/20 lg:px-12">
                <div class="grid items-center gap-12 lg:grid-cols-2">
                    <div>
                        <span
                            class="text-sm font-semibold uppercase tracking-[0.2em] text-orange-300">{{ $promoSection['eyebrow'] }}</span>
                        <h2 class="mt-4 text-4xl font-bold tracking-tight md:text-5xl">{{ $promoSection['title'] }}
                        </h2>
                        <p class="mt-6 text-lg leading-8 text-slate-300">{{ $promoSection['description'] }}</p>
                        <ul class="mt-8 space-y-4">
                            @foreach ($promoSection['bullet_points'] as $item)
                                <li class="flex items-center gap-4">
                                    <x-site.icon name="download_done" class="text-orange-300" />
                                    <span class="text-base text-slate-100">{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <a href="{{ $promoSection['primary_cta_url'] }}"
                            class="mt-10 inline-flex rounded-xl bg-[var(--brand-accent)] px-8 py-4 text-sm font-semibold text-white shadow-lg shadow-orange-950/30 transition-all hover:scale-[1.01] hover:bg-[var(--brand-accent-strong)]">
                            {{ $promoSection['primary_cta_label'] }}
                        </a>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        @foreach ($promoSection['stats'] as $stat)
                            <div
                                class="rounded-xl border border-white/15 bg-white/10 p-8 text-center backdrop-blur-sm">
                                <span
                                    class="block text-4xl font-bold tracking-tight text-orange-300">{{ $stat['value'] }}</span>
                                <span
                                    class="mt-2 block text-xs font-semibold uppercase tracking-[0.2em] text-slate-300">{{ $stat['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if ($newsletterSection['enabled'])
        <section id="newsletter" class="px-6 py-16 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-slate-950 md:text-4xl">
                    {{ $newsletterSection['title'] }}</h2>
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

                <form class="mt-10 flex flex-col gap-4 md:flex-row" wire:submit="subscribe">
                    <input type="email" wire:model.blur="newsletterEmail"
                        placeholder="{{ $newsletterSection['placeholder'] }}"
                        class="min-w-0 flex-1 rounded-2xl border-2 border-slate-200 bg-white px-6 py-4 text-slate-900 outline-none transition-all placeholder:text-slate-400 focus:border-[var(--brand-accent)] focus:ring-4 focus:ring-orange-100">
                    <button type="submit"
                        class="rounded-2xl bg-[var(--brand-ink)] px-10 py-4 text-sm font-semibold text-white shadow-lg transition-colors hover:bg-[var(--brand-accent)]">
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
</main>
