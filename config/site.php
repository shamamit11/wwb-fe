<?php

declare(strict_types=1);

return [
    'name' => 'Wide Web Blog',
    'tagline' => 'Premium Digital Editorial & Creator Guides',
    'description' => 'Authority-led insights and practical tutorials on AI, SEO, blogging, and digital growth for modern digital creators.',
    'google_site_verification' => env('GOOGLE_SITE_VERIFICATION'),
    'navigation' => [
        ['label' => 'Home', 'href' => '/', 'key' => 'home'],
        ['label' => 'All Articles', 'href' => '/articles', 'key' => 'articles'],
        ['label' => 'About Us', 'href' => '/about', 'key' => 'about'],
        ['label' => 'Contact Us', 'href' => '/contact', 'key' => 'contact'],
    ],
    'footer' => [
        'brand_name' => 'Wide Web Blog',
        'description' => 'An authoritative digital editorial focused on technical SEO, AI implementation, and content architecture for the modern web.',
        'social_links' => [
            ['label' => 'Share', 'url' => '#', 'icon' => 'share'],
            ['label' => 'Public', 'url' => '#', 'icon' => 'public'],
            ['label' => 'Email', 'url' => '#newsletter', 'icon' => 'alternate_email'],
        ],
        'legal_links' => [
            ['label' => 'Privacy Policy', 'slug' => 'privacy-policy', 'url' => null],
            ['label' => 'Terms and Conditions', 'slug' => 'terms-and-conditions', 'url' => null],
        ],
        'categories' => [
            ['label' => 'AI Tools', 'href' => '/articles/category/ai-tools'],
            ['label' => 'AI Agents', 'href' => '/articles/category/ai-agents'],
            ['label' => 'SEO', 'href' => '/articles/category/seo'],
            ['label' => 'Content Marketing', 'href' => '/articles/category/content-marketing'],
            ['label' => 'Productivity & Automation', 'href' => '/articles/category/productivity-automation'],
            ['label' => 'Developer AI', 'href' => '/articles/category/developer-ai'],
            ['label' => 'News & Trends', 'href' => '/articles/category/news-trends'],
        ],
    ],
];
