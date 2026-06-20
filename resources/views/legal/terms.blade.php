@php
    try {
        $pagePayload = app(\App\Services\BlogContentService::class)->page('terms-and-conditions');
    } catch (\Throwable) {
        $pagePayload = [];
    }

    $pageData = is_array(data_get($pagePayload ?? [], 'data')) ? data_get($pagePayload ?? [], 'data') : ($pagePayload ?? []);
    $seo = is_array(data_get($pageData, 'seo')) ? data_get($pageData, 'seo') : [];
    $pageTitle = filled(data_get($pageData, 'title')) ? (string) data_get($pageData, 'title') : 'Terms and Conditions';
    $description = filled(data_get($seo, 'meta_description'))
        ? (string) data_get($seo, 'meta_description')
        : (filled(data_get($pageData, 'summary'))
            ? (string) data_get($pageData, 'summary')
            : 'Review the terms governing your use of Wide Web Blog, including content usage, limitations, and general responsibilities.');
    $title = filled(data_get($seo, 'meta_title'))
        ? (string) data_get($seo, 'meta_title')
        : $pageTitle.' | Wide Web Blog';
    $effectiveDate = filled(data_get($pageData, 'published_at'))
        ? \Illuminate\Support\Carbon::parse((string) data_get($pageData, 'published_at'))->toFormattedDateString()
        : 'June 20, 2026';
    $contentHtml = filled(data_get($pageData, 'content_markdown'))
        ? \Illuminate\Support\Str::markdown((string) data_get($pageData, 'content_markdown'))
        : null;
@endphp

<x-layouts.marketing
    :title="$title"
    :description="$description"
    :canonical="filled(data_get($pageData, 'canonical_url')) ? data_get($pageData, 'canonical_url') : url()->current()"
    active-nav=""
>
    <x-legal.page
        eyebrow="Terms"
        :title="$pageTitle"
        :summary="$description"
        :effective-date="$effectiveDate"
        :content-html="$contentHtml"
    />
</x-layouts.marketing>
