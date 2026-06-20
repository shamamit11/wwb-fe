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

    /**
     * @return array<int, array{label: string, href: string}>
     */
    public function categories(): array
    {
        $ttl = (int) config('services.wideweb_blog.cache_ttl', 900);
        $path = (string) config('services.wideweb_blog.categories_path', 'public/categories');

        /** @var array<string, mixed> $payload */
        $payload = $this->cache->remember(
            'wideweb-blog.categories',
            now()->addSeconds($ttl),
            fn (): array => $this->client->get($path),
        );

        /** @var array<int, array<string, mixed>> $items */
        $items = data_get($payload, 'data', []);

        return array_values(array_map(
            static fn (array $item): array => [
                'label' => (string) data_get($item, 'name', 'Category'),
                'href' => '/articles/category/'.(string) data_get($item, 'slug', ''),
            ],
            array_filter($items, static fn (mixed $item): bool => is_array($item) && filled(data_get($item, 'slug'))),
        ));
    }

    /**
     * @return array<int, array{slug: string, label: string}>
     */
    public function articleFilters(): array
    {
        $ttl = (int) config('services.wideweb_blog.cache_ttl', 900);
        $path = (string) config('services.wideweb_blog.categories_path', 'public/categories');

        /** @var array<string, mixed> $payload */
        $payload = $this->cache->remember(
            'wideweb-blog.article-filters',
            now()->addSeconds($ttl),
            fn (): array => $this->client->get($path),
        );

        /** @var array<int, array<string, mixed>> $items */
        $items = data_get($payload, 'data', []);

        $filters = array_values(array_map(
            static fn (array $item): array => [
                'slug' => (string) data_get($item, 'slug', ''),
                'label' => (string) data_get($item, 'name', 'Category'),
            ],
            array_filter($items, static fn (mixed $item): bool => is_array($item) && filled(data_get($item, 'slug'))),
        ));

        array_unshift($filters, ['slug' => 'all', 'label' => 'All Content']);

        return $filters;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function category(string $slug): ?array
    {
        $ttl = (int) config('services.wideweb_blog.cache_ttl', 900);
        $path = rtrim((string) config('services.wideweb_blog.categories_path', 'public/categories'), '/').'/'.$slug;

        /** @var array<string, mixed> $payload */
        $payload = $this->cache->remember(
            'wideweb-blog.category.'.$slug,
            now()->addSeconds($ttl),
            fn (): array => $this->client->get($path),
        );

        $item = data_get($payload, 'data');

        return is_array($item) ? $item : null;
    }

    /**
     * @return array{items: array<int, array<string, mixed>>, total: int, page: int, per_page: int, has_more: bool}
     */
    public function posts(?string $category = null, int $page = 1, int $perPage = 7): array
    {
        $ttl = (int) config('services.wideweb_blog.cache_ttl', 900);
        $path = (string) config('services.wideweb_blog.posts_path', 'public/posts');
        $query = array_filter([
            'category' => $category,
            'page' => $page,
            'per_page' => $perPage,
        ], static fn (mixed $value): bool => $value !== null && $value !== '');

        /** @var array<string, mixed> $payload */
        $payload = $this->cache->remember(
            'wideweb-blog.posts.'.md5(json_encode($query, JSON_THROW_ON_ERROR)),
            now()->addSeconds($ttl),
            fn (): array => $this->client->get($path, $query),
        );

        /** @var array<int, array<string, mixed>> $items */
        $items = data_get($payload, 'data', []);
        $meta = data_get($payload, 'meta', []);

        return [
            'items' => $items,
            'total' => (int) data_get($meta, 'total', count($items)),
            'page' => (int) data_get($meta, 'current_page', $page),
            'per_page' => (int) data_get($meta, 'per_page', $perPage),
            'has_more' => (int) data_get($meta, 'current_page', $page) < (int) data_get($meta, 'last_page', $page),
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function rssFeed(): array
    {
        $ttl = (int) config('services.wideweb_blog.cache_ttl', 900);
        $path = (string) config('services.wideweb_blog.rss_path', 'public/rss');

        /** @var array<string, mixed> $payload */
        $payload = $this->cache->remember(
            'wideweb-blog.rss',
            now()->addSeconds($ttl),
            fn (): array => $this->client->get($path),
        );

        /** @var array<int, array<string, mixed>> $items */
        $items = data_get($payload, 'data', []);

        return array_values(array_filter($items, static fn (mixed $item): bool => is_array($item)));
    }
}
