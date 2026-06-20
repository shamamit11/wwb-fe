@php
    $query = trim((string) request('q', ''));
    $title = $query !== ''
        ? 'Search: '.$query.' | Wide Web Blog'
        : 'Search | Wide Web Blog';
    $description = $query !== ''
        ? 'Search results for '.$query.' on Wide Web Blog.'
        : 'Search articles across Wide Web Blog.';
    $schema = [
        [
            '@context' => 'https://schema.org',
            '@type' => 'SearchResultsPage',
            'name' => $query !== '' ? 'Search results for '.$query : 'Search',
            'url' => url()->full(),
            'description' => $description,
        ],
    ];
@endphp

<x-layouts.marketing
    :title="$title"
    :description="$description"
    :canonical="url()->full()"
    robots="noindex,follow"
    :schema="$schema"
    active-nav=""
>
    <livewire:search-results-page :q="$query" />
</x-layouts.marketing>
