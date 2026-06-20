<?php

declare(strict_types=1);

namespace App\Support;

class ResourceCatalog
{
    /**
     * @return array<int, array{slug: string, label: string}>
     */
    public static function filters(): array
    {
        return [
            ['slug' => 'all', 'label' => 'All Resources'],
            ['slug' => 'ui-kits', 'label' => 'UI Kits'],
            ['slug' => 'e-books', 'label' => 'E-Books'],
            ['slug' => 'templates', 'label' => 'Templates'],
            ['slug' => 'checklists', 'label' => 'Checklists'],
        ];
    }

    /**
     * @return array<int, array{value: string, label: string}>
     */
    public static function sortOptions(): array
    {
        return [
            ['value' => 'newest', 'label' => 'Newest First'],
            ['value' => 'oldest', 'label' => 'Oldest First'],
            ['value' => 'alphabetical', 'label' => 'Alphabetical'],
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function all(): array
    {
        return [
            [
                'slug' => 'free-digital-creator-kit',
                'category' => 'Featured Resource',
                'category_slug' => 'all',
                'type' => 'Bundle',
                'title' => 'Free Digital Creator Kit',
                'excerpt' => 'A comprehensive bundle of assets designed for modern writers and developers. Includes 50+ high-res icons, dark mode UI templates, and a 40-page guide to technical storytelling.',
                'meta' => 'ZIP • 124MB',
                'cta' => 'Download Now',
                'secondary_cta' => 'Learn More',
                'updated_at' => '2024-05-18',
                'image' => 'https://images.unsplash.com/photo-1516321165247-4aa89a48be28?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'slug' => 'minimalist-dashboard-kit',
                'category' => 'UI Kit',
                'category_slug' => 'ui-kits',
                'type' => 'Figma',
                'title' => 'Minimalist Dashboard Kit',
                'excerpt' => 'A Figma-ready dashboard kit with over 200 components and 40 pre-built views for SaaS teams.',
                'meta' => 'VL4 • 18MB',
                'cta' => 'Download',
                'updated_at' => '2024-05-16',
                'image' => 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'slug' => 'seo-for-developers',
                'category' => 'E-Book',
                'category_slug' => 'e-books',
                'type' => 'PDF',
                'title' => 'SEO for Developers',
                'excerpt' => 'The ultimate technical guide to optimizing React and Next.js applications for search visibility and crawlability.',
                'meta' => 'PDF • 5.2MB',
                'cta' => 'Read More',
                'updated_at' => '2024-05-14',
                'image' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'slug' => 'tailwind-animation-library',
                'category' => 'Code Snippets',
                'category_slug' => 'ui-kits',
                'type' => 'ZIP',
                'title' => 'Tailwind Animation Library',
                'excerpt' => 'A collection of 50+ copy-paste Tailwind CSS animation utility classes for modern landing pages and dashboards.',
                'meta' => 'ZIP • 1.2MB',
                'cta' => 'Download',
                'updated_at' => '2024-05-12',
                'image' => 'https://images.unsplash.com/photo-1517180102446-f3ece451e9d8?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'slug' => 'content-strategy-notion-template',
                'category' => 'Templates',
                'category_slug' => 'templates',
                'type' => 'Notion',
                'title' => 'Content Strategy Notion Template',
                'excerpt' => 'Organize your editorial calendar, keyword research, and distribution workflow in this clean Notion system.',
                'meta' => 'Notion Link',
                'cta' => 'Get Access',
                'updated_at' => '2024-05-10',
                'image' => 'https://images.unsplash.com/photo-1543286386-713bdd548da4?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'slug' => '2024-brand-identity-kit',
                'category' => 'Branding',
                'category_slug' => 'templates',
                'type' => 'SVG/PNG',
                'title' => '2024 Brand Identity Kit',
                'excerpt' => 'The complete logo set, typography guidelines, and color palettes for the Wide Web Blog design language.',
                'meta' => 'SVG/PNG • 42MB',
                'cta' => 'Download',
                'updated_at' => '2024-05-08',
                'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'slug' => 'pre-launch-website-checklist',
                'category' => 'Checklist',
                'category_slug' => 'checklists',
                'type' => 'PDF',
                'title' => 'Pre-Launch Website Checklist',
                'excerpt' => 'A rigorous 75-point checklist covering performance, accessibility, security, and SEO before launch.',
                'meta' => 'PDF • 1MB',
                'cta' => 'Download',
                'updated_at' => '2024-05-06',
                'image' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?auto=format&fit=crop&w=1200&q=80',
            ],
        ];
    }
}
