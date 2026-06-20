<?php

declare(strict_types=1);

namespace App\Support;

final class PublicSiteUrl
{
    public static function normalize(?string $url): string
    {
        $resolved = is_string($url) ? trim($url) : '';

        if ($resolved === '') {
            return '';
        }

        $host = parse_url($resolved, PHP_URL_HOST);
        $serviceHost = parse_url((string) config('services.wideweb_blog.base_url', ''), PHP_URL_HOST);
        $publicOrigin = self::publicOrigin();

        if (! is_string($host) || $host === '' || ! is_string($serviceHost) || $serviceHost === '' || $publicOrigin === '') {
            return $resolved;
        }

        if ($host !== $serviceHost) {
            return $resolved;
        }

        $path = parse_url($resolved, PHP_URL_PATH) ?: '';
        $query = parse_url($resolved, PHP_URL_QUERY);
        $fragment = parse_url($resolved, PHP_URL_FRAGMENT);

        $normalized = rtrim($publicOrigin, '/').$path;

        if (is_string($query) && $query !== '') {
            $normalized .= '?'.$query;
        }

        if (is_string($fragment) && $fragment !== '') {
            $normalized .= '#'.$fragment;
        }

        return $normalized;
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
}
