@php
    $categorySlug = request()->route('category');
    $categoryData = null;
    $homepageData = null;

    if ($categorySlug) {
        try {
            $categoryData = app(\App\Services\BlogContentService::class)->category((string) $categorySlug);
        } catch (\Throwable) {
            $categoryData = null;
        }
    } else {
        try {
            $homepagePayload = app(\App\Services\BlogContentService::class)->homepage();
            $homepageData = is_array(data_get($homepagePayload, 'data')) ? data_get($homepagePayload, 'data') : $homepagePayload;
        } catch (\Throwable) {
            $homepageData = null;
        }
    }

    $categoryLabel = $categoryData['name'] ?? ($categorySlug ? (string) \Illuminate\Support\Str::of((string) $categorySlug)->replace('-', ' ')->title() : null);
    $isCategoryPage = $categoryLabel !== null && $categorySlug !== 'all';
    $categorySeo = \App\Support\PublicApiValue::arrayValue(data_get($categoryData, 'seo'));
    $homepageHero = \App\Support\PublicApiValue::arrayValue(data_get($homepageData, 'hero'));
    $homepageSeo = \App\Support\PublicApiValue::arrayValue(data_get($homepageData, 'seo'));
    $homeHeroTitle = (string) (data_get($homepageHero, 'title') ?: 'All Articles');
    $homeHeroDescription = (string) (data_get($homepageHero, 'description') ?: 'Browse the full editorial archive of AI, blogging, SEO, case studies, and web development insights from Wide Web Blog.');

    $title = $isCategoryPage
        ? ((string) (data_get($categorySeo, 'meta_title') ?: $categoryLabel . ' | Wide Web Blog'))
        : ((string) (data_get($homepageSeo, 'meta_title') ?: 'All Articles | Wide Web Blog'));

    $description = $isCategoryPage
        ? ((string) (data_get($categorySeo, 'meta_description') ?: ($categoryData['description'] ?? ('Browse Wide Web Blog articles in ' . $categoryLabel . ', with practical insights for modern digital creators.'))))
        : ((string) (data_get($homepageSeo, 'meta_description') ?: $homeHeroDescription));

    $canonical = $isCategoryPage
        ? (\App\Support\PublicSiteUrl::normalize((string) (data_get($categorySeo, 'canonical_url') ?: route('articles.category', ['category' => $categorySlug]))))
        : route('home');

    $schema = [
        [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => $isCategoryPage ? $categoryLabel : $homeHeroTitle,
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
    active-nav="home"
>
    <livewire:all-articles-page
        :category="$categorySlug"
        :page-title="$isCategoryPage ? $categoryLabel : $homeHeroTitle"
        :page-description="$isCategoryPage ? $description : $homeHeroDescription"
    />
</x-layouts.marketing>
