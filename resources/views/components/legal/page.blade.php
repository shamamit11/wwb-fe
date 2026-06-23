@props([
    'eyebrow' => 'Legal',
    'title',
    'summary',
    'effectiveDate',
    'sections' => [],
    'contentHtml' => null,
])

<main class="px-6 py-10 lg:px-8 lg:py-14">
    <article class="mx-auto max-w-4xl">
        <header class="rounded-2xl border border-slate-200 bg-white px-8 py-10 shadow-sm">
            <span class="text-xs font-semibold uppercase tracking-[0.22em] text-[var(--brand-accent)]">{{ $eyebrow }}</span>
            <h1 class="mt-4 text-4xl font-extrabold tracking-tight text-slate-950 md:text-5xl">{{ $title }}</h1>
            <p class="mt-4 max-w-3xl text-lg leading-8 text-slate-600">{{ $summary }}</p>
            <p class="mt-6 text-sm font-medium text-slate-500">Effective date: {{ $effectiveDate }}</p>
        </header>

        @if (filled($contentHtml))
            <section class="prose prose-slate mt-8 max-w-none rounded-2xl border border-slate-200 bg-white px-8 py-8 shadow-sm prose-headings:font-bold prose-headings:tracking-tight prose-h1:text-slate-950 prose-h2:text-slate-950 prose-h3:text-slate-950 prose-p:text-slate-700 prose-li:text-slate-700 prose-a:text-[var(--brand-accent)]">
                {!! $contentHtml !!}
            </section>
        @elseif ($sections !== [])
            <div class="mt-8 space-y-8">
                @foreach ($sections as $section)
                    <section class="rounded-2xl border border-slate-200 bg-white px-8 py-8 shadow-sm">
                        <h2 class="text-2xl font-bold tracking-tight text-slate-950">{{ $section['heading'] }}</h2>
                        <div class="mt-4 space-y-4 text-base leading-8 text-slate-700">
                            @foreach ($section['paragraphs'] as $paragraph)
                                <p>{{ $paragraph }}</p>
                            @endforeach
                        </div>
                    </section>
                @endforeach
            </div>
        @endif
    </article>
</main>
