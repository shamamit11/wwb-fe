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
}
