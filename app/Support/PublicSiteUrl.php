<?php

declare(strict_types=1);

namespace App\Support;

final class PublicSiteUrl
{
    public static function normalize(?string $url): string
    {
        $resolved = self::extractUrl(is_string($url) ? trim($url) : '');

        if ($resolved === '') {
            return '';
        }

        $host = parse_url($resolved, PHP_URL_HOST);
        $serviceHost = parse_url((string) config('services.wideweb_blog.base_url', ''), PHP_URL_HOST);
        $publicHost = parse_url((string) config('app.url', ''), PHP_URL_HOST);
        $publicOrigin = self::publicOrigin();

        if (! is_string($host) || $host === '' || $publicOrigin === '') {
            return $resolved;
        }

        $matchesServiceHost = is_string($serviceHost) && $serviceHost !== '' && $host === $serviceHost;
        $matchesPublicHost = is_string($publicHost) && $publicHost !== '' && $host === $publicHost;

        if (! $matchesServiceHost && ! $matchesPublicHost) {
            return $resolved;
        }

        $path = parse_url($resolved, PHP_URL_PATH) ?: '';
        $query = parse_url($resolved, PHP_URL_QUERY);
        $fragment = parse_url($resolved, PHP_URL_FRAGMENT);

        $normalized = rtrim($publicOrigin, '/').self::normalizePath($path);

        if (is_string($query) && $query !== '') {
            $normalized .= '?'.$query;
        }

        if (is_string($fragment) && $fragment !== '') {
            $normalized .= '#'.$fragment;
        }

        return $normalized;
    }

    public static function articleUrl(string $slug): string
    {
        $trimmed = trim($slug);

        if ($trimmed === '') {
            return '';
        }

        $origin = self::publicOrigin();

        return $origin !== ''
            ? rtrim($origin, '/').'/articles/'.$trimmed.'/'
            : '/articles/'.$trimmed.'/';
    }

    public static function categoryUrl(string $slug): string
    {
        $trimmed = trim($slug);

        if ($trimmed === '') {
            return '';
        }

        $origin = self::publicOrigin();

        return $origin !== ''
            ? rtrim($origin, '/').'/articles/category/'.$trimmed.'/'
            : '/articles/category/'.$trimmed.'/';
    }

    private static function normalizePath(string $path): string
    {
        if ($path === '' || $path === '/') {
            return $path;
        }

        $trimmed = trim($path, '/');

        if ($trimmed === '') {
            return $path;
        }

        $segments = explode('/', $trimmed);

        if ($segments[0] === 'articles' && count($segments) === 2) {
            return '/articles/'.$segments[1].'/';
        }

        if ($segments[0] === 'articles' && count($segments) === 3 && $segments[1] === 'category') {
            return '/articles/category/'.$segments[2].'/';
        }

        if ($segments[0] === 'categories' && count($segments) === 2) {
            return '/articles/category/'.$segments[1].'/';
        }

        if (count($segments) === 1 && ! in_array($segments[0], self::reservedPaths(), true)) {
            return '/articles/'.$segments[0].'/';
        }

        return $path;
    }

    /**
     * @param  mixed  $value
     * @return mixed
     */
    public static function normalizeRecursive(mixed $value): mixed
    {
        if (is_string($value)) {
            return self::normalize($value);
        }

        if (! is_array($value)) {
            return $value;
        }

        foreach ($value as $key => $item) {
            $value[$key] = self::normalizeRecursive($item);
        }

        return $value;
    }

