@php
    try {
        /** @var array<string, mixed>|null $postPayload */
        $postPayload = app(\App\Services\BlogContentService::class)->post((string) $slug);
    } catch (\Throwable) {
        $postPayload = null;
    }

    abort_if($postPayload === null, 404);

    $seo = data_get($postPayload, 'seo', []);
    $title = (string) (data_get($seo, 'meta_title') ?: data_get($postPayload, 'title', 'Article').' | Wide Web Blog');
    $description = (string) (data_get($seo, 'meta_description') ?: data_get($postPayload, 'excerpt', ''));
    $canonical = (string) (data_get($seo, 'canonical_url') ?: data_get($postPayload, 'canonical_url') ?: url()->current());
    $image = \App\Support\MediaUrl::normalize((string) (data_get($seo, 'og_image.url') ?: data_get($postPayload, 'featured_image') ?: data_get($postPayload, 'featured_media.url') ?: ''));
    $robots = sprintf(
        '%s,%s',
        data_get($seo, 'robots_index', true) ? 'index' : 'noindex',
        data_get($seo, 'robots_follow', true) ? 'follow' : 'nofollow',
    );
    $schemaPayload = data_get($postPayload, 'schema', []);
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
