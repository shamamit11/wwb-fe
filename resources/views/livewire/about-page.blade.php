<main class="px-6 py-10 lg:px-8 lg:py-14">
    <section class="mx-auto max-w-7xl">
        <div class="mx-auto max-w-4xl text-center">
            <span class="text-xs font-semibold uppercase tracking-[0.22em] text-[#c2410c]">{{ $story['eyebrow'] }}</span>
            <h1 class="mt-4 text-4xl font-extrabold leading-tight tracking-tight text-slate-950 md:text-6xl">
                {{ $story['title'] }}
            </h1>
            @if ($story['summary'] !== '')
                <p class="mx-auto mt-5 max-w-2xl text-lg leading-8 text-slate-600">
                    {{ $story['summary'] }}
                </p>
            @endif
        </div>

        @if ($story['image'] !== '')
            <div class="mt-10 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <img src="{{ $story['image'] }}" alt="{{ $story['image_alt'] }}" class="h-[420px] w-full object-cover">
            </div>
        @endif
    </section>

    @if ($mission['title'] !== '' || $mission['body'] !== '' || $mission['quote'] !== '' || $stats !== [])
        <section class="mx-auto mt-14 grid max-w-7xl gap-10 lg:grid-cols-[1.1fr_0.9fr]">
            <div>
                @if ($mission['title'] !== '')
                    <h2 class="text-4xl font-bold tracking-tight text-slate-950">{{ $mission['title'] }}</h2>
                @endif
                @if ($mission['body'] !== '')
                    <p class="mt-5 max-w-2xl text-lg leading-9 text-slate-700">{{ $mission['body'] }}</p>
                @endif
                @if ($mission['quote'] !== '')
                    <blockquote class="mt-8 border-l-4 border-[#c2410c] bg-orange-50/60 px-5 py-4 text-xl italic leading-8 text-[#c2410c]">
                        “{{ $mission['quote'] }}”
                    </blockquote>
                @endif
            </div>

            @if ($stats !== [])
                <div class="grid gap-4 sm:grid-cols-2">
                    @foreach ($stats as $stat)
                        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                            <div class="text-4xl font-extrabold tracking-tight text-[#c2410c]">{{ $stat['value'] }}</div>
                            <div class="mt-2 text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">{{ $stat['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    @endif

    @if ($values !== [])
        <section class="mx-auto mt-20 max-w-7xl">
            <div class="text-center">
                <h2 class="text-4xl font-bold tracking-tight text-slate-950">{{ $valuesSection['title'] }}</h2>
                <div class="mx-auto mt-4 h-1 w-16 rounded-full bg-[#c2410c]"></div>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-3">
                @foreach ($values as $value)
                    <article class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm transition-all hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-900/10">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-50 text-[#c2410c]">
                            <x-site.icon :name="$value['icon']" />
                        </div>
                        <h3 class="mt-5 text-2xl font-bold tracking-tight text-slate-950">{{ $value['title'] }}</h3>
                        <p class="mt-3 text-base leading-7 text-slate-600">{{ $value['body'] }}</p>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    @if ($team !== [])
        <section class="mx-auto mt-20 max-w-7xl overflow-hidden rounded-2xl bg-[#141b2b]">
        <div class="border-b border-white/10 px-8 py-8 md:flex md:items-end md:justify-between lg:px-10">
            <div class="max-w-2xl">
                <h2 class="text-4xl font-bold tracking-tight text-white">{{ $teamSection['title'] }}</h2>
                <p class="mt-3 text-base leading-7 text-slate-300">
                    {{ $teamSection['description'] }}
                </p>
            </div>
            @if ($teamSection['primary_cta_label'] !== '' && $teamSection['primary_cta_url'] !== '')
                <a href="{{ $teamSection['primary_cta_url'] }}" class="mt-5 inline-flex rounded-full border border-white/20 px-5 py-3 text-sm font-semibold text-white transition-colors hover:border-[#c2410c] hover:bg-[#c2410c] md:mt-0">
                    {{ $teamSection['primary_cta_label'] }}
                </a>
            @endif
        </div>

        <div class="grid gap-6 px-8 py-8 md:grid-cols-2 xl:grid-cols-4 lg:px-10">
            @foreach ($team as $member)
                <article class="group overflow-hidden rounded-xl bg-white/5 ring-1 ring-white/10 transition-all hover:-translate-y-1 hover:bg-white/10">
                    <div class="aspect-[3/4] overflow-hidden">
                        <img src="{{ $member['image'] }}" alt="{{ $member['name'] }}" class="h-full w-full object-cover grayscale transition duration-500 group-hover:grayscale-0">
                    </div>
                    <div class="p-5">
                        <h3 class="text-xl font-semibold text-white">{{ $member['name'] }}</h3>
                        <p class="mt-2 text-xs font-semibold uppercase tracking-[0.2em] text-[#fb923c]">{{ $member['role'] }}</p>
                    </div>
                </article>
            @endforeach
        </div>
        </section>
    @endif
</main>
