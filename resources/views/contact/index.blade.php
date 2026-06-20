@php
    $title = 'Contact | Wide Web Blog';
    $description = 'Start a conversation with Wide Web Blog about editorial ideas, collaborations, partnerships, or product questions through our contact form.';
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
    <livewire:contact-page />
</x-layouts.marketing>
