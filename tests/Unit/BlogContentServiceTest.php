<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Contracts\BlogApiClient;
use App\Services\BlogContentService;
use Illuminate\Cache\ArrayStore;
use Illuminate\Cache\Repository;
use Tests\TestCase;

class BlogContentServiceTest extends TestCase
{
    public function test_homepage_payload_is_cached_between_calls(): void
    {
        config(['services.wideweb_blog.cache_ttl' => 900]);
        config(['services.wideweb_blog.homepage_path' => 'public/home']);

        $client = new class implements BlogApiClient
        {
            public int $requests = 0;

            public function get(string $path, array $query = []): array
            {
                $this->requests++;

                return [
                    'hero' => [
                        'title' => 'Cached title',
                    ],
                ];
            }

            public function post(string $path, array $body = []): array
            {
                return ['data' => []];
            }
        };

        $service = new BlogContentService($client, new Repository(new ArrayStore));

        $first = $service->homepage();
        $second = $service->homepage();

        $this->assertSame('Cached title', $first['hero']['title']);
        $this->assertSame($first, $second);
        $this->assertSame(1, $client->requests);
    }

    public function test_site_settings_payload_is_cached_between_calls(): void
    {
        config(['services.wideweb_blog.cache_ttl' => 900]);
        config(['services.wideweb_blog.site_settings_path' => 'public/site-settings']);

        $client = new class implements BlogApiClient
        {
            public int $requests = 0;

            public function get(string $path, array $query = []): array
            {
                $this->requests++;

                return [
                    'data' => [
                        'footer' => [
                            'brand_name' => 'Wide Web Blog',
                        ],
                    ],
                ];
            }

            public function post(string $path, array $body = []): array
            {
                return ['data' => []];
            }
        };

        $service = new BlogContentService($client, new Repository(new ArrayStore));

        $first = $service->siteSettings();
        $second = $service->siteSettings();

        $this->assertSame('Wide Web Blog', $first['data']['footer']['brand_name']);
        $this->assertSame($first, $second);
        $this->assertSame(1, $client->requests);
    }

    public function test_contact_payload_is_cached_between_calls(): void
    {
        config(['services.wideweb_blog.cache_ttl' => 900]);
        config(['services.wideweb_blog.contact_path' => 'public/contact']);

        $client = new class implements BlogApiClient
        {
            public int $requests = 0;

            public function get(string $path, array $query = []): array
            {
                $this->requests++;

                return [
                    'data' => [
                        'hero' => [
                            'title' => 'Cached contact title',
                        ],
                    ],
                ];
            }

            public function post(string $path, array $body = []): array
            {
                return ['data' => []];
            }
        };

        $service = new BlogContentService($client, new Repository(new ArrayStore));

        $first = $service->contact();
        $second = $service->contact();

        $this->assertSame('Cached contact title', $first['data']['hero']['title']);
        $this->assertSame($first, $second);
        $this->assertSame(1, $client->requests);
    }

    public function test_contact_submission_is_forwarded_to_the_public_submit_endpoint(): void
    {
        config(['services.wideweb_blog.contact_submit_path' => 'public/contact/submit']);

        $client = new class implements BlogApiClient
        {
            public string $path = '';

            /** @var array<string, mixed> */
            public array $body = [];

            public function get(string $path, array $query = []): array
            {
                return ['data' => []];
            }

            public function post(string $path, array $body = []): array
            {
                $this->path = $path;
                $this->body = $body;

                return [
                    'data' => [
                        'status' => 'submitted',
                        'message' => 'Forwarded.',
                    ],
                ];
            }
        };

        $service = new BlogContentService($client, new Repository(new ArrayStore));

        $response = $service->submitContact([
            'name' => 'Alex Rivera',
            'email' => 'alex@example.com',
            'topic' => 'Partnership Inquiry',
            'message' => 'We want to discuss a collaboration.',
            'metadata' => ['source:fe'],
        ]);

        $this->assertSame('public/contact/submit', $client->path);
        $this->assertSame('Alex Rivera', $client->body['name']);
        $this->assertSame('submitted', $response['data']['status']);
    }

    public function test_about_payload_is_cached_between_calls(): void
    {
        config(['services.wideweb_blog.cache_ttl' => 900]);
        config(['services.wideweb_blog.about_path' => 'public/about']);

        $client = new class implements BlogApiClient
        {
            public int $requests = 0;

            public function get(string $path, array $query = []): array
            {
                $this->requests++;

                return [
                    'data' => [
                        'hero' => [
                            'title' => 'Cached about title',
                        ],
                    ],
                ];
            }

            public function post(string $path, array $body = []): array
            {
                return ['data' => []];
            }
        };

        $service = new BlogContentService($client, new Repository(new ArrayStore));

        $first = $service->about();
        $second = $service->about();

        $this->assertSame('Cached about title', $first['data']['hero']['title']);
        $this->assertSame($first, $second);
        $this->assertSame(1, $client->requests);
    }

