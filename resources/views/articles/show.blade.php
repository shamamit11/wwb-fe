@php
    /** @var array<string, mixed> $article */
    $article = \App\Support\ArticleCatalog::find($slug) ?? abort(404);
    $title = $article['title'].' | Wide Web Blog';
    $description = $article['summary'] ?? $article['excerpt'];
    $schema = [
        [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $article['title'],
            'description' => $description,
            'author' => [
                '@type' => 'Person',
                'name' => $article['author'],
            ],
            'datePublished' => $article['date'],
            'image' => [$article['image']],
            'mainEntityOfPage' => url()->current(),
        ],
    ];
@endphp

<x-layouts.marketing
    :title="$title"
    :description="$description"
    :canonical="url()->current()"
    :image="$article['image']"
    :schema="$schema"
    active-nav="articles"
>
    <livewire:article-detail-page :slug="$slug" />
</x-layouts.marketing>
