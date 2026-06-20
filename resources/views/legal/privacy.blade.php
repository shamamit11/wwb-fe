@php
    try {
        $pagePayload = app(\App\Services\BlogContentService::class)->page('privacy-policy');
    } catch (\Throwable) {
        $pagePayload = [];
    }

    $pageData = is_array(data_get($pagePayload ?? [], 'data')) ? data_get($pagePayload ?? [], 'data') : ($pagePayload ?? []);
    $seo = is_array(data_get($pageData, 'seo')) ? data_get($pageData, 'seo') : [];
    $pageTitle = filled(data_get($pageData, 'title')) ? (string) data_get($pageData, 'title') : 'Privacy Policy';
    $description = filled(data_get($seo, 'meta_description'))
        ? (string) data_get($seo, 'meta_description')
        : (filled(data_get($pageData, 'summary'))
            ? (string) data_get($pageData, 'summary')
            : 'Read how Wide Web Blog handles personal information, analytics, cookies, and communication preferences.');
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
        eyebrow="Privacy"
        :title="$pageTitle"
        :summary="$description"
        :effective-date="$effectiveDate"
        :content-html="$contentHtml"
    />
</x-layouts.marketing>
