<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Services\BlogContentService;
use App\Support\MediaUrl;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Throwable;

class HomePage extends Component
{
    /** @var array<string, mixed> */
    public array $hero = [];

    /** @var array<string, mixed> */
    public array $featuredSection = [];

    /** @var array<string, mixed> */
    public array $guideSection = [];

    /** @var array<string, mixed> */
    public array $topicSection = [];

    /** @var array<string, mixed> */
    public array $promoSection = [];

    /** @var array<string, mixed> */
    public array $newsletterSection = [];

    #[Validate('required|email|max:255')]
    public string $newsletterEmail = '';

    public bool $newsletterToastVisible = false;

    public string $newsletterToastType = 'success';

    public string $newsletterToastMessage = 'Thank you for subscribing.';

    public function mount(BlogContentService $content, array $homepagePayload = []): void
    {
        $payload = $homepagePayload !== [] ? $homepagePayload : $this->resolveHomepagePayload();

        $this->hero = $this->defaultHero();
        $this->featuredSection = $this->defaultFeaturedSection();
        $this->guideSection = $this->defaultGuideSection();
        $this->topicSection = $this->defaultTopicSection();
        $this->promoSection = $this->defaultPromoSection();
        $this->newsletterSection = $this->defaultNewsletterSection();

        $resolved = is_array(data_get($payload, 'data')) ? data_get($payload, 'data') : $payload;

        if (! is_array($resolved) || $resolved === []) {
            return;
        }

        if ($this->hasManagedHomepageSections($resolved)) {
            $this->applyManagedHomepagePayload($resolved, $content);

            return;
        }

        $this->applyPublicHomepagePayload($resolved);
    }

