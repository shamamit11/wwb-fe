<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Contracts\BlogApiClient;
use Tests\TestCase;

class SearchPageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app->instance(BlogApiClient::class, new class implements BlogApiClient
        {
            public function get(string $path, array $query = []): array
            {
                if ($path === 'public/search' && ($query['q'] ?? null) === 'design') {
                    return [
                        'data' => [
                            [
                                'slug' => 'service-design-systems',
                                'title' => 'Service Design Systems',
                                'excerpt' => 'Search result excerpt',
                                'featured_image' => 'https://example.com/service-design-systems.jpg',
                                'author' => ['name' => 'Marcus Thorne'],
                                'category' => ['name' => 'Developer AI', 'slug' => 'developer-ai'],
                                'read_time' => '8 min read',
                            ],
                        ],
                    ];
                }

                if ($path === 'public/search') {
                    return ['data' => []];
                }

                return ['data' => []];
            }

            public function post(string $path, array $body = []): array
            {
                return ['data' => []];
            }
        });
    }

    public function test_the_header_renders_a_clickable_search_trigger_and_search_route(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('data-search-open', false);
        $response->assertSee('action="http://fe.test/search"', false);
    }

    public function test_the_search_results_page_displays_matching_articles_with_detail_links(): void
    {
        $response = $this->get('/search?q=design');

        $response->assertOk();
        $response->assertSee('Results for “design”', false);
        $response->assertSee('Service Design Systems');
        $response->assertSee('/articles/service-design-systems', false);
    }

    public function test_the_search_results_page_shows_an_empty_state_when_nothing_matches(): void
    {
        $response = $this->get('/search?q=nonexistentkeyword');

        $response->assertOk();
        $response->assertSee('No articles found');
        $response->assertSee('View All Articles');
    }
}
