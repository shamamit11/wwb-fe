@props([
    'title' => config('site.name', config('app.name')),
    'description' => config('site.description'),
    'canonical' => null,
    'image' => null,
    'type' => 'website',
    'robots' => 'index,follow',
    'schema' => [],
    'activeNav' => 'home',
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <x-seo.meta
            :title="$title"
            :description="$description"
            :canonical="$canonical"
            :image="$image"
            :type="$type"
            :robots="$robots"
            :schema="$schema"
        />
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
        @livewireStyles
    </head>
    <body class="min-h-screen bg-white font-sans text-[var(--brand-ink)] antialiased selection:bg-[var(--brand-accent-soft)] selection:text-[var(--brand-ink)]">
        <div class="site-shell min-h-screen">
            <x-site.header :active="$activeNav" />
            {{ $slot }}
            <x-site.footer />
        </div>
        @livewireScriptConfig
    </body>
</html>
