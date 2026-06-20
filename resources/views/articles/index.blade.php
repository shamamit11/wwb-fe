@php
    $categorySlug = request()->route('category');
    $categoryData = null;

    if ($categorySlug) {
        try {
            $categoryData = app(\App\Services\BlogContentService::class)->category((string) $categorySlug);
        } catch (\Throwable) {
            $categoryData = null;
        }
    }

    $categoryLabel = $categoryData['name'] ?? ($categorySlug ? (string) \Illuminate\Support\Str::of((string) $categorySlug)->replace('-', ' ')->title() : null);
    $isCategoryPage = $categoryLabel !== null && $categorySlug !== 'all';

    $title = $isCategoryPage
        ? $categoryLabel . ' | Wide Web Blog'
        : 'All Articles | Wide Web Blog';

    $description = $isCategoryPage
        ? ($categoryData['description'] ?? ('Browse Wide Web Blog articles in ' . $categoryLabel . ', with practical insights for modern digital creators.'))
        : 'Browse the full editorial archive of AI, blogging, SEO, case studies, and web development insights from Wide Web Blog.';

    $canonical = $isCategoryPage
        ? route('articles.category', ['category' => $categorySlug])
        : route('articles.index');

    $schema = [
        [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => $isCategoryPage ? $categoryLabel : 'All Articles',
            'url' => $canonical,
            'description' => $description,
        ],
    ];
@endphp

<x-layouts.marketing
    :title="$title"
    :description="$description"
    :canonical="$canonical"
    :schema="$schema"
    active-nav="articles"
>
    <livewire:all-articles-page
        :category="$categorySlug"
        :page-title="$isCategoryPage ? $categoryLabel : 'All Articles'"
        :page-description="$description"
    />
</x-layouts.marketing>
