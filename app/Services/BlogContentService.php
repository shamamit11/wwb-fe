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
        $path = (string) config('services.wideweb_blog.homepage_path', 'public/home');

        /** @var array<string, mixed> $payload */
        $payload = $this->cache->remember(
            'wideweb-blog.homepage',
            now()->addSeconds($ttl),
            fn (): array => $this->client->get($path),
        );

        return $payload;
    }

    /**
     * @return array<string, mixed>
     */
    public function about(): array
    {
        $ttl = (int) config('services.wideweb_blog.cache_ttl', 900);
        $path = (string) config('services.wideweb_blog.about_path', 'public/about');

        /** @var array<string, mixed> $payload */
        $payload = $this->cache->remember(
            'wideweb-blog.about',
            now()->addSeconds($ttl),
            fn (): array => $this->client->get($path),
        );

        return $payload;
    }

    /**
     * @return array<string, mixed>
     */
    public function contact(): array
    {
        $ttl = (int) config('services.wideweb_blog.cache_ttl', 900);
        $path = (string) config('services.wideweb_blog.contact_path', 'public/contact');

        /** @var array<string, mixed> $payload */
        $payload = $this->cache->remember(
            'wideweb-blog.contact',
            now()->addSeconds($ttl),
            fn (): array => $this->client->get($path),
        );

        return $payload;
    }

    /**
     * @return array<string, mixed>
     */
    public function siteSettings(): array
    {
        $ttl = (int) config('services.wideweb_blog.cache_ttl', 900);
        $path = (string) config('services.wideweb_blog.site_settings_path', 'public/site-settings');

        /** @var array<string, mixed> $payload */
        $payload = $this->cache->remember(
            'wideweb-blog.site-settings',
            now()->addSeconds($ttl),
            fn (): array => $this->client->get($path),
        );

        return $payload;
    }

    /**
     * @return array<string, mixed>
     */
    public function page(string $slug): array
    {
        $ttl = (int) config('services.wideweb_blog.cache_ttl', 900);
        $basePath = trim((string) config('services.wideweb_blog.pages_path', 'public/pages'), '/');
        $path = $basePath.'/'.$slug;

        /** @var array<string, mixed> $payload */
        $payload = $this->cache->remember(
            'wideweb-blog.page.'.$slug,
            now()->addSeconds($ttl),
            fn (): array => $this->client->get($path),
        );

        return $payload;
    }

    /**
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    public function submitContact(array $payload): array
    {
        $path = (string) config('services.wideweb_blog.contact_submit_path', 'public/contact/submit');

        return $this->client->post($path, $payload);
    }

    /**
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    public function subscribeToNewsletter(array $payload): array
    {
        $path = (string) config('services.wideweb_blog.newsletter_subscribe_path', 'public/newsletter/subscribe');

        return $this->client->post($path, $payload);
    }

    /**
     * @return array<int, array{label: string, href: string}>
     */
    public function categories(): array
    {
        $items = $this->detailedCategories();

        return array_values(array_map(
            static fn (array $item): array => [
                'label' => (string) data_get($item, 'name', 'Category'),
                'href' => '/articles/category/'.(string) data_get($item, 'slug', ''),
            ],
            array_filter($items, static fn (mixed $item): bool => is_array($item) && filled(data_get($item, 'slug'))),
        ));
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function detailedCategories(): array
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

        return array_values(array_filter($items, static fn (mixed $item): bool => is_array($item)));
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
     * @return array<string, mixed>|null
     */
    public function post(string $slug): ?array
    {
        $ttl = (int) config('services.wideweb_blog.cache_ttl', 900);
        $path = rtrim((string) config('services.wideweb_blog.posts_path', 'public/posts'), '/').'/'.$slug;

        /** @var array<string, mixed> $payload */
        $payload = $this->cache->remember(
            'wideweb-blog.post.'.$slug,
            now()->addSeconds($ttl),
            fn (): array => $this->client->get($path),
        );

        $item = data_get($payload, 'data');

        return is_array($item) ? $item : null;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function search(string $query, int $perPage = 12, ?string $sort = null): array
    {
        $trimmedQuery = trim($query);

        if ($trimmedQuery === '') {
            return [];
        }

        $ttl = (int) config('services.wideweb_blog.cache_ttl', 900);
        $path = (string) config('services.wideweb_blog.search_path', 'public/search');
        $params = array_filter([
            'q' => $trimmedQuery,
            'sort' => $sort,
            'per_page' => $perPage,
        ], static fn (mixed $value): bool => $value !== null && $value !== '');

        /** @var array<string, mixed> $payload */
        $payload = $this->cache->remember(
            'wideweb-blog.search.'.md5(json_encode($params, JSON_THROW_ON_ERROR)),
            now()->addSeconds($ttl),
            fn (): array => $this->client->get($path, $params),
        );

        /** @var array<int, array<string, mixed>> $items */
        $items = data_get($payload, 'data', []);

        return array_values(array_filter($items, static fn (mixed $item): bool => is_array($item)));
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

    /**
     * @param  array<int, int|string>  $ids
     * @return array<int, array<string, mixed>>
     */
    public function resolveCategoriesByIds(array $ids): array
    {
        $lookup = collect($this->detailedCategories())
            ->filter(fn (array $item): bool => filled(data_get($item, 'id')))
            ->keyBy(fn (array $item): string => (string) data_get($item, 'id'));

        return array_values(array_filter(array_map(
            static fn (int|string $id): ?array => $lookup->get((string) $id),
            $ids,
        )));
    }

    /**
     * @param  array<int, int|string>  $ids
     * @return array<int, array<string, mixed>>
     */
    public function resolvePostsByIds(array $ids): array
    {
        $targetIds = array_values(array_unique(array_map(static fn (int|string $id): string => (string) $id, $ids)));

        if ($targetIds === []) {
            return [];
        }

        $found = [];
        $page = 1;
        $perPage = 50;

        do {
            $payload = $this->posts(page: $page, perPage: $perPage);

            foreach ($payload['items'] as $item) {
                $id = (string) data_get($item, 'id', '');

                if ($id === '' || ! in_array($id, $targetIds, true) || array_key_exists($id, $found)) {
                    continue;
                }

                $found[$id] = $item;
            }

            if (count($found) === count($targetIds)) {
                break;
            }

            $page++;
        } while ($payload['has_more']);

        return array_values(array_filter(array_map(
            static fn (string $id): ?array => $found[$id] ?? null,
            $targetIds,
        )));
    }

    /**
     * @param  array<int, int|string>  $categoryIds
     * @return array<int, array<string, mixed>>
     */
    public function resolvePostsForCategoryIds(array $categoryIds, int $limit = 4): array
    {
        $categories = $this->resolveCategoriesByIds($categoryIds);
        $items = [];

        foreach ($categories as $category) {
            $slug = (string) data_get($category, 'slug', '');

            if ($slug === '') {
                continue;
            }

            $payload = $this->posts($slug, 1, max(1, min(50, $limit)));

            foreach ($payload['items'] as $item) {
                $id = (string) data_get($item, 'id', '');

                if ($id === '' || array_key_exists($id, $items)) {
                    continue;
                }

                $items[$id] = $item;

                if (count($items) >= $limit) {
                    break 2;
                }
            }
        }

        return array_values($items);
    }
}
