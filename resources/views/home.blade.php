@php
    $homeData = is_array(data_get($homepagePayload ?? [], 'data')) ? data_get($homepagePayload ?? [], 'data') : ($homepagePayload ?? []);
    $seo = is_array(data_get($homeData, 'seo')) ? data_get($homeData, 'seo') : [];
    $title = filled(data_get($seo, 'meta_title')) ? data_get($seo, 'meta_title') : 'Wide Web Blog | Premium Digital Editorial & Creator Guides';
    $description = filled(data_get($seo, 'meta_description')) ? data_get($seo, 'meta_description') : 'Learn AI, SEO, blogging, and digital growth through practical editorial guides, creator playbooks, and technical walkthroughs.';
    $canonical = url()->current();
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
    :canonical="$canonical"
    :schema="$schema"
    active-nav="home"
>
    <livewire:home-page :homepage-payload="$homeData" />
</x-layouts.marketing>
