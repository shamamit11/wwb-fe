@php
    try {
        $aboutPayload = app(\App\Services\BlogContentService::class)->about();
    } catch (\Throwable) {
        $aboutPayload = [];
    }

    $aboutData = is_array(data_get($aboutPayload ?? [], 'data')) ? data_get($aboutPayload ?? [], 'data') : ($aboutPayload ?? []);
    $seo = is_array(data_get($aboutData, 'seo')) ? data_get($aboutData, 'seo') : [];
    $hero = is_array(data_get($aboutData, 'hero')) ? data_get($aboutData, 'hero') : [];

    $title = filled(data_get($seo, 'meta_title'))
        ? data_get($seo, 'meta_title')
        : 'About Us | Wide Web Blog';
    $description = filled(data_get($seo, 'meta_description'))
        ? data_get($seo, 'meta_description')
        : (filled(data_get($hero, 'description'))
            ? data_get($hero, 'description')
            : 'Learn the mission, values, and people behind Wide Web Blog, an independent publication focused on AI, SEO, digital systems, and modern growth strategy.');
    $schema = [
        [
            '@context' => 'https://schema.org',
            '@type' => 'AboutPage',
            'name' => 'About Us',
            'url' => url('/about'),
            'description' => $description,
        ],
    ];
@endphp

<x-layouts.marketing
    :title="$title"
    :description="$description"
    :canonical="url()->current()"
    :schema="$schema"
    active-nav="about"
>
    <livewire:about-page :about-payload="$aboutData" />
</x-layouts.marketing>
