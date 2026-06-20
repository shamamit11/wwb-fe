@php
    $title = 'Resources | Wide Web Blog';
    $description = 'Download editorial templates, UI kits, checklists, and technical guides curated for creators, developers, and content teams.';
    $schema = [
        [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => 'Resources',
            'url' => url('/resources'),
            'description' => $description,
        ],
    ];
@endphp

<x-layouts.marketing
    :title="$title"
    :description="$description"
    :canonical="url()->current()"
    :schema="$schema"
    active-nav="resources"
>
    <livewire:resources-page />
</x-layouts.marketing>
