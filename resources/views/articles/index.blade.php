@php
    $title = 'All Articles | Wide Web Blog';
    $description = 'Browse the full editorial archive of AI, blogging, SEO, case studies, and web development insights from Wide Web Blog.';
    $schema = [
        [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => 'All Articles',
            'url' => url('/articles'),
            'description' => $description,
        ],
    ];
@endphp

<x-layouts.marketing
    :title="$title"
    :description="$description"
    :canonical="url()->current()"
    :schema="$schema"
    active-nav=""
>
    <livewire:all-articles-page />
</x-layouts.marketing>