    /**
     * @param  mixed  $value
     * @return mixed
     */
    public static function normalizeArticleContextRecursive(mixed $value, string $articleSlug, ?string $categorySlug = null): mixed
    {
        if (is_string($value)) {
            $normalized = self::normalize($value);
            $articleUrl = self::articleUrl($articleSlug);

            if ($articleUrl !== '') {
                $origin = rtrim(self::publicOrigin(), '/');
                $normalized = str_replace(
                    [
                        $origin.'/'.$articleSlug.'/',
                        $origin.'/'.$articleSlug.'#',
                    ],
                    [
                        $articleUrl,
                        $articleUrl.'#',
                    ],
                    $normalized,
                );
            }

            if (is_string($categorySlug) && trim($categorySlug) !== '') {
                $categoryUrl = self::categoryUrl($categorySlug);

                if ($categoryUrl !== '') {
                    $origin = rtrim(self::publicOrigin(), '/');
                    $categoryPath = trim($categorySlug, '/');
                    $normalized = str_replace(
                        [
                            $origin.'/categories/'.$categoryPath.'/',
                            $origin.'/categories/'.$categoryPath.'#',
                        ],
                        [
                            $categoryUrl,
                            $categoryUrl.'#',
                        ],
                        $normalized,
                    );
                }
            }

            return $normalized;
        }

        if (! is_array($value)) {
            return $value;
        }

        foreach ($value as $key => $item) {
            $value[$key] = self::normalizeArticleContextRecursive($item, $articleSlug, $categorySlug);
        }

        return $value;
    }

    /**
     * @param  array<string, mixed>  $schema
     * @return array<string, mixed>
     */
    public static function normalizeArticleSchema(array $schema, string $articleSlug, ?string $categorySlug = null): array
    {
        $schema = self::normalizeArticleContextRecursive($schema, $articleSlug, $categorySlug);
        $articleUrl = self::articleUrl($articleSlug);

        if ($articleUrl === '') {
            return $schema;
        }

        $breadcrumbId = $articleUrl.'#breadcrumb';
        $articleId = $articleUrl.'#article';
        $faqId = $articleUrl.'#faq';
        $categoryUrl = is_string($categorySlug) && trim($categorySlug) !== ''
            ? self::categoryUrl($categorySlug)
            : '';

        if (isset($schema['@graph']) && is_array($schema['@graph'])) {
            foreach ($schema['@graph'] as $index => $entry) {
                if (! is_array($entry)) {
                    continue;
                }

                $type = (string) ($entry['@type'] ?? '');

                if ($type === 'BreadcrumbList') {
                    $entry['@id'] = $breadcrumbId;

                    if (isset($entry['itemListElement']) && is_array($entry['itemListElement'])) {
                        foreach ($entry['itemListElement'] as $itemIndex => $item) {
                            if (! is_array($item)) {
                                continue;
                            }

                            $position = (int) ($item['position'] ?? 0);

                            if ($position === 2 && $categoryUrl !== '') {
                                $item['item'] = $categoryUrl;
                            }

                            if ($position === 3) {
                                $item['item'] = $articleUrl;
                            }

                            $entry['itemListElement'][$itemIndex] = $item;
                        }
                    }
                }

                if ($type === 'Article') {
                    $entry['@id'] = $articleId;
                    $entry['url'] = $articleUrl;
                    $entry['mainEntityOfPage'] = $articleUrl;

                    if (isset($entry['breadcrumb']) && is_array($entry['breadcrumb'])) {
                        $entry['breadcrumb']['@id'] = $breadcrumbId;
                    }
                }

                if ($type === 'FAQPage') {
                    $entry['@id'] = $faqId;
                }

                $schema['@graph'][$index] = $entry;
            }
        }

        return $schema;
    }

    private static function publicOrigin(): string
    {
        $appUrl = (string) config('app.url', '');
        $scheme = parse_url($appUrl, PHP_URL_SCHEME);
        $host = parse_url($appUrl, PHP_URL_HOST);
        $port = parse_url($appUrl, PHP_URL_PORT);

        if (! is_string($host) || $host === '') {
            return '';
        }

        $origin = (is_string($scheme) && $scheme !== '' ? $scheme : 'https').'://'.$host;

        if (is_int($port)) {
            $origin .= ':'.$port;
        }

        return $origin;
    }

    private static function extractUrl(string $value): string
    {
        if ($value === '') {
            return '';
        }

        if (preg_match('/^\[[^\]]*\]\((https?:\/\/[^)]+)\)$/i', $value, $matches) === 1) {
            return trim((string) $matches[1]);
        }

        return $value;
    }

    /**
     * @return array<int, string>
     */
    private static function reservedPaths(): array
    {
        return [
            'about',
            'articles',
            'contact',
            'privacy-policy',
            'resources',
            'rss.xml',
            'search',
            'terms-and-conditions',
        ];
    }
}
