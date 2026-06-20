@php
    $title = 'Terms and Conditions | Wide Web Blog';
    $description = 'Review the terms governing your use of Wide Web Blog, including content usage, limitations, and general responsibilities.';
    $sections = [
        [
            'heading' => 'Use of the Site',
            'paragraphs' => [
                'By using this site, you agree to access and use its content responsibly and in a manner consistent with applicable law.',
                'You may browse, read, and reference the content for personal or internal informational purposes, but you may not misuse the site or attempt to disrupt its operation.',
            ],
        ],
        [
            'heading' => 'Editorial Content',
            'paragraphs' => [
                'Wide Web Blog publishes educational and editorial material intended to inform and guide readers. It should not be interpreted as legal, financial, or professional advice tailored to your specific situation.',
                'We work to keep information useful and current, but we do not guarantee that every page is complete, error-free, or suitable for every use case.',
            ],
        ],
        [
            'heading' => 'Intellectual Property',
            'paragraphs' => [
                'Unless otherwise stated, the content, branding, and design elements on this site belong to Wide Web Blog or are used with permission.',
                'You may not reproduce, republish, or redistribute substantial portions of the site in a way that implies ownership, endorsement, or unauthorized commercial reuse.',
            ],
        ],
        [
            'heading' => 'External Links and Resources',
            'paragraphs' => [
                'Some pages may reference external services, tools, or websites for context. We are not responsible for the content, availability, or practices of those third-party destinations.',
                'Accessing third-party websites from this site is done at your own discretion.',
            ],
        ],
        [
            'heading' => 'Limitation of Liability',
            'paragraphs' => [
                'To the extent permitted by law, Wide Web Blog is not liable for losses or damages arising from your use of the site, reliance on published content, or inability to access the site.',
                'These terms may be updated from time to time. Continued use of the site after changes means you accept the revised terms.',
            ],
        ],
    ];
@endphp

<x-layouts.marketing
    :title="$title"
    :description="$description"
    :canonical="url()->current()"
    active-nav=""
>
    <x-legal.page
        eyebrow="Terms"
        title="Terms and Conditions"
        :summary="$description"
        effective-date="June 20, 2026"
        :sections="$sections"
    />
</x-layouts.marketing>
