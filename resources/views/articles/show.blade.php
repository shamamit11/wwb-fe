@php
    try {
        /** @var array<string, mixed>|null $postPayload */
        $postPayload = app(\App\Services\BlogContentService::class)->post((string) $slug);
    } catch (\Throwable) {
        $postPayload = null;
    }

    abort_if($postPayload === null, 404);

    $seo = \App\Support\PublicApiValue::arrayValue(data_get($postPayload, 'seo'));
    $featuredMedia = \App\Support\PublicApiValue::firstArray(data_get($postPayload, 'featured_media'));
    $ogImageMedia = \App\Support\PublicApiValue::firstArray(data_get($seo, 'og_image_media'));
    $category = \App\Support\PublicApiValue::arrayValue(data_get($postPayload, 'category'));
    $title = (string) (data_get($seo, 'meta_title') ?: data_get($postPayload, 'title', 'Article').' | Wide Web Blog');
    $description = (string) (data_get($seo, 'meta_description') ?: data_get($postPayload, 'short_description') ?: data_get($postPayload, 'description') ?: '');
    $canonical = \App\Support\PublicSiteUrl::articleUrl((string) $slug);
    $image = \App\Support\MediaUrl::normalize((string) (data_get($ogImageMedia, 'url') ?: data_get($postPayload, 'featured_image') ?: data_get($featuredMedia, 'url') ?: ''));
    $robots = sprintf(
        '%s,%s',
        data_get($seo, 'robots_index', true) ? 'index' : 'noindex',
        data_get($seo, 'robots_follow', true) ? 'follow' : 'nofollow',
    );
    $schemaPayload = \App\Support\PublicApiValue::arrayValue(data_get($postPayload, 'schema', data_get($seo, 'schema_payload', [])));
    $schemaPayload = \App\Support\PublicSiteUrl::normalizeArticleContextRecursive(
        $schemaPayload,
        (string) $slug,
        (string) data_get($category, 'slug', ''),
    );
    if (is_array($schemaPayload) && ! array_is_list($schemaPayload)) {
        $schemaPayload = \App\Support\PublicSiteUrl::normalizeArticleSchema(
            $schemaPayload,
            (string) $slug,
            (string) data_get($category, 'slug', ''),
        );
    }
    $schema = is_array($schemaPayload) && array_is_list($schemaPayload) ? $schemaPayload : (is_array($schemaPayload) && $schemaPayload !== [] ? [$schemaPayload] : []);
@endphp

<x-layouts.marketing
    :title="$title"
    :description="$description"
    :canonical="$canonical"
    :image="$image"
    type="article"
    :robots="$robots"
    :schema="$schema"
    active-nav="articles"
>
    <livewire:article-detail-page :slug="$slug" :post-payload="$postPayload" />
</x-layouts.marketing>