    /**
     * @return array<string, mixed>
     */
    private function resolveHomepagePayload(): array
    {
        try {
            return app(BlogContentService::class)->homepage();
        } catch (Throwable) {
            return [];
        }
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    private function applyManagedHomepagePayload(array $payload, BlogContentService $content): void
    {
        $hero = is_array(data_get($payload, 'hero')) ? data_get($payload, 'hero') : [];
        $featured = is_array(data_get($payload, 'featured_editorial')) ? data_get($payload, 'featured_editorial') : [];
        $guide = is_array(data_get($payload, 'guide_section')) ? data_get($payload, 'guide_section') : [];
        $topic = is_array(data_get($payload, 'topic_section')) ? data_get($payload, 'topic_section') : [];
        $promo = is_array(data_get($payload, 'promo_section')) ? data_get($payload, 'promo_section') : [];
        $newsletter = is_array(data_get($payload, 'newsletter_section')) ? data_get($payload, 'newsletter_section') : [];

        $featuredPosts = $this->extractSectionPosts($featured, $content);
        $guidePosts = $this->extractSectionPosts($guide, $content);
        $topicCategories = $this->extractSectionCategories($topic, $content);

        $this->hero = [
            'eyebrow' => $this->stringOrDefault(data_get($hero, 'eyebrow'), $this->hero['eyebrow']),
            'title' => $this->stringOrDefault(data_get($hero, 'title'), $this->hero['title']),
            'description' => $this->stringOrDefault(data_get($hero, 'description'), $this->hero['description']),
            'primary_cta_label' => $this->stringOrDefault(data_get($hero, 'primary_cta_label'), $this->hero['primary_cta_label']),
            'primary_cta_url' => $this->stringOrDefault(data_get($hero, 'primary_cta_url'), $this->hero['primary_cta_url']),
            'secondary_cta_label' => $this->stringOrDefault(data_get($hero, 'secondary_cta_label'), $this->hero['secondary_cta_label']),
            'secondary_cta_url' => $this->stringOrDefault(data_get($hero, 'secondary_cta_url'), $this->hero['secondary_cta_url']),
            'image' => $this->stringOrDefault(data_get($hero, 'media_url'), $this->hero['image']),
            'image_alt' => $this->stringOrDefault(data_get($hero, 'media_alt'), $this->hero['image_alt']),
        ];

        if ($featuredPosts !== []) {
            $this->featuredSection = [
                'title' => $this->stringOrDefault(data_get($featured, 'title'), $this->featuredSection['title']),
                'description' => $this->stringOrDefault(data_get($featured, 'description'), $this->featuredSection['description']),
                'lead' => $featuredPosts[0],
                'secondary' => array_slice($featuredPosts, 1, 2),
            ];
        } else {
            $this->featuredSection['title'] = $this->stringOrDefault(data_get($featured, 'title'), $this->featuredSection['title']);
            $this->featuredSection['description'] = $this->stringOrDefault(data_get($featured, 'description'), $this->featuredSection['description']);
        }

        if ($guidePosts !== []) {
            $this->guideSection = [
                'title' => $this->stringOrDefault(data_get($guide, 'title'), $this->guideSection['title']),
                'description' => $this->stringOrDefault(data_get($guide, 'description'), $this->guideSection['description']),
                'items' => array_slice($guidePosts, 0, max(1, (int) data_get($guide, 'limit', 4))),
            ];
        } else {
            $this->guideSection['title'] = $this->stringOrDefault(data_get($guide, 'title'), $this->guideSection['title']);
            $this->guideSection['description'] = $this->stringOrDefault(data_get($guide, 'description'), $this->guideSection['description']);
        }

        if ($topicCategories !== []) {
            $this->topicSection = [
                'title' => $this->stringOrDefault(data_get($topic, 'title'), $this->topicSection['title']),
                'description' => $this->stringOrDefault(data_get($topic, 'description'), $this->topicSection['description']),
                'items' => $topicCategories,
            ];
        } else {
            $this->topicSection['title'] = $this->stringOrDefault(data_get($topic, 'title'), $this->topicSection['title']);
            $this->topicSection['description'] = $this->stringOrDefault(data_get($topic, 'description'), $this->topicSection['description']);
        }

        $promoStats = array_values(array_filter(
            array_map(fn (mixed $item): ?array => is_array($item) ? [
                'label' => $this->stringOrDefault(data_get($item, 'label'), ''),
                'value' => $this->stringOrDefault(data_get($item, 'value'), ''),
            ] : null, (array) data_get($promo, 'stats', [])),
            fn (?array $item): bool => is_array($item) && filled($item['label']) && filled($item['value']),
        ));

        $promoBullets = array_values(array_filter(
            array_map(
                fn (mixed $item): string => is_scalar($item) ? trim((string) $item) : '',
                (array) data_get($promo, 'bullet_points', []),
            ),
            fn (string $item): bool => $item !== '',
        ));

        $this->promoSection = [
            'enabled' => (bool) data_get($promo, 'enabled', $this->promoSection['enabled']),
            'eyebrow' => $this->stringOrDefault(data_get($promo, 'eyebrow'), $this->promoSection['eyebrow']),
            'title' => $this->stringOrDefault(data_get($promo, 'title'), $this->promoSection['title']),
            'description' => $this->stringOrDefault(data_get($promo, 'description'), $this->promoSection['description']),
            'bullet_points' => $promoBullets !== [] ? $promoBullets : $this->promoSection['bullet_points'],
            'primary_cta_label' => $this->stringOrDefault(data_get($promo, 'primary_cta_label'), $this->promoSection['primary_cta_label']),
            'primary_cta_url' => $this->stringOrDefault(data_get($promo, 'primary_cta_url'), $this->promoSection['primary_cta_url']),
            'stats' => $promoStats !== [] ? $promoStats : $this->promoSection['stats'],
        ];

        $this->newsletterSection = [
            'enabled' => (bool) data_get($newsletter, 'enabled', $this->newsletterSection['enabled']),
            'title' => $this->stringOrDefault(data_get($newsletter, 'title'), $this->newsletterSection['title']),
            'description' => $this->stringOrDefault(data_get($newsletter, 'description'), $this->newsletterSection['description']),
            'placeholder' => $this->newsletterSection['placeholder'],
            'button' => $this->newsletterSection['button'],
            'note' => $this->newsletterSection['note'],
        ];
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    private function applyPublicHomepagePayload(array $payload): void
    {
        $featuredPosts = array_values(array_filter(
            array_map(fn (mixed $item): ?array => is_array($item) ? $this->mapPostCard($item) : null, (array) data_get($payload, 'featured_posts', [])),
            fn (?array $item): bool => is_array($item),
        ));

        $latestPosts = array_values(array_filter(
            array_map(fn (mixed $item): ?array => is_array($item) ? $this->mapPostCard($item) : null, (array) data_get($payload, 'latest_posts', [])),
            fn (?array $item): bool => is_array($item),
        ));

        $categories = array_values(array_filter(
            array_map(fn (mixed $item): ?array => is_array($item) ? $this->mapCategoryCard($item) : null, (array) data_get($payload, 'categories', [])),
            fn (?array $item): bool => is_array($item),
        ));

        if ($featuredPosts !== []) {
            $this->featuredSection['lead'] = $featuredPosts[0];
            $this->featuredSection['secondary'] = array_slice($featuredPosts, 1, 2);
        }

        if ($latestPosts !== []) {
            $this->guideSection['items'] = array_slice($latestPosts, 0, 4);
        }

        if ($categories !== []) {
            $this->topicSection['items'] = $categories;
        }
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    private function hasManagedHomepageSections(array $payload): bool
    {
        return is_array(data_get($payload, 'hero'))
            || is_array(data_get($payload, 'featured_editorial'))
            || is_array(data_get($payload, 'guide_section'))
            || is_array(data_get($payload, 'topic_section'));
    }

    /**
     * @param  array<string, mixed>  $section
     * @return array<int, array<string, mixed>>
     */
    private function extractSectionPosts(array $section, BlogContentService $content): array
    {
        $limit = max(1, (int) data_get($section, 'limit', 4));

        foreach (['posts', 'items', 'resolved_posts', 'selected_posts'] as $key) {
            $items = data_get($section, $key);

            if (! is_array($items)) {
                continue;
            }

            $mapped = array_values(array_filter(
                array_map(fn (mixed $item): ?array => is_array($item) ? $this->mapPostCard($item) : null, $items),
                fn (?array $item): bool => is_array($item),
            ));

            if ($mapped !== []) {
                return array_slice($mapped, 0, $limit);
            }
        }

        $postIds = array_values(array_filter(
            array_map(static fn (mixed $id): int|string|null => is_int($id) || is_string($id) ? $id : null, (array) data_get($section, 'post_ids', [])),
            static fn (mixed $id): bool => $id !== null && $id !== '',
        ));

        if ($postIds !== []) {
            $mapped = array_values(array_filter(
                array_map(fn (array $item): ?array => $this->mapPostCard($item), $content->resolvePostsByIds($postIds)),
                fn (?array $item): bool => is_array($item),
            ));

            if ($mapped !== []) {
                return array_slice($mapped, 0, $limit);
            }
        }

        if (data_get($section, 'mode') === 'automatic' && data_get($section, 'category_ids') !== null) {
            $categoryIds = array_values(array_filter(
                array_map(static fn (mixed $id): int|string|null => is_int($id) || is_string($id) ? $id : null, (array) data_get($section, 'category_ids', [])),
                static fn (mixed $id): bool => $id !== null && $id !== '',
            ));

            if ($categoryIds !== []) {
                $mapped = array_values(array_filter(
                    array_map(
                        fn (array $item): ?array => $this->mapPostCard($item),
                        $content->resolvePostsForCategoryIds($categoryIds, $limit)
                    ),
                    fn (?array $item): bool => is_array($item),
                ));

                if ($mapped !== []) {
                    return $mapped;
                }
            }
        }

        return [];
    }

    /**
     * @param  array<string, mixed>  $section
     * @return array<int, array<string, string>>
     */
    private function extractSectionCategories(array $section, BlogContentService $content): array
    {
        foreach (['categories', 'items', 'resolved_categories', 'selected_categories'] as $key) {
            $items = data_get($section, $key);

            if (! is_array($items)) {
                continue;
            }

            $mapped = array_values(array_filter(
                array_map(fn (mixed $item): ?array => is_array($item) ? $this->mapCategoryCard($item) : null, $items),
                fn (?array $item): bool => is_array($item),
            ));

            if ($mapped !== []) {
                return $mapped;
            }
        }

        $categoryIds = array_values(array_filter(
            array_map(static fn (mixed $id): int|string|null => is_int($id) || is_string($id) ? $id : null, (array) data_get($section, 'category_ids', [])),
            static fn (mixed $id): bool => $id !== null && $id !== '',
        ));

        if ($categoryIds !== []) {
            $mapped = array_values(array_filter(
                array_map(fn (array $item): ?array => $this->mapCategoryCard($item), $content->resolveCategoriesByIds($categoryIds)),
                fn (?array $item): bool => is_array($item),
            ));

            if ($mapped !== []) {
                return $mapped;
            }
        }

        return [];
    }

    /**
     * @param  array<string, mixed>  $item
     * @return array<string, mixed>
     */
    private function mapPostCard(array $item): array
    {
        $category = data_get($item, 'category');
        $categoryName = is_array($category) ? (string) data_get($category, 'name', 'Article') : (string) data_get($item, 'category_name', 'Article');
        $author = $this->stringOrDefault(
            data_get($item, 'author.name') ?: data_get($item, 'author'),
            'Wide Web Blog'
        );
        $readTime = $this->resolveReadTime($item);

        return [
            'category' => $categoryName,
            'title' => $this->stringOrDefault(data_get($item, 'title'), 'Untitled article'),
            'excerpt' => $this->stringOrDefault(
                data_get($item, 'excerpt') ?: data_get($item, 'summary') ?: data_get($item, 'content_preview'),
                'Explore the latest editorial coverage on Wide Web Blog.'
            ),
            'author' => $author,
            'author_initials' => Str::of($author)
                ->explode(' ')
                ->filter()
                ->map(fn (string $part): string => Str::upper(Str::substr($part, 0, 1)))
                ->take(2)
                ->implode(''),
            'read_time' => $readTime,
            'meta_left' => $this->formatPublishedDate(data_get($item, 'published_at') ?: data_get($item, 'created_at')),
            'meta_right' => $readTime,
            'image' => $this->resolvePostImage($item),
            'image_alt' => $this->resolvePostImageAlt($item),
            'href' => $this->resolvePostHref($item),
        ];
    }

    /**
     * @param  array<string, mixed>  $item
     * @return array<string, string>
     */
    private function mapCategoryCard(array $item): array
    {
        $slug = $this->stringOrDefault(data_get($item, 'slug'), '');

        return [
            'icon' => $this->iconForCategory($slug),
            'label' => $this->stringOrDefault(data_get($item, 'name') ?: data_get($item, 'label'), 'Category'),
            'href' => $slug !== '' ? '/articles/category/'.$slug : '#topics',
        ];
    }

    /**
     * @param  array<string, mixed>  $item
     */
    private function resolvePostHref(array $item): string
    {
        $slug = $this->stringOrDefault(data_get($item, 'slug'), '');

        if ($slug !== '') {
            return '/articles/'.$slug;
        }

        return '#';
    }

    /**
     * @param  array<string, mixed>  $item
     */
    private function resolveReadTime(array $item): string
    {
        $explicit = $this->stringOrDefault(data_get($item, 'read_time'), '');

        if ($explicit !== '') {
            return $explicit;
        }

        $minutes = data_get($item, 'reading_time_minutes');

        if (is_numeric($minutes) && (int) $minutes > 0) {
            return (int) $minutes.' min read';
        }

        return '5 min read';
    }

    private function formatPublishedDate(mixed $value): string
    {
        if (! filled($value)) {
            return 'Published recently';
        }

        try {
            return Carbon::parse((string) $value)->format('M j, Y');
        } catch (Throwable) {
            return (string) $value;
        }
    }

    private function stringOrDefault(mixed $value, string $default): string
    {
        $resolved = is_scalar($value) ? trim((string) $value) : '';

        return $resolved !== '' ? $resolved : $default;
    }

    /**
     * @param  array<string, mixed>  $item
     */
    private function resolvePostImage(array $item): string
    {
        $image = $this->stringOrDefault(
            data_get($item, 'featured_media.url')
                ?: data_get($item, 'featured_image')
                ?: data_get($item, 'image')
                ?: data_get($item, 'media_url'),
            ''
        );

        if ($image === '') {
            return 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&w=1200&q=80';
        }

        return MediaUrl::normalize($image);
    }

    /**
     * @param  array<string, mixed>  $item
     */
    private function resolvePostImageAlt(array $item): string
    {
        return $this->stringOrDefault(
            data_get($item, 'featured_media.alt_text')
                ?: data_get($item, 'featured_image_alt')
                ?: data_get($item, 'image_alt')
                ?: data_get($item, 'title'),
            'Editorial article'
        );
    }

    private function iconForCategory(string $slug): string
    {
        return match ($slug) {
            'ai-tools' => 'robot',
            'blogging', 'content-marketing' => 'edit_square',
            'seo' => 'search',
            'productivity-automation' => 'bolt',
            'developer-ai' => 'integration_instructions',
            'ai-agents' => 'hub',
            'news-trends' => 'auto_stories',
            default => 'topic',
        };
    }

    /**
     * @return array<string, mixed>
     */
    private function defaultHero(): array
    {
        return [
            'eyebrow' => 'The Knowledge Hub',
            'title' => 'Learn AI, SEO, Blogging, and Digital Growth, One Practical Guide at a Time.',
            'description' => 'Authority-led insights and deep-dive technical tutorials for modern digital creators. Precision growth strategies without the noise.',
            'image' => 'https://lh3.googleusercontent.com/aida/AP1WRLvf6bNYE6HPvFPNQtZ3BkbryOhL_9yYAbzPHYh9DcTPvbTF3CZrsN3-1TUeiWLmY_SNeMm3mWoU-p53KXQFwYsiBW8SmvUwqzkBlnQZ7cT49nA3UbtgOAeSu4JXm7WnV90FvRK6OXZOzuupLRCzuZNoqZaxu4m82ZdhV9pqErLfj2s3QUm-3kpJtnr0k-7D4jo8CVzFa1hVZLzq29Whw1sleS28ADYq1zWYS17sHvTGuRPtS3nt7eK0vkM',
            'image_alt' => 'Modern creator workspace',
            'primary_cta_label' => 'Start Reading',
            'primary_cta_url' => '#featured',
            'secondary_cta_label' => 'View AI Tools',
            'secondary_cta_url' => '#topics',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function defaultFeaturedSection(): array
    {
        return [
            'title' => 'Featured Editorial',
            'description' => 'Expert analysis on the evolving digital landscape.',
            'lead' => [
                'category' => 'AI Tools',
                'title' => 'Architecting the Future: How Generative AI is Redefining Content Ecosystems',
                'excerpt' => 'Understanding the shift from keyword-based content to semantically rich, AI-assisted architecture that resonates with both machines and humans.',
                'author' => 'Alex Sterling',
                'author_initials' => 'AS',
                'read_time' => '12 Min Read',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAagyzljQP04j8aSKCYjzZp0Yl8fi2Gy60GzTCVvwNVDH3EFLqWBvPH3epYvQJRl_IoyTcE1pDIK05SZXARjEev2eyZ-pSFNuS1-5meJ_6VBIrlKMjigWsmdTOFHtvD3qAZrplEkznhv32AwHEKYJautvnPz2zrA-dH99g6hYT-psl-NPQnkyYBTX38fZ53ygeq6XltGMN3dYlP6KwoqGsinySBSDD1Y2cWJi8QzxBy_LvhzlbLw1YGmmMESTlgZXlsG-NWEMmIMqLf',
                'image_alt' => 'Architecting the Future: How Generative AI is Redefining Content Ecosystems',
                'href' => '#featured',
            ],
            'secondary' => [
                [
                    'category' => 'SEO',
                    'title' => 'The Semantic Web: Why Entities Matter More Than Keywords',
                    'meta_left' => '2 days ago',
                    'meta_right' => '6 Min Read',
                    'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBX0meBpqEhkU_X9ZqHPRp11BCDYwsRLHTOnpUJdOpQrQjQLfNNj_cWal1DuT2r62AH-JLya5x7iGQLYuuCAYo-EJMNtiSmZlLJsLQPrLOioG_cOuFSqzXCRlv3wTLcI5mPPb7eqNpzbT9hIz8SCA4RYxAS_A1aNIYgkzgfiRdDL95JIYgAlo81pIanaiyBK-E4JLCI6KYsi8mUngXeFgj8W2TasONKoe6EORo7oOAsZOvtZVKvL8Ep6XjCX24ls6RnUOtSYpc0L5QH',
                    'image_alt' => 'The Semantic Web: Why Entities Matter More Than Keywords',
                    'href' => '#featured',
                ],
                [
                    'category' => 'Blogging',
                    'title' => 'Scaling Editorial Operations: From Solo to Media Powerhouse',
                    'meta_left' => '8 Min Read',
                    'meta_right' => 'Published Recently',
                    'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBVa-JaSoZFBep7oRqnqo2JGszAV6_eT2x2_ZAhHFQWt5CUJ25ego6gb4QskdkfOPM-TU4S5i5GyZNVPDJW_M2T1-APBs4MSc8ueUPlwom7AugPXvBQGijbeu2OAgydxUCWtIDE-QxPkSsR58_a1xt71tyXuf-P856U_STKVWUroJWOg4m4SOnno6xr7vX_r0nK_qiUX9keHkXJDhZbWU_taP2HUVVXGiMZmkI3o7SkAe1mul1VFdvoxFYWQoXsDPvT7JMvV3JlEijF',
                    'image_alt' => 'Scaling Editorial Operations: From Solo to Media Powerhouse',
                    'href' => '#featured',
                ],
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function defaultGuideSection(): array
    {
        return [
            'title' => 'Practical Wisdom for Builders',
            'description' => 'Curated guides for technical creators and operators building durable digital systems.',
            'items' => [
                [
                    'category' => 'Tech Guides',
                    'title' => 'Mastering Prompt Engineering for LLMs',
                    'excerpt' => 'A foundational framework for getting predictable, high-quality outputs from advanced AI models.',
                    'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&q=80',
                    'image_alt' => 'Mastering Prompt Engineering for LLMs',
                    'meta_left' => 'Published recently',
                    'meta_right' => '15 min read',
                    'href' => '#guides',
                ],
                [
                    'category' => 'SEO',
                    'title' => 'Building a Knowledge Graph for Your Site',
                    'excerpt' => 'How to organize your content data for superior internal linking and semantic SEO relevance.',
                    'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=1200&q=80',
                    'image_alt' => 'Building a Knowledge Graph for Your Site',
                    'meta_left' => 'Published recently',
                    'meta_right' => '22 min read',
                    'href' => '#guides',
                ],
                [
                    'category' => 'Online Income',
                    'title' => 'Advanced Affiliate Monetization Strategies',
                    'excerpt' => 'Moving beyond banners: how to integrate high-converting affiliate funnels into editorial content.',
                    'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1200&q=80',
                    'image_alt' => 'Advanced Affiliate Monetization Strategies',
                    'meta_left' => 'Published recently',
                    'meta_right' => '18 min read',
                    'href' => '#guides',
                ],
                [
                    'category' => 'Productivity',
                    'title' => 'AI-Enhanced Editorial Workflows',
                    'excerpt' => 'Automating the repetitive tasks of content creation to focus on high-impact strategy and research.',
                    'image' => 'https://images.unsplash.com/photo-1516321165247-4aa89a48be28?auto=format&fit=crop&w=1200&q=80',
                    'image_alt' => 'AI-Enhanced Editorial Workflows',
                    'meta_left' => 'Published recently',
                    'meta_right' => '10 min read',
                    'href' => '#guides',
                ],
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function defaultTopicSection(): array
    {
        return [
            'title' => 'Browse by Topic',
            'description' => 'Explore our curated collections of technical and strategic resources tailored for your growth.',
            'items' => [
                ['icon' => 'robot', 'label' => 'AI Tools', 'href' => '/articles/category/ai-tools'],
                ['icon' => 'edit_square', 'label' => 'Blogging', 'href' => '#guides'],
                ['icon' => 'search', 'label' => 'SEO', 'href' => '/articles/category/seo'],
                ['icon' => 'hub', 'label' => 'AI Agents', 'href' => '/articles/category/ai-agents'],
                ['icon' => 'bolt', 'label' => 'Productivity', 'href' => '/articles/category/productivity-automation'],
                ['icon' => 'integration_instructions', 'label' => 'Developer AI', 'href' => '/articles/category/developer-ai'],
                ['icon' => 'auto_stories', 'label' => 'News & Trends', 'href' => '/articles/category/news-trends'],
                ['icon' => 'topic', 'label' => 'Content Marketing', 'href' => '/articles/category/content-marketing'],
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function defaultPromoSection(): array
    {
        return [
            'enabled' => true,
            'eyebrow' => 'Exclusive Resources',
            'title' => 'Free Digital Creator Kit',
            'description' => 'Download our professional hub of free assets designed to streamline your editorial workflow and accelerate your site\'s growth.',
            'bullet_points' => [
                'AI Blog Post Checklist (GPT-4 Optimized)',
                'SEO Article Structure Template',
                'Editorial Content Calendar (Notion)',
                'Affiliate Blog Starter Guide',
                'Custom Prompt Pack for Bloggers',
            ],
            'primary_cta_label' => 'Claim Your Free Kit',
            'primary_cta_url' => '#newsletter',
            'stats' => [
                ['value' => '25k+', 'label' => 'Creators'],
                ['value' => '4.9/5', 'label' => 'Rating'],
                ['value' => '20+', 'label' => 'Templates'],
                ['value' => '100%', 'label' => 'Free Access'],
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function defaultNewsletterSection(): array
    {
        return [
            'enabled' => true,
            'title' => 'Stay Ahead of the Curve',
            'description' => 'Join 25,000+ digital architects. Get one technical, high-signal editorial guide every week directly in your inbox.',
            'placeholder' => 'Enter your email',
            'button' => 'Subscribe',
            'note' => 'High-quality insights. No spam. Unsubscribe anytime.',
        ];
    }

    public function subscribe(BlogContentService $content): void
    {
        $this->validateOnly('newsletterEmail');
        $this->resetErrorBag('newsletterEmail');
        $this->newsletterToastVisible = false;

        try {
            $response = $content->subscribeToNewsletter([
                'email' => $this->newsletterEmail,
                'source' => 'homepage',
                'metadata' => [
                    'source:fe',
                    'route:home',
                ],
            ]);
        } catch (Throwable) {
            $this->newsletterToastType = 'error';
            $this->newsletterToastMessage = 'We could not subscribe you right now. Please try again shortly.';
            $this->newsletterToastVisible = true;

            return;
        }

        $message = data_get($response, 'data.message');

        $this->newsletterToastType = 'success';
        $this->newsletterToastMessage = is_string($message) && trim($message) !== ''
            ? trim($message)
            : 'Thank you for subscribing.';
        $this->newsletterToastVisible = true;
        $this->newsletterEmail = '';
    }

    public function render()
    {
        return view('livewire.home-page');
    }
}
