@php
    $title = 'About Us | Wide Web Blog';
    $description = 'Learn the mission, values, and people behind Wide Web Blog, an independent publication focused on AI, SEO, digital systems, and modern growth strategy.';
    $schema = [
        [
            '@context' => 'https://schema.org',
            '@type' => 'AboutPage',
            'name' => 'About Us',
            'url' => url('/about'),
            'description' => $description,
        ],
    ];
@endphp

<x-layouts.marketing
    :title="$title"
    :description="$description"
    :canonical="url()->current()"
    :schema="$schema"
    active-nav="about"
>
    <livewire:about-page />
</x-layouts.marketing>
