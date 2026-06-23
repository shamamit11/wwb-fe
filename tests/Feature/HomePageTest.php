<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Livewire\HomePage;
use App\Contracts\BlogApiClient;
use Livewire\Livewire;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_the_home_page_renders_the_articles_archive_by_default(): void
    {
        config(['services.wideweb_blog.homepage_path' => 'public/home']);

        $this->app->instance(BlogApiClient::class, new class implements BlogApiClient
        {
            public function get(string $path, array $query = []): array
            {
                return ['data' => []];
            }

            public function post(string $path, array $body = []): array
            {
                return ['data' => []];
            }
        });

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('All Articles');
        $response->assertSee('Subscribe');
        $response->assertDontSee('href="/resources"', false);
        $response->assertDontSee('Contact Us');
        $response->assertDontSee('href="/about"', false);
        $response->assertDontSee('href="/articles"', false);
        $response->assertSee('id="newsletter"', false);
    }

    public function test_the_home_page_uses_homepage_api_hero_newsletter_and_seo_copy(): void
    {
        config(['services.wideweb_blog.homepage_path' => 'public/home']);
        config(['services.wideweb_blog.base_url' => 'https://service.widewebblog.com/api/v1']);

        $this->app->instance(BlogApiClient::class, new class implements BlogApiClient
        {
            public function get(string $path, array $query = []): array
            {
                return match ($path) {
                    'public/home' => [
                        'data' => [
                            'hero' => [
                                'eyebrow' => 'Wide Web Blog',
                                'title' => 'Practical AI publishing systems for real editorial teams',
                                'description' => 'Guides, workflows, and implementation notes for AI-assisted blogging, SEO, and automation.',
                                'primary_cta_label' => 'Read the latest guide',
                                'primary_cta_url' => 'http://wwb-fe.test/articles/convergence-of-generative-ai-and-design-systems',
                                'secondary_cta_label' => 'Browse AI Articles',
                                'secondary_cta_url' => 'http://wwb-fe.test/articles/category/ai-tools',
                                'media_url' => 'https://media.widewebblog.com/hero.webp',
                                'media_alt' => null,
                            ],
                            'featured_editorial' => [
                                'mode' => 'automatic',
                                'limit' => 2,
                                'title' => 'Featured Editorial',
                                'post_ids' => [1],
                                'description' => 'Recent deep dives and systems notes.',
                                'category_ids' => null,
                                'posts' => [
                                    [
                                        'id' => 1,
                                        'title' => 'How AI Agent Memory Works',
                                        'slug' => 'how-ai-agent-memory-works',
                                        'excerpt' => 'A practical look at short-term and long-term memory patterns in AI agents.',
                                        'published_at' => '2026-06-17T21:58:02.000000Z',
                                        'featured_media' => [
                                            'url' => '/seed/media/ai-agent-memory-cover.webp',
                                            'alt_text' => 'Abstract illustration for AI agent memory systems',
                                        ],
                                        'category' => ['id' => 1, 'name' => 'AI Tools', 'slug' => 'ai-tools'],
                                    ],
                                ],
                            ],
                            'guide_section' => [
                                'mode' => 'automatic',
                                'limit' => 2,
                                'title' => 'Recent Articles',
                                'post_ids' => [1],
                                'description' => 'Concrete workflows and architecture references.',
                                'category_ids' => null,
                                'posts' => [
                                    [
                                        'id' => 1,
                                        'title' => 'How AI Agent Memory Works',
                                        'slug' => 'how-ai-agent-memory-works',
                                        'excerpt' => 'A practical look at short-term and long-term memory patterns in AI agents.',
                                        'published_at' => '2026-06-17T21:58:02.000000Z',
                                        'featured_media' => [
                                            'url' => '/seed/media/ai-agent-memory-cover.webp',
                                            'alt_text' => 'Abstract illustration for AI agent memory systems',
                                        ],
                                        'category' => ['id' => 1, 'name' => 'AI Tools', 'slug' => 'ai-tools'],
                                    ],
                                ],
                            ],
                            'topic_section' => [
                                'title' => 'Explore Core Topics',
                                'description' => 'Browse the main editorial clusters.',
                                'category_ids' => [1, 2, 3, 4, 5, 6, 7],
                                'categories' => [
                                    ['id' => 1, 'name' => 'AI Tools', 'slug' => 'ai-tools'],
                                    ['id' => 2, 'name' => 'AI Agents', 'slug' => 'ai-agents'],
                                    ['id' => 3, 'name' => 'SEO', 'slug' => 'seo'],
                                    ['id' => 4, 'name' => 'Content Marketing', 'slug' => 'content-marketing'],
                                    ['id' => 5, 'name' => 'Productivity & Automation', 'slug' => 'productivity-automation'],
                                    ['id' => 6, 'name' => 'Developer AI', 'slug' => 'developer-ai'],
                                    ['id' => 7, 'name' => 'News & Trends', 'slug' => 'news-trends'],
                                ],
                            ],
                            'promo_section' => [
                                'enabled' => true,
                                'eyebrow' => 'Editorial Systems',
                                'title' => 'Build better AI-assisted publishing workflows',
                                'description' => 'Use grounded briefs, draft-only review, and clear approval states.',
                                'bullet_points' => ['Knowledge-grounded prompts', 'Draft-first workflows', 'Review-only refinement tools'],
                                'primary_cta_label' => 'See editorial workflow',
                                'primary_cta_url' => 'http://wwb-fe.test/articles/convergence-of-generative-ai-and-design-systems',
                                'stats' => [
                                    ['label' => 'Core AI workflows', 'value' => '6'],
                                    ['label' => 'Publishing guardrails', 'value' => 'Draft-first'],
                                ],
                            ],
                            'newsletter_section' => [
                                'enabled' => true,
                                'title' => 'Get workflow notes in your inbox',
                                'description' => 'Subscribe for new AI publishing guides and editorial systems updates.',
                            ],
                            'seo' => [
                                'meta_title' => 'Wide Web Blog',
                                'meta_description' => 'Practical guides about AI publishing systems, SEO workflows, and content operations.',
                            ],
                        ],
                    ],
                    'public/posts' => [
                        'data' => [
                            [
                                'id' => 1,
                                'title' => 'How AI Agent Memory Works',
                                'slug' => 'how-ai-agent-memory-works',
                                'excerpt' => 'A practical look at short-term and long-term memory patterns in AI agents.',
                                'published_at' => '2026-06-17T21:58:02.000000Z',
                                'featured_media' => [
                                    'url' => '/seed/media/lead.webp',
                                    'alt_text' => 'Lead post image',
                                ],
                                'category' => ['id' => 1, 'name' => 'AI Tools', 'slug' => 'ai-tools'],
                            ],
                            [
                                'id' => 2,
                                'title' => 'Convergence of Generative AI and Design Systems',
                                'slug' => 'convergence-of-generative-ai-and-design-systems',
                                'excerpt' => 'How design systems and AI workflows reinforce each other.',
                                'published_at' => '2026-06-18T21:58:02.000000Z',
                                'featured_media' => [
                                    'url' => '/seed/media/secondary.webp',
                                    'alt_text' => 'Secondary post image',
                                ],
                                'category' => ['id' => 6, 'name' => 'Developer AI', 'slug' => 'developer-ai'],
                            ],
                        ],
                        'meta' => [
                            'total' => 2,
                            'current_page' => 1,
                            'last_page' => 1,
                            'per_page' => 50,
                        ],
                    ],
                    'public/categories' => [
                        'data' => [
                            ['id' => 1, 'name' => 'AI Tools', 'slug' => 'ai-tools'],
                            ['id' => 3, 'name' => 'SEO', 'slug' => 'seo'],
                            ['id' => 6, 'name' => 'Developer AI', 'slug' => 'developer-ai'],
                        ],
                    ],
                    default => ['data' => []],
                };
            }

            public function post(string $path, array $body = []): array
            {
                return ['data' => []];
            }
        });

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Practical AI publishing systems for real editorial teams');
        $response->assertSee('Guides, workflows, and implementation notes for AI-assisted blogging, SEO, and automation.');
        $response->assertSee('Get workflow notes in your inbox');
        $response->assertSee('How AI Agent Memory Works');
        $response->assertSee('Convergence of Generative AI and Design Systems');
        $response->assertSee('src="https://media.widewebblog.com/seed/media/lead.webp"', false);
        $response->assertSee('href="http://fe.test/articles/how-ai-agent-memory-works"', false);
        $response->assertSee('<meta property="og:title" content="Wide Web Blog">', false);
        $response->assertSee('<meta name="description" content="Practical guides about AI publishing systems, SEO workflows, and content operations.">', false);
        $response->assertSee('<link rel="canonical" href="http://fe.test">', false);
    }

    public function test_the_home_page_uses_current_public_home_endpoint_shape_for_archive_copy(): void
    {
        config(['services.wideweb_blog.homepage_path' => 'public/home']);
        config(['services.wideweb_blog.base_url' => 'https://service.widewebblog.com/api/v1']);

        $this->app->instance(BlogApiClient::class, new class implements BlogApiClient
        {
            public function get(string $path, array $query = []): array
            {
                return match ($path) {
                    'public/home' => [
                        'data' => [
                            'hero' => [
                                'title' => 'Practical AI publishing systems for real editorial teams',
                                'eyebrow' => 'Wide Web Blog',
                                'media_alt' => null,
                                'media_url' => 'https://media.widewebblog.com/current-home-hero.webp',
                                'description' => 'Guides, workflows, and implementation notes for AI-assisted blogging, SEO, and automation.',
                                'primary_cta_url' => 'http://wwb-fe.test/articles/convergence-of-generative-ai-and-design-systems',
                                'primary_cta_label' => 'Read the latest guide',
                                'secondary_cta_url' => 'http://wwb-fe.test/articles/category/ai-tools',
                                'secondary_cta_label' => 'Browse AI Articles',
                            ],
                            'featured_editorial' => [
                                'mode' => 'automatic',
                                'limit' => 1,
                                'title' => 'Featured Editorial',
                                'post_ids' => [1],
                                'description' => 'Recent deep dives and systems notes.',
                                'category_ids' => null,
                                'posts' => [[
                                    'id' => 1,
                                    'title' => 'How AI Agent Memory Works',
                                    'slug' => 'how-ai-agent-memory-works',
                                    'excerpt' => 'A practical look at short-term and long-term memory patterns in AI agents.',
                                    'canonical_url' => 'https://widewebblog.test/posts/how-ai-agent-memory-works',
                                    'published_at' => '2026-06-17T21:58:02.000000Z',
                                    'updated_at' => '2026-06-18T21:58:02.000000Z',
                                    'reading_time_minutes' => 8,
                                    'read_time' => '8 min read',
                                    'featured_image' => '/seed/media/ai-agent-memory-cover.webp',
                                    'featured_media' => [
                                        'id' => 1,
                                        'ulid' => '01kvebv0r6x54rfz56wa5wc9nz',
                                        'mime_type' => 'image/webp',
                                        'width' => 1600,
                                        'height' => 900,
                                        'alt_text' => 'Abstract illustration for AI agent memory systems',
                                        'caption' => 'Seeded editorial cover image.',
                                        'url' => '/seed/media/ai-agent-memory-cover.webp',
                                    ],
                                    'author' => [
                                        'id' => 1,
                                        'name' => 'Admin User',
                                    ],
                                    'category' => [
                                        'id' => 1,
                                        'name' => 'AI Tools',
                                        'slug' => 'ai-tools',
                                    ],
                                ]],
                            ],
                            'guide_section' => [
                                'mode' => 'automatic',
                                'limit' => 1,
                                'title' => 'Recent Articles',
                                'post_ids' => [1],
                                'description' => 'Concrete workflows and architecture references.',
                                'category_ids' => null,
                                'posts' => [[
                                    'id' => 1,
                                    'title' => 'How AI Agent Memory Works',
                                    'slug' => 'how-ai-agent-memory-works',
                                    'excerpt' => 'A practical look at short-term and long-term memory patterns in AI agents.',
                                    'canonical_url' => 'https://widewebblog.test/posts/how-ai-agent-memory-works',
                                    'published_at' => '2026-06-17T21:58:02.000000Z',
                                    'updated_at' => '2026-06-18T21:58:02.000000Z',
                                    'reading_time_minutes' => 8,
                                    'read_time' => '8 min read',
                                    'featured_image' => '/seed/media/ai-agent-memory-cover.webp',
                                    'featured_media' => [
                                        'id' => 1,
                                        'ulid' => '01kvebv0r6x54rfz56wa5wc9nz',
                                        'mime_type' => 'image/webp',
                                        'width' => 1600,
                                        'height' => 900,
                                        'alt_text' => 'Abstract illustration for AI agent memory systems',
                                        'caption' => 'Seeded editorial cover image.',
                                        'url' => '/seed/media/ai-agent-memory-cover.webp',
                                    ],
                                    'author' => [
                                        'id' => 1,
                                        'name' => 'Admin User',
                                    ],
                                    'category' => [
                                        'id' => 1,
                                        'name' => 'AI Tools',
                                        'slug' => 'ai-tools',
                                    ],
                                ]],
                            ],
                            'topic_section' => [
                                'title' => 'Explore Core Topics',
                                'description' => 'Browse the main editorial clusters.',
                                'category_ids' => [1, 2, 3, 4, 5, 6, 7],
                                'categories' => [
                                    ['id' => 1, 'name' => 'AI Tools', 'slug' => 'ai-tools', 'description' => null, 'post_count' => 1, 'seo' => null],
                                    ['id' => 2, 'name' => 'AI Agents', 'slug' => 'ai-agents', 'description' => null, 'post_count' => 0, 'seo' => null],
                                    ['id' => 3, 'name' => 'SEO', 'slug' => 'seo', 'description' => null, 'post_count' => 0, 'seo' => null],
                                    ['id' => 4, 'name' => 'Content Marketing', 'slug' => 'content-marketing', 'description' => null, 'post_count' => 0, 'seo' => null],
                                    ['id' => 5, 'name' => 'Productivity & Automation', 'slug' => 'productivity-automation', 'description' => null, 'post_count' => 0, 'seo' => null],
                                    ['id' => 6, 'name' => 'Developer AI', 'slug' => 'developer-ai', 'description' => null, 'post_count' => 0, 'seo' => null],
                                    ['id' => 7, 'name' => 'News & Trends', 'slug' => 'news-trends', 'description' => null, 'post_count' => 0, 'seo' => null],
                                ],
                            ],
                            'promo_section' => [
                                'stats' => [
                                    ['label' => 'Core AI workflows', 'value' => '6'],
                                    ['label' => 'Publishing guardrails', 'value' => 'Draft-first'],
                                ],
                                'title' => 'Build better AI-assisted publishing workflows',
                                'enabled' => true,
                                'eyebrow' => 'Editorial Systems',
                                'description' => 'Use grounded briefs, draft-only review, and clear approval states.',
                                'bullet_points' => [
                                    'Knowledge-grounded prompts',
                                    'Draft-first workflows',
                                    'Review-only refinement tools',
                                ],
                                'primary_cta_url' => 'http://wwb-fe.test/articles/convergence-of-generative-ai-and-design-systems',
                                'primary_cta_label' => 'See editorial workflow',
                            ],
                            'newsletter_section' => [
                                'title' => 'Get workflow notes in your inbox',
                                'enabled' => true,
                                'description' => 'Subscribe for new AI publishing guides and editorial systems updates.',
                            ],
                            'seo' => [
                                'meta_title' => 'Wide Web Blog',
                                'meta_description' => 'Practical guides about AI publishing systems, SEO workflows, and content operations.',
                            ],
                        ],
                    ],
                    default => ['data' => []],
                };
            }

            public function post(string $path, array $body = []): array
            {
                return ['data' => []];
            }
        });

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Practical AI publishing systems for real editorial teams');
        $response->assertSee('Guides, workflows, and implementation notes for AI-assisted blogging, SEO, and automation.');
        $response->assertSee('Get workflow notes in your inbox');
        $response->assertSee('text-5xl', false);
        $response->assertSee('Showing 0 of 0 articles');
        $response->assertSee('<meta property="og:title" content="Wide Web Blog">', false);
        $response->assertSee('<meta name="description" content="Practical guides about AI publishing systems, SEO workflows, and content operations.">', false);
    }

    public function test_the_home_page_outputs_reusable_seo_metadata_without_cdn_tailwind(): void
    {
        config(['services.wideweb_blog.homepage_path' => 'public/home']);

        $this->app->instance(BlogApiClient::class, new class implements BlogApiClient
        {
            public function get(string $path, array $query = []): array
            {
                return ['data' => []];
            }

            public function post(string $path, array $body = []): array
            {
                return ['data' => []];
            }
        });

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('<meta name="description" content="Browse the full editorial archive of AI, blogging, SEO, case studies, and web development insights from Wide Web Blog.">', false);
        $response->assertSee('<link rel="canonical" href="http://fe.test">', false);
        $response->assertSee('<meta property="og:title" content="All Articles | Wide Web Blog">', false);
        $response->assertDontSee('cdn.tailwindcss.com');
    }

    public function test_the_home_page_outputs_google_site_verification_when_configured(): void
    {
        config(['services.wideweb_blog.homepage_path' => 'public/home']);
        config(['site.google_site_verification' => 'google-verification-token-123']);

        $this->app->instance(BlogApiClient::class, new class implements BlogApiClient
        {
            public function get(string $path, array $query = []): array
            {
                return ['data' => []];
            }

            public function post(string $path, array $body = []): array
            {
                return ['data' => []];
            }
        });

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('<meta name="google-site-verification" content="google-verification-token-123">', false);
    }

    public function test_the_home_page_newsletter_form_subscribes_successfully(): void
    {
        $this->app->instance(BlogApiClient::class, new class implements BlogApiClient
        {
            public function get(string $path, array $query = []): array
            {
                return ['data' => []];
            }

            public function post(string $path, array $body = []): array
            {
                return [
                    'data' => [
                        'status' => 'subscribed',
                        'message' => 'Thank you for subscribing.',
                    ],
                ];
            }
        });

        Livewire::test(HomePage::class)
            ->set('newsletterEmail', 'reader@example.com')
            ->call('subscribe')
            ->assertSet('newsletterToastVisible', true)
            ->assertSet('newsletterToastType', 'success')
            ->assertSet('newsletterToastMessage', 'Thank you for subscribing.')
            ->assertSet('newsletterEmail', '');
    }

    public function test_the_home_page_newsletter_form_validates_email(): void
    {
        $this->app->instance(BlogApiClient::class, new class implements BlogApiClient
        {
            public function get(string $path, array $query = []): array
            {
                return ['data' => []];
            }

            public function post(string $path, array $body = []): array
            {
                return ['data' => []];
            }
        });

        Livewire::test(HomePage::class)
            ->set('newsletterEmail', 'not-an-email')
            ->call('subscribe')
            ->assertHasErrors(['newsletterEmail' => 'email']);
    }

    public function test_the_footer_uses_public_site_settings_for_brand_description_social_and_legal_links(): void
    {
        config(['services.wideweb_blog.homepage_path' => 'public/home']);

        $this->app->instance(BlogApiClient::class, new class implements BlogApiClient
        {
            public function get(string $path, array $query = []): array
            {
                return match ($path) {
                    'public/home' => ['data' => []],
                    'public/site-settings' => [
                        'data' => [
                            'footer' => [
                                'brand_name' => 'Wide Web Blog Settings',
                                'description' => 'Footer description from site settings.',
                                'social_links' => [
                                    ['label' => 'Share', 'url' => 'https://widewebblog.test/share', 'icon' => 'share'],
                                    ['label' => 'Email', 'url' => 'mailto:hello@widewebblog.test', 'icon' => 'email'],
                                ],
                                'legal_links' => [
                                    ['label' => 'Privacy Policy', 'slug' => 'privacy-policy', 'url' => null],
                                    ['label' => 'Terms', 'slug' => null, 'url' => 'https://widewebblog.test/terms'],
                                ],
                            ],
                        ],
                    ],
                    'public/categories' => [
                        'data' => [
                            ['id' => 1, 'name' => 'AI Tools', 'slug' => 'ai-tools'],
                        ],
                    ],
                    default => ['data' => []],
                };
            }

            public function post(string $path, array $body = []): array
            {
                return ['data' => []];
            }
        });

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Wide Web Blog Settings');
        $response->assertSee('Footer description from site settings.');
        $response->assertSee('href="https://widewebblog.test/share"', false);
        $response->assertSee('href="mailto:hello@widewebblog.test"', false);
        $response->assertSee('href="http://fe.test/privacy-policy"', false);
        $response->assertSee('href="https://widewebblog.test/terms"', false);
        $response->assertSee('AI Tools');
    }
}
