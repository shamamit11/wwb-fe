<main class="px-6 py-10 lg:px-8 lg:py-14">
    <section class="mx-auto max-w-7xl">
        <div class="grid gap-10 rounded-2xl bg-[linear-gradient(180deg,_#f4f4ff_0%,_#eef2ff_100%)] px-8 py-10 shadow-sm ring-1 ring-slate-200/80 lg:grid-cols-[1.15fr_0.85fr] lg:px-10">
            <div class="max-w-2xl">
                <span class="inline-flex rounded-full bg-[#c2410c] px-3 py-1 text-xs font-semibold uppercase tracking-[0.16em] text-white">
                    {{ $featured['category'] }}
                </span>
                <h1 class="mt-5 text-4xl font-extrabold tracking-tight text-slate-950 md:text-6xl">
                    {{ $featured['title'] }}
                </h1>
                <p class="mt-5 text-lg leading-9 text-slate-600">
                    {{ $featured['excerpt'] }}
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <button type="button" class="inline-flex items-center gap-2 rounded-xl bg-[#141b2b] px-6 py-4 text-sm font-semibold text-white shadow-lg shadow-slate-900/10 transition-colors hover:bg-[#c2410c]">
                        <x-site.icon name="download" />
                        <span>{{ $featured['cta'] }} ({{ $featured['meta'] }})</span>
                    </button>
                    <button type="button" class="rounded-xl border border-slate-300 bg-white px-6 py-4 text-sm font-semibold text-slate-700 transition-colors hover:border-[#c2410c] hover:text-[#c2410c]">
                        {{ $featured['secondary_cta'] }}
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-center">
                <div class="w-full max-w-[360px] overflow-hidden rounded-xl bg-slate-950 shadow-2xl shadow-slate-900/15">
                    <img src="{{ $featured['image'] }}" alt="{{ $featured['title'] }}" class="h-full w-full object-cover">
                </div>
            </div>
        </div>

        <div class="mt-12 flex flex-col gap-6 border-b border-slate-200 pb-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-wrap gap-3">
                @foreach ($filters as $filter)
                    <button
                        type="button"
                        wire:click="setCategory('{{ $filter['slug'] }}')"
                        @class([
                            'rounded-full border px-4 py-2 text-sm font-semibold transition-colors',
                            'border-[#141b2b] bg-[#141b2b] text-white shadow-sm' => $activeCategory === $filter['slug'],
                            'border-transparent bg-transparent text-slate-600 hover:bg-slate-100 hover:text-[#141b2b]' => $activeCategory !== $filter['slug'],
                        ])>
                        {{ $filter['label'] }}
                    </button>
                @endforeach
            </div>

            <div class="flex items-center gap-4 text-sm">
                <label for="resource-sort" class="font-medium text-slate-500">Sort by:</label>
                <div class="relative">
                    <select
                        id="resource-sort"
                        wire:model.live="sort"
                        class="appearance-none rounded-xl border border-slate-200 bg-white py-3 pl-4 pr-10 font-semibold text-slate-700 outline-none transition-colors focus:border-[#c2410c]">
                        @foreach ($sortOptions as $option)
                            <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                        @endforeach
                    </select>
                    <x-site.icon name="expand_more" class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-400" />
                </div>
            </div>
        </div>

        <div class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($items as $resource)
                <article class="group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition-all hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-900/10">
                    <div class="h-56 overflow-hidden">
                        <img src="{{ $resource['image'] }}" alt="{{ $resource['title'] }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-3 text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">
                            <span class="rounded-lg bg-orange-50 px-2 py-1 text-[#c2410c]">{{ $resource['category'] }}</span>
                            <span>{{ $resource['type'] }}</span>
                        </div>
                        <h2 class="mt-5 text-3xl font-bold leading-tight tracking-tight text-slate-950">
                            {{ $resource['title'] }}
                        </h2>
                        <p class="mt-4 line-clamp-3 text-base leading-7 text-slate-600">
                            {{ $resource['excerpt'] }}
                        </p>
                        <div class="mt-6 flex items-center justify-between gap-4 text-sm">
                            <span class="font-medium text-slate-500">{{ $resource['meta'] }}</span>
                            <button type="button" class="inline-flex items-center gap-1 font-semibold text-[#c2410c] transition-colors hover:text-[#9a3412]">
                                <span>{{ $resource['cta'] }}</span>
                                <x-site.icon name="arrow_forward" class="text-base" />
                            </button>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <section class="mt-14 rounded-2xl bg-[linear-gradient(180deg,_#f4f4ff_0%,_#eef2ff_100%)] px-8 py-14 text-center shadow-sm ring-1 ring-slate-200/80">
            <h2 class="text-4xl font-extrabold tracking-tight text-slate-950">Never miss a new resource</h2>
            <p class="mx-auto mt-4 max-w-2xl text-base leading-7 text-slate-600">
                Join 25,000+ creators who receive our bi-weekly update on new digital assets, design tools, and technical guides.
            </p>
            @if ($newsletterToastVisible)
                <div
                    x-data="{ show: true }"
                    x-init="setTimeout(() => show = false, 3200)"
                    x-show="show"
                    x-transition
                    @class([
                        'mx-auto mt-8 max-w-xl rounded-2xl border px-5 py-4 text-left text-sm shadow-sm',
                        'border-emerald-200 bg-emerald-50 text-emerald-900' => $newsletterToastType === 'success',
                        'border-red-200 bg-red-50 text-red-900' => $newsletterToastType !== 'success',
                    ])>
                    {{ $newsletterToastMessage }}
                </div>
            @endif
            <form class="mx-auto mt-8 flex max-w-xl flex-col gap-3 md:flex-row" wire:submit="subscribe">
                <input
                    type="email"
                    wire:model.blur="newsletterEmail"
                    placeholder="Enter your email address"
                    class="min-w-0 flex-1 rounded-xl border border-slate-200 bg-white px-5 py-3 text-base text-slate-900 outline-none transition-all placeholder:text-slate-400 focus:border-[#c2410c] focus:ring-4 focus:ring-orange-100">
                <button type="submit" class="rounded-xl bg-[#141b2b] px-6 py-3 text-sm font-semibold text-white transition-colors hover:bg-[#c2410c]">
                    Join Newsletter
                </button>
            </form>
            @error('newsletterEmail') <p class="mx-auto mt-3 max-w-xl text-left text-sm text-red-600">{{ $message }}</p> @enderror
            <p class="mt-4 text-sm text-slate-500">No spam. Only high-signal content. Unsubscribe anytime.</p>
        </section>
    </section>
</main>
