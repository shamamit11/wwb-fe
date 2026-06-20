<main>
    <section class="relative flex min-h-[80vh] items-center overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ $hero['image'] }}" alt="Modern creator workspace" class="h-full w-full object-cover">
            <div class="absolute inset-0 bg-slate-950/25"></div>
        </div>

        <div class="relative z-10 mx-auto w-full max-w-7xl px-6 py-20 lg:px-8">
            <div class="glass-card max-w-2xl rounded-xl p-8 shadow-2xl shadow-slate-900/20 md:p-12 lg:p-16">
                <span class="inline-flex rounded-full bg-orange-100 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-[#c2410c]">
                    {{ $hero['eyebrow'] }}
                </span>
                <h1 class="mt-6 max-w-xl text-4xl font-extrabold leading-tight tracking-tight text-[#141b2b] md:text-6xl">
                    {{ $hero['title'] }}
                </h1>
                <p class="mt-6 text-lg leading-8 text-slate-600 md:text-xl">
                    {{ $hero['summary'] }}
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ $hero['primary_cta']['href'] }}" class="inline-flex rounded-xl bg-[#c2410c] px-8 py-4 text-sm font-semibold text-white shadow-lg shadow-orange-900/20 transition-all hover:-translate-y-0.5 hover:bg-[#9a3412]">
                        {{ $hero['primary_cta']['label'] }}
                    </a>
                    <a href="{{ $hero['secondary_cta']['href'] }}" class="inline-flex rounded-xl border-2 border-slate-200 bg-white px-8 py-4 text-sm font-semibold text-slate-900 transition-all hover:border-[#c2410c] hover:text-[#c2410c]">
                        {{ $hero['secondary_cta']['label'] }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="featured" class="bg-white px-6 py-16 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="mb-12 flex items-end justify-between gap-6 border-b border-slate-200 pb-8">
                <div class="max-w-2xl">
                    <h2 class="text-3xl font-bold tracking-tight text-slate-950 md:text-4xl">{{ $featured['title'] }}</h2>
                    <p class="mt-2 text-base italic text-slate-600">{{ $featured['summary'] }}</p>
                </div>
                <div class="hidden gap-2 md:flex">
                    <button type="button" class="rounded-full border border-slate-200 p-2 transition-colors hover:border-[#c2410c] hover:text-[#c2410c]">
                        <x-site.icon name="chevron_left" />
                    </button>
                    <button type="button" class="rounded-full border border-slate-200 p-2 transition-colors hover:border-[#c2410c] hover:text-[#c2410c]">
                        <x-site.icon name="chevron_right" />
                    </button>
                </div>
            </div>

            <div class="grid gap-8 lg:grid-cols-3">
                <article class="group flex h-full flex-col overflow-hidden rounded-xl border border-slate-200 bg-white transition-all hover:-translate-y-1 hover:shadow-2xl hover:shadow-slate-900/10 lg:col-span-2">
                    <div class="relative h-[450px] overflow-hidden">
                        <img src="{{ $featured['lead']['image'] }}" alt="{{ $featured['lead']['title'] }}" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute left-6 top-6">
                            <span class="rounded-xl bg-[#c2410c] px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-white shadow-lg">
                                {{ $featured['lead']['category'] }}
                            </span>
                        </div>
                    </div>
                    <div class="flex flex-1 flex-col p-8 md:p-10">
                        <h3 class="text-3xl font-bold leading-tight tracking-tight text-slate-950 transition-colors group-hover:text-[#c2410c]">
                            {{ $featured['lead']['title'] }}
                        </h3>
                        <p class="mt-5 text-base leading-7 text-slate-600">
                            {{ $featured['lead']['excerpt'] }}
                        </p>
                        <div class="mt-auto flex items-center justify-between gap-4 border-t border-slate-200 pt-6">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-orange-100 text-sm font-bold text-[#c2410c]">
                                    {{ $featured['lead']['author_initials'] }}
                                </div>
                                <span class="text-sm font-medium text-slate-600">{{ $featured['lead']['author'] }}</span>
                            </div>
                            <span class="text-sm text-slate-500">{{ $featured['lead']['read_time'] }}</span>
                        </div>
                    </div>
                </article>

                <div class="flex flex-col gap-8">
                    @foreach ($featured['secondary'] as $item)
                        <article class="group flex h-full flex-col overflow-hidden rounded-xl border border-slate-200 bg-white transition-all hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-900/10">
                            <div class="h-48 overflow-hidden">
                                <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                            </div>
                            <div class="p-6">
                                <span class="block text-xs font-semibold uppercase tracking-[0.2em] text-[#c2410c]">{{ $item['category'] }}</span>
                                <h3 class="mt-3 text-2xl font-semibold leading-tight text-slate-950 transition-colors group-hover:text-[#c2410c]">
                                    {{ $item['title'] }}
                                </h3>
                                <div class="mt-5 flex items-center justify-between gap-4 text-sm text-slate-500">
                                    <span>{{ $item['meta_left'] }}</span>
                                    <span>{{ $item['meta_right'] }}</span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section id="guides" class="bg-slate-50 px-6 py-16 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="mb-12 flex flex-col gap-4 md:mb-16 md:flex-row md:items-center md:justify-between">
                <h2 class="text-3xl font-bold tracking-tight text-slate-950 md:text-4xl">Practical Wisdom for Builders</h2>
                <a href="#topics" class="group inline-flex items-center gap-2 text-sm font-semibold text-[#c2410c]">
                    Browse all guides
                    <x-site.icon name="arrow_forward" class="transition-transform group-hover:translate-x-1" />
                </a>
            </div>

            <div class="grid gap-8 md:grid-cols-2 xl:grid-cols-4">
                @foreach ($guides as $guide)
                    <article class="group flex flex-col rounded-xl border border-slate-200 bg-white p-8 shadow-sm transition-all hover:-translate-y-1 hover:shadow-2xl hover:shadow-slate-900/10">
                        <div class="mb-8 flex h-14 w-14 items-center justify-center rounded-2xl bg-orange-100 text-[#c2410c] transition-colors group-hover:bg-[#c2410c] group-hover:text-white">
                            <x-site.icon :name="$guide['icon']" class="text-3xl" />
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-[0.2em] text-[#c2410c]">{{ $guide['category'] }}</span>
                        <h3 class="mt-3 text-2xl font-semibold leading-tight text-slate-950">{{ $guide['title'] }}</h3>
                        <p class="mt-4 text-base leading-7 text-slate-600">{{ $guide['excerpt'] }}</p>
                        <div class="mt-auto border-t border-slate-200 pt-6 text-sm text-slate-500">
                            {{ $guide['read_time'] }}
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section id="topics" class="px-6 py-16 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="mx-auto mb-14 max-w-3xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-slate-950 md:text-4xl">Browse by Topic</h2>
                <p class="mt-4 text-lg leading-8 text-slate-600">
                    Explore our curated collections of technical and strategic resources tailored for your growth.
                </p>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($topics as $topic)
                    <a href="{{ $topic['href'] }}" class="group flex flex-col items-center justify-center rounded-xl border border-slate-200 bg-white p-10 text-center transition-all hover:-translate-y-1 hover:shadow-lg hover:shadow-slate-900/10">
                        <x-site.icon :name="$topic['icon']" class="mb-4 text-4xl text-[#c2410c] transition-transform group-hover:scale-110" />
                        <span class="text-sm font-semibold tracking-wide text-slate-900">{{ $topic['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section id="resources" class="px-6 py-6 lg:px-8">
        <div class="mx-auto max-w-7xl overflow-hidden rounded-xl bg-[#141b2b] px-8 py-12 text-white shadow-2xl shadow-slate-900/20 lg:px-12">
            <div class="grid items-center gap-12 lg:grid-cols-2">
                <div>
                    <span class="text-sm font-semibold uppercase tracking-[0.2em] text-orange-300">{{ $resourceKit['eyebrow'] }}</span>
                    <h2 class="mt-4 text-4xl font-bold tracking-tight md:text-5xl">{{ $resourceKit['title'] }}</h2>
                    <p class="mt-6 text-lg leading-8 text-slate-300">{{ $resourceKit['summary'] }}</p>
                    <ul class="mt-8 space-y-4">
                        @foreach ($resourceKit['items'] as $item)
                            <li class="flex items-center gap-4">
                                <x-site.icon name="download_done" class="text-orange-300" />
                                <span class="text-base text-slate-100">{{ $item }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <a href="{{ $resourceKit['cta']['href'] }}" class="mt-10 inline-flex rounded-xl bg-[#c2410c] px-8 py-4 text-sm font-semibold text-white shadow-lg shadow-orange-950/30 transition-all hover:scale-[1.01] hover:bg-[#9a3412]">
                        {{ $resourceKit['cta']['label'] }}
                    </a>
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    @foreach ($resourceKit['stats'] as $stat)
                        <div class="rounded-xl border border-white/15 bg-white/10 p-8 text-center backdrop-blur-sm">
                            <span class="block text-4xl font-bold tracking-tight text-orange-300">{{ $stat['value'] }}</span>
                            <span class="mt-2 block text-xs font-semibold uppercase tracking-[0.2em] text-slate-300">{{ $stat['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section id="newsletter" class="px-6 py-16 lg:px-8">
        <div class="mx-auto max-w-3xl text-center">
            <h2 class="text-3xl font-bold tracking-tight text-slate-950 md:text-4xl">{{ $newsletter['title'] }}</h2>
            <p class="mt-5 text-lg leading-8 text-slate-600">{{ $newsletter['summary'] }}</p>

            <form class="mt-10 flex flex-col gap-4 md:flex-row" wire:submit.prevent>
                <input
                    type="email"
                    placeholder="{{ $newsletter['placeholder'] }}"
                    class="min-w-0 flex-1 rounded-2xl border-2 border-slate-200 bg-white px-6 py-4 text-slate-900 outline-none transition-all placeholder:text-slate-400 focus:border-[#c2410c] focus:ring-4 focus:ring-orange-100">
                <button type="submit" class="rounded-2xl bg-[#141b2b] px-10 py-4 text-sm font-semibold text-white shadow-lg transition-colors hover:bg-[#c2410c]">
                    {{ $newsletter['button'] }}
                </button>
            </form>

            <p class="mt-6 text-sm italic text-slate-500">{{ $newsletter['note'] }}</p>
        </div>
    </section>
</main>
