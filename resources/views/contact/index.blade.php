@php
    try {
        $contactPayload = app(\App\Services\BlogContentService::class)->contact();
    } catch (\Throwable) {
        $contactPayload = [];
    }

    $contactData = is_array(data_get($contactPayload ?? [], 'data')) ? data_get($contactPayload ?? [], 'data') : ($contactPayload ?? []);
    $seo = is_array(data_get($contactData, 'seo')) ? data_get($contactData, 'seo') : [];
    $hero = is_array(data_get($contactData, 'hero')) ? data_get($contactData, 'hero') : [];

    $title = filled(data_get($seo, 'meta_title'))
        ? data_get($seo, 'meta_title')
        : 'Contact | Wide Web Blog';
    $description = filled(data_get($seo, 'meta_description'))
        ? data_get($seo, 'meta_description')
        : (filled(data_get($hero, 'description'))
            ? data_get($hero, 'description')
            : 'Start a conversation with Wide Web Blog about editorial ideas, collaborations, partnerships, or product questions through our contact form.');
    $schema = [
        [
            '@context' => 'https://schema.org',
            '@type' => 'ContactPage',
            'name' => 'Contact',
            'url' => url('/contact'),
            'description' => $description,
        ],
    ];
@endphp

<x-layouts.marketing
    :title="$title"
    :description="$description"
    :canonical="url()->current()"
    :schema="$schema"
    active-nav="contact"
>
    <livewire:contact-page :contact-payload="$contactData" />
</x-layouts.marketing>
