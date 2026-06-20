@props([
    'categories' => [],
    'company' => data_get(config('site.footer'), 'company', []),
    'social' => config('site.social', []),
])

<footer id="about" class="border-t border-slate-200/80 bg-slate-50 px-6 py-16 lg:px-8">
    <div class="mx-auto max-w-7xl">
        <div class="mb-16 grid gap-12 md:grid-cols-4">
            <div class="md:col-span-2">
                <x-site.brand />
                <p class="mt-8 max-w-md text-base leading-8 text-slate-600">
                    An authoritative digital editorial focused on technical SEO, AI implementation, and content architecture for the modern web.
                </p>
                <div class="mt-8 flex gap-4">
                    @foreach ($social as $item)
                        <a href="{{ $item['href'] }}"
                            aria-label="{{ $item['label'] }}"
                            class="flex h-12 w-12 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-600 transition-all hover:border-[#c2410c] hover:bg-[#c2410c] hover:text-white">
                            <x-site.icon :name="$item['icon']" />
                        </a>
                    @endforeach
                </div>
            </div>

            <div>
                <h2 class="mb-6 text-sm font-semibold uppercase tracking-[0.2em] text-slate-900">Categories</h2>
                <ul class="space-y-4">
                    @foreach ($categories as $item)
                        <li>
                            <a href="{{ $item['href'] }}" class="text-slate-600 transition-colors hover:text-[#c2410c]">
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h2 class="mb-6 text-sm font-semibold uppercase tracking-[0.2em] text-slate-900">Company</h2>
                <ul class="space-y-4">
                    @foreach ($company as $item)
                        <li>
                            <a href="{{ $item['href'] }}" class="text-slate-600 transition-colors hover:text-[#c2410c]">
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="flex flex-col items-start justify-between gap-4 border-t border-slate-200 pt-8 text-sm text-slate-500 md:flex-row md:items-center">
            <p>© {{ now()->year }} {{ config('site.name', config('app.name')) }}. Precision in digital editorial.</p>
            <div class="flex gap-8">
                <a href="{{ route('rss.feed') }}" class="uppercase tracking-[0.2em] transition-colors hover:text-[#c2410c]">RSS Feed</a>
                <a href="#" class="uppercase tracking-[0.2em] transition-colors hover:text-[#c2410c]">Archive</a>
            </div>
        </div>
    </div>
</footer>
