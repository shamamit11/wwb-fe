<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Contracts\BlogApiClient;
use Tests\TestCase;

class RssFeedTest extends TestCase
{
    public function test_the_rss_feed_route_returns_rss_xml_with_channel_metadata_and_items(): void
    {
        config(['services.wideweb_blog.base_url' => 'https://service.widewebblog.com/api/v1']);
        config(['app.url' => 'https://www.widewebblog.com']);

        $this->app->instance(BlogApiClient::class, new class implements BlogApiClient
        {
            public function get(string $path, array $query = []): array
            {
                return [
                    'data' => [
                        [
                            'type' => 'post',
                            'id' => 'post-1',
                            'slug' => 'ai-content-systems',
                            'title' => 'AI Content Systems',
                            'description' => 'A feed item description.',
                            'link' => 'https://service.widewebblog.com/best-ai-tools-seo-keyword-research-content-optimization-rank-tracking/',
                            'published_at' => '2026-06-20T10:00:00+00:00',
                            'last_modified_at' => '2026-06-20T12:00:00+00:00',
                            'author' => [
                                'id' => 'author-1',
                                'name' => 'Marcus Thorne',
                            ],
                            'category' => [
                                'id' => 'cat-1',
                                'name' => 'AI Tools',
                                'slug' => 'ai-tools',
                            ],
                        ],
                    ],
                ];
            }

            public function post(string $path, array $body = []): array
            {
                return ['data' => []];
            }
        });

        $response = $this->get('/rss.xml');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/rss+xml; charset=UTF-8');
        $response->assertSee('<?xml version="1.0" encoding="UTF-8"?>', false);
        $response->assertSee('<channel>', false);
        $response->assertSee('<title>Wide Web Blog</title>', false);
        $response->assertSee('<atom:link href="http://fe.test/rss.xml" rel="self" type="application/rss+xml" />', false);
        $response->assertSee('<item>', false);
        $response->assertSee('<title>AI Content Systems</title>', false);
        $response->assertSee('<link>https://www.widewebblog.com/articles/best-ai-tools-seo-keyword-research-content-optimization-rank-tracking/</link>', false);
        $response->assertSee('<guid isPermaLink="true">https://www.widewebblog.com/articles/best-ai-tools-seo-keyword-research-content-optimization-rank-tracking/</guid>', false);
        $response->assertDontSee('https://service.widewebblog.com/best-ai-tools-seo-keyword-research-content-optimization-rank-tracking/', false);
        $response->assertSee('<category>AI Tools</category>', false);
    }

    public function test_the_rss_feed_route_maps_legacy_service_article_paths_to_frontend_article_paths(): void
    {
        config(['services.wideweb_blog.base_url' => 'https://service.widewebblog.com/api/v1']);
        config(['app.url' => 'https://www.widewebblog.com']);

        $this->app->instance(BlogApiClient::class, new class implements BlogApiClient
        {
            public function get(string $path, array $query = []): array
            {
                return [
                    'data' => [
                        [
                            'type' => 'post',
                            'id' => 'post-1',
                            'slug' => 'faceted-navigation-seo-large-ecommerce',
                            'title' => 'Faceted Navigation SEO',
                            'description' => 'A feed item description.',
                            'link' => 'https://service.widewebblog.com/faceted-navigation-seo-large-ecommerce/',
                            'published_at' => '2026-06-20T10:00:00+00:00',
                            'last_modified_at' => '2026-06-20T12:00:00+00:00',
                            'author' => [
                                'id' => 'author-1',
                                'name' => 'Marcus Thorne',
                            ],
                            'category' => [
                                'id' => 'cat-1',
                                'name' => 'SEO',
                                'slug' => 'seo',
                            ],
                        ],
                    ],
                ];
            }

            public function post(string $path, array $body = []): array
            {
                return ['data' => []];
            }
        });

        $response = $this->get('/rss.xml');

        $response->assertOk();
        $response->assertSee('<link>https://www.widewebblog.com/articles/faceted-navigation-seo-large-ecommerce/</link>', false);
        $response->assertSee('<guid isPermaLink="true">https://www.widewebblog.com/articles/faceted-navigation-seo-large-ecommerce/</guid>', false);
        $response->assertDontSee('<link>https://www.widewebblog.com/faceted-navigation-seo-large-ecommerce/</link>', false);
    }

    public function test_the_footer_rss_link_points_to_the_frontend_feed_route(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('href="http://fe.test/rss.xml"', false);
    }
}
