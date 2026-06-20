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
        config(['services.wideweb_blog.homepage_path' => 'homepage']);

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
        };

        $service = new BlogContentService($client, new Repository(new ArrayStore));

        $first = $service->homepage();
        $second = $service->homepage();

        $this->assertSame('Cached title', $first['hero']['title']);
        $this->assertSame($first, $second);
        $this->assertSame(1, $client->requests);
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
        };

        $service = new BlogContentService($client, new Repository(new ArrayStore));

        $first = $service->about();
        $second = $service->about();

        $this->assertSame('Cached about title', $first['data']['hero']['title']);
        $this->assertSame($first, $second);
        $this->assertSame(1, $client->requests);
    }
}
