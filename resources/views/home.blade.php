@php
    $title = 'Wide Web Blog | Premium Digital Editorial & Creator Guides';
    $description = 'Learn AI, SEO, blogging, and digital growth through practical editorial guides, creator playbooks, and technical walkthroughs.';
    $schema = [
        [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => config('site.name', config('app.name')),
            'url' => url('/'),
            'description' => $description,
        ],
        [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => config('site.name', config('app.name')),
            'url' => url('/'),
            'description' => config('site.description'),
        ],
    ];
@endphp

<x-layouts.marketing
    :title="$title"
    :description="$description"
    :canonical="url()->current()"
    :schema="$schema"
    active-nav="home"
>
    <livewire:home-page />
</x-layouts.marketing>
