@php
    $title = 'Privacy Policy | Wide Web Blog';
    $description = 'Read how Wide Web Blog handles personal information, analytics, cookies, and communication preferences.';
    $sections = [
        [
            'heading' => 'What We Collect',
            'paragraphs' => [
                'We may collect information you provide directly through forms on this site, including your name, email address, and the message content you submit.',
                'We may also collect limited technical information such as browser type, approximate device information, and usage patterns through standard analytics tools.',
            ],
        ],
        [
            'heading' => 'How We Use Information',
            'paragraphs' => [
                'We use submitted information to respond to inquiries, improve our editorial products, and understand how readers engage with our content.',
                'We do not treat your data as a commodity. Information is used to operate and improve the publication, not to create unnecessary noise around it.',
            ],
        ],
        [
            'heading' => 'Cookies and Analytics',
            'paragraphs' => [
                'This site may use cookies or similar technologies to support analytics, performance measurement, and basic site functionality.',
                'You can usually control cookie behavior through your browser settings, though some site functionality may be affected if those settings are disabled.',
            ],
        ],
        [
            'heading' => 'Third-Party Services',
            'paragraphs' => [
                'We may use third-party providers for hosting, analytics, email delivery, or embedded assets. Those providers may process limited data strictly as part of delivering their services.',
                'We encourage you to review the privacy practices of those providers if you want detail beyond what is described here.',
            ],
        ],
        [
            'heading' => 'Your Choices',
            'paragraphs' => [
                'You may choose not to submit personal information through site forms. If you previously shared information and want it reviewed or removed where feasible, contact us through the site contact form.',
                'We may update this policy over time to reflect operational or legal changes. Continued use of the site after updates means you accept the revised policy.',
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
        eyebrow="Privacy"
        title="Privacy Policy"
        :summary="$description"
        effective-date="June 20, 2026"
        :sections="$sections"
    />
</x-layouts.marketing>
