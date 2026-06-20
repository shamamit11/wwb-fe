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
        ['label' => 'Resources', 'href' => '/resources', 'key' => 'resources'],
        ['label' => 'About Us', 'href' => '/about', 'key' => 'about'],
        ['label' => 'Contact Us', 'href' => '/contact', 'key' => 'contact'],
    ],
    'footer' => [
        'categories' => [
            ['label' => 'AI Tools', 'href' => '/articles/category/ai-tools'],
            ['label' => 'AI Agents', 'href' => '/articles/category/ai-agents'],
            ['label' => 'SEO', 'href' => '/articles/category/seo'],
            ['label' => 'Content Marketing', 'href' => '/articles/category/content-marketing'],
            ['label' => 'Productivity & Automation', 'href' => '/articles/category/productivity-automation'],
            ['label' => 'Developer AI', 'href' => '/articles/category/developer-ai'],
            ['label' => 'News & Trends', 'href' => '/articles/category/news-trends'],
        ],
        'company' => [
            ['label' => 'About Us', 'href' => '/about'],
            ['label' => 'Privacy Policy', 'href' => '/privacy-policy'],
            ['label' => 'Terms and Conditions', 'href' => '/terms-and-conditions'],
            ['label' => 'Contact Us', 'href' => '/contact'],
        ],
    ],
    'social' => [
        ['label' => 'Share', 'icon' => 'share', 'href' => '#'],
        ['label' => 'Public', 'icon' => 'public', 'href' => '#'],
        ['label' => 'Email', 'icon' => 'alternate_email', 'href' => '#newsletter'],
    ],
];
