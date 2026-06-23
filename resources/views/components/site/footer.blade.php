@props([
    'footerData' => [],
    'categories' => [],
])

<footer id="about" class="border-t border-slate-200/80 bg-slate-50 px-6 py-16 lg:px-8">
    <div class="mx-auto max-w-7xl">
        <div class="mb-16 grid gap-12 md:grid-cols-4">
            <div class="md:col-span-2">
                <x-site.brand :name="data_get($footerData, 'brand_name', config('site.name', config('app.name')))" />
                @if (filled(data_get($footerData, 'description')))
                    <p class="mt-8 max-w-md text-base leading-8 text-slate-600">
                        {{ data_get($footerData, 'description') }}
                    </p>
                @endif
                @if (data_get($footerData, 'social_links', []) !== [])
                    <div class="mt-8 flex gap-4">
                        @foreach (data_get($footerData, 'social_links', []) as $item)
                            <a href="{{ $item['url'] }}"
                            aria-label="{{ $item['label'] }}"
                            class="flex h-12 w-12 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-600 transition-all hover:border-[var(--brand-accent)] hover:bg-[var(--brand-accent)] hover:text-white">
                                <x-site.icon :name="$item['icon']" />
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <div>
                <h2 class="mb-6 text-sm font-semibold uppercase tracking-[0.2em] text-slate-900">Categories</h2>
                <ul class="space-y-4">
                    @foreach ($categories as $item)
                        <li>
                            <a href="{{ $item['href'] }}" class="text-slate-600 transition-colors hover:text-[var(--brand-accent)]">
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            @if (data_get($footerData, 'legal_links', []) !== [])
                <div>
                    <h2 class="mb-6 text-sm font-semibold uppercase tracking-[0.2em] text-slate-900">Legal</h2>
                    <ul class="space-y-4">
                        @foreach (data_get($footerData, 'legal_links', []) as $item)
                            <li>
                                <a href="{{ $item['href'] }}" class="text-slate-600 transition-colors hover:text-[var(--brand-accent)]">
                                    {{ $item['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="flex flex-col items-start justify-between gap-4 border-t border-slate-200 pt-8 text-sm text-slate-500 md:flex-row md:items-center">
            @php
                $currentUrl = url()->current();
                $currentPath = request()->getPathInfo();

                if ($currentPath === '/') {
                    $siteUrl = rtrim($currentUrl, '/');
                } else {
                    $siteUrl = explode($currentPath, $currentUrl, 2)[0] ?? '';
                }

                $siteUrl = $siteUrl !== '' ? $siteUrl : $currentUrl;
            @endphp
            <p>© {{ now()->year }} {{ data_get($footerData, 'brand_name', config('site.name', config('app.name'))) }}.</p>
            <div class="flex gap-8">
                <a href="{{ $siteUrl.route('rss.feed', [], false) }}" class="uppercase tracking-[0.2em] transition-colors hover:text-[var(--brand-accent)]">RSS Feed</a>
            </div>
        </div>
    </div>
</footer>
