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

        config(['services.wideweb_blog.base_url' => 'https://service.widewebblog.com/api/v1']);

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
                                'short_description' => 'Search result excerpt',
                                'featured_image' => '/media/service-design-systems.jpg',
                                'author' => ['name' => 'Marcus Thorne'],
                                'category' => ['name' => 'Developer AI', 'slug' => 'developer-ai'],
                                'reading_time_minutes' => 8,
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
        $response->assertSee('Search result excerpt');
        $response->assertSee('Marcus Thorne • 8 min read');
        $response->assertSee('/articles/service-design-systems', false);
        $response->assertSee('src="https://media.widewebblog.com/media/service-design-systems.jpg"', false);
    }

    public function test_the_search_results_page_shows_an_empty_state_when_nothing_matches(): void
    {
        $response = $this->get('/search?q=nonexistentkeyword');

        $response->assertOk();
        $response->assertSee('No articles found');
        $response->assertSee('View All Articles');
    }
}
