<?php

declare(strict_types=1);

return [
    'name' => 'Wide Web Blog',
    'tagline' => 'Premium Digital Editorial & Creator Guides',
    'description' => 'Authority-led insights and practical tutorials on AI, SEO, blogging, and digital growth for modern digital creators.',
    'navigation' => [
        ['label' => 'Home', 'href' => '/', 'key' => 'home'],
        ['label' => 'AI Tools', 'href' => '/#featured', 'key' => 'featured'],
        ['label' => 'Guides', 'href' => '/#guides', 'key' => 'guides'],
        ['label' => 'Topics', 'href' => '/#topics', 'key' => 'topics'],
        ['label' => 'Resources', 'href' => '/#resources', 'key' => 'resources'],
        ['label' => 'About', 'href' => '/#about', 'key' => 'about'],
    ],
    'footer' => [
        'categories' => [
            ['label' => 'AI Tools', 'href' => '/#topics'],
            ['label' => 'Blogging', 'href' => '/#topics'],
            ['label' => 'SEO', 'href' => '/#topics'],
            ['label' => 'Digital Assets', 'href' => '/#topics'],
            ['label' => 'Productivity', 'href' => '/#guides'],
            ['label' => 'Tech Guides', 'href' => '/#guides'],
            ['label' => 'Online Income', 'href' => '/#guides'],
            ['label' => 'Tutorials', 'href' => '/#guides'],
        ],
        'company' => [
            ['label' => 'About Us', 'href' => '/#about'],
            ['label' => 'Editorial Guidelines', 'href' => '/#about'],
            ['label' => 'Privacy Policy', 'href' => '#'],
            ['label' => 'Terms of Service', 'href' => '#'],
            ['label' => 'Contact Us', 'href' => '#newsletter'],
        ],
    ],
    'social' => [
        ['label' => 'Share', 'icon' => 'share', 'href' => '#'],
        ['label' => 'Public', 'icon' => 'public', 'href' => '#'],
        ['label' => 'Email', 'icon' => 'alternate_email', 'href' => '#newsletter'],
    ],
];
