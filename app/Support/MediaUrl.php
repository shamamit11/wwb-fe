<?php

declare(strict_types=1);

namespace App\Support;

final class MediaUrl
{
    public static function normalize(?string $url): string
    {
        $resolved = is_string($url) ? trim($url) : '';

        if (
            $resolved === ''
            || str_starts_with($resolved, 'http://')
            || str_starts_with($resolved, 'https://')
            || str_starts_with($resolved, 'data:')
        ) {
            return $resolved;
        }

        if (! str_starts_with($resolved, '/')) {
            return $resolved;
        }

        $origin = self::resolveOrigin();

        if ($origin === '') {
            return $resolved;
        }

        return rtrim($origin, '/').$resolved;
    }

    private static function resolveOrigin(): string
    {
        $configuredOrigin = self::originFromUrl((string) config('services.wideweb_blog.media_base_url', ''));

        if ($configuredOrigin !== '') {
            return $configuredOrigin;
        }

        $baseUrl = (string) config('services.wideweb_blog.base_url', '');
        $scheme = parse_url($baseUrl, PHP_URL_SCHEME);
        $host = parse_url($baseUrl, PHP_URL_HOST);
        $port = parse_url($baseUrl, PHP_URL_PORT);

        if (! is_string($host) || $host === '') {
            return '';
        }

        if (str_starts_with($host, 'service.')) {
            $host = 'media.'.substr($host, strlen('service.'));
        }

        $origin = (is_string($scheme) && $scheme !== '' ? $scheme : 'https').'://'.$host;

        if (is_int($port)) {
            $origin .= ':'.$port;
        }

        return $origin;
    }

    private static function originFromUrl(string $url): string
    {
        $scheme = parse_url($url, PHP_URL_SCHEME);
        $host = parse_url($url, PHP_URL_HOST);
        $port = parse_url($url, PHP_URL_PORT);

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
