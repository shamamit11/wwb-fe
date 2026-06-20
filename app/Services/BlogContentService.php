<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\BlogApiClient;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

class BlogContentService
{
    public function __construct(
        private readonly BlogApiClient $client,
        private readonly CacheRepository $cache,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function homepage(): array
    {
        $ttl = (int) config('services.wideweb_blog.cache_ttl', 900);
        $path = (string) config('services.wideweb_blog.homepage_path', 'homepage');

        /** @var array<string, mixed> $payload */
        $payload = $this->cache->remember(
            'wideweb-blog.homepage',
            now()->addSeconds($ttl),
            fn (): array => $this->client->get($path),
        );

        return $payload;
    }
}
