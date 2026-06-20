<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Contracts\BlogApiClient;
use Tests\TestCase;

class ArticleDetailPageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app->instance(BlogApiClient::class, new class implements BlogApiClient
        {
            public function get(string $path, array $query = []): array
            {
                if ($path === 'public/posts/service-design-systems') {
                    return [
                        'data' => [
                            'slug' => 'service-design-systems',
                            'title' => 'Service Design Systems',
                            'excerpt' => 'How design systems evolve with modern AI-enabled workflows.',
                            'published_at' => '2026-06-14T10:00:00.000000Z',
                            'read_time' => '8 min read',
                            'featured_image' => 'https://example.com/service-design-systems.jpg',
                            'featured_media' => [
                                'url' => 'https://example.com/service-design-systems.jpg',
                                'alt_text' => 'Abstract system artwork',
                                'caption' => 'A service-backed article hero image.',
                            ],
                            'author' => ['name' => 'Marcus Thorne'],
                            'category' => ['name' => 'Developer AI', 'slug' => 'developer-ai'],
                            'template' => ['name' => 'Design Systems'],
                            'tags' => [
                                ['name' => 'Design Systems'],
                                ['name' => 'AI Workflows'],
                            ],
                            'content_markdown' => "# The Systematic Shift\n\nService content now drives this article.\n\n## Breaking the Grid\n\nReal markdown body content renders here.",
                            'seo' => [
                                'meta_title' => null,
                                'meta_description' => 'How design systems evolve with modern AI-enabled workflows.',
                                'canonical_url' => 'http://fe.test/articles/service-design-systems',
                                'robots_index' => true,
                                'robots_follow' => true,
                            ],
                            'related_posts' => [
                                [
                                    'slug' => 'seo-recovery-guide',
                                    'title' => 'SEO Recovery Guide',
                                    'featured_image' => 'https://example.com/seo-recovery-guide.jpg',
                                    'read_time' => '5 min read',
                                    'category' => ['name' => 'SEO', 'slug' => 'seo'],
                                ],
                                [
                                    'slug' => 'content-marketing-playbook',
                                    'title' => 'Content Marketing Playbook',
                                    'featured_image' => 'https://example.com/content-marketing-playbook.jpg',
                                    'read_time' => '6 min read',
                                    'category' => ['name' => 'Content Marketing', 'slug' => 'content-marketing'],
                                ],
                            ],
                            'schema' => [
                                '@context' => 'https://schema.org',
                                '@type' => 'Article',
                                'headline' => 'Service Design Systems',
                            ],
                        ],
                    ];
                }

                return ['data' => null];
            }

            public function post(string $path, array $body = []): array
            {
                return ['data' => []];
            }
        });
    }

    public function test_a_known_article_slug_renders_the_detail_page_with_article_specific_seo(): void
    {
        $response = $this->get('/articles/service-design-systems');

        $response->assertOk();
        $response->assertSee('Service Design Systems');
        $response->assertSee('<title>Service Design Systems | Wide Web Blog</title>', false);
        $response->assertSee('<link rel="canonical" href="http://fe.test/articles/service-design-systems">', false);
        $response->assertSee('Related Articles');
        $response->assertSee('The Systematic Shift');
    }

    public function test_an_unknown_article_slug_returns_404(): void
    {
        $this->get('/articles/not-a-real-article')->assertNotFound();
    }

    public function test_related_articles_include_links_back_into_the_article_detail_route(): void
    {
        $response = $this->get('/articles/service-design-systems');

        $response->assertOk();
        $response->assertSee('/articles/seo-recovery-guide', false);
        $response->assertSee('/articles/content-marketing-playbook', false);
    }
}