    public function test_public_page_payload_is_cached_by_slug_between_calls(): void
    {
        config(['services.wideweb_blog.cache_ttl' => 900]);
        config(['services.wideweb_blog.pages_path' => 'public/pages']);

        $client = new class implements BlogApiClient
        {
            public int $requests = 0;

            /** @var array<int, string> */
            public array $paths = [];

            public function get(string $path, array $query = []): array
            {
                $this->requests++;
                $this->paths[] = $path;

                return [
                    'data' => [
                        'title' => $path === 'public/pages/privacy-policy'
                            ? 'Privacy Policy'
                            : 'Terms and Conditions',
                    ],
                ];
            }

            public function post(string $path, array $body = []): array
            {
                return ['data' => []];
            }
        };

        $service = new BlogContentService($client, new Repository(new ArrayStore));

        $privacyFirst = $service->page('privacy-policy');
        $privacySecond = $service->page('privacy-policy');
        $terms = $service->page('terms-and-conditions');

        $this->assertSame('Privacy Policy', $privacyFirst['data']['title']);
        $this->assertSame($privacyFirst, $privacySecond);
        $this->assertSame('Terms and Conditions', $terms['data']['title']);
        $this->assertSame(
            ['public/pages/privacy-policy', 'public/pages/terms-and-conditions'],
            $client->paths,
        );
        $this->assertSame(2, $client->requests);
    }

    public function test_post_detail_payload_is_cached_by_slug_between_calls(): void
    {
        config(['services.wideweb_blog.cache_ttl' => 900]);
        config(['services.wideweb_blog.posts_path' => 'public/posts']);

        $client = new class implements BlogApiClient
        {
            public int $requests = 0;

            /** @var array<int, string> */
            public array $paths = [];

            public function get(string $path, array $query = []): array
            {
                $this->requests++;
                $this->paths[] = $path;

                return [
                    'data' => [
                        'slug' => basename($path),
                        'title' => 'Service Post',
                    ],
                ];
            }

            public function post(string $path, array $body = []): array
            {
                return ['data' => []];
            }
        };

        $service = new BlogContentService($client, new Repository(new ArrayStore));

        $first = $service->post('service-post');
        $second = $service->post('service-post');

        $this->assertSame('service-post', $first['slug']);
        $this->assertSame($first, $second);
        $this->assertSame(['public/posts/service-post'], $client->paths);
        $this->assertSame(1, $client->requests);
    }

    public function test_public_search_returns_the_service_items_and_skips_empty_queries(): void
    {
        config(['services.wideweb_blog.cache_ttl' => 900]);
        config(['services.wideweb_blog.search_path' => 'public/search']);

        $client = new class implements BlogApiClient
        {
            public int $requests = 0;

            /** @var array<int, array<string, mixed>> */
            public array $queries = [];

            public function get(string $path, array $query = []): array
            {
                $this->requests++;
                $this->queries[] = $query;

                return [
                    'data' => [
                        ['slug' => 'search-result', 'title' => 'Search Result'],
                    ],
                ];
            }

            public function post(string $path, array $body = []): array
            {
                return ['data' => []];
            }
        };

        $service = new BlogContentService($client, new Repository(new ArrayStore));

        $results = $service->search('design', 12);
        $empty = $service->search('   ', 12);

        $this->assertCount(1, $results);
        $this->assertSame('search-result', $results[0]['slug']);
        $this->assertSame([], $empty);
        $this->assertSame([['q' => 'design', 'per_page' => 12]], $client->queries);
        $this->assertSame(1, $client->requests);
    }

    public function test_it_resolves_selected_homepage_posts_and_categories_by_id(): void
    {
        config(['services.wideweb_blog.cache_ttl' => 900]);
        config(['services.wideweb_blog.categories_path' => 'public/categories']);
        config(['services.wideweb_blog.posts_path' => 'public/posts']);

        $client = new class implements BlogApiClient
        {
            /** @var array<int, array{path: string, query: array<string, mixed>}> */
            public array $requests = [];

            public function get(string $path, array $query = []): array
            {
                $this->requests[] = ['path' => $path, 'query' => $query];

                if ($path === 'public/categories') {
                    return [
                        'data' => [
                            ['id' => 1, 'name' => 'AI Tools', 'slug' => 'ai-tools'],
                            ['id' => 3, 'name' => 'SEO', 'slug' => 'seo'],
                        ],
                    ];
                }

                if ($path === 'public/posts') {
                    return [
                        'data' => [
                            ['id' => 1, 'title' => 'First post', 'slug' => 'first-post'],
                            ['id' => 2, 'title' => 'Second post', 'slug' => 'second-post'],
                        ],
                        'meta' => [
                            'total' => 2,
                            'current_page' => 1,
                            'last_page' => 1,
                            'per_page' => 50,
                        ],
                    ];
                }

                return ['data' => []];
            }

            public function post(string $path, array $body = []): array
            {
                return ['data' => []];
            }
        };

        $service = new BlogContentService($client, new Repository(new ArrayStore));

        $categories = $service->resolveCategoriesByIds([3, 1]);
        $posts = $service->resolvePostsByIds([2, 1]);

        $this->assertSame(['SEO', 'AI Tools'], array_column($categories, 'name'));
        $this->assertSame(['Second post', 'First post'], array_column($posts, 'title'));
        $this->assertCount(2, $client->requests);
        $this->assertSame(['page' => 1, 'per_page' => 50], $client->requests[1]['query']);
    }
}
