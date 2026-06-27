<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\BlogContentService;
use App\Support\PublicSiteUrl;
use Carbon\CarbonImmutable;
use Illuminate\Http\Response;

class RssFeedController extends Controller
{
    public function __invoke(BlogContentService $content): Response
    {
        try {
            $items = $content->rssFeed();
        } catch (\Throwable) {
            $items = [];
        }

        $lastBuildDate = collect($items)
            ->map(fn (array $item): string => (string) ($item['last_modified_at'] ?? $item['published_at'] ?? ''))
            ->filter()
            ->map(fn (string $value): string => CarbonImmutable::parse($value)->toRfc2822String())
            ->last() ?? now()->toRfc2822String();

        $currentUrl = url()->current();
        $currentPath = request()->getPathInfo();
        $siteUrl = $currentPath === '/'
            ? rtrim($currentUrl, '/')
            : (explode($currentPath, $currentUrl, 2)[0] ?? '');
        $siteUrl = $siteUrl !== '' ? $siteUrl : $currentUrl;
        $feedUrl = $siteUrl.route('rss.feed', [], false);
        $siteName = (string) config('site.name', config('app.name'));
        $siteDescription = (string) config('site.description');
        $language = str_replace('_', '-', app()->getLocale());
        $xml = $this->buildXml(
            siteName: $siteName,
            siteUrl: $siteUrl,
            siteDescription: $siteDescription,
            language: $language,
            lastBuildDate: $lastBuildDate,
            feedUrl: $feedUrl,
            items: $items,
        );

        return response($xml)
            ->header('Content-Type', 'application/rss+xml; charset=UTF-8');
    }

    /**
     * @param  array<int, array<string, mixed>>  $items
     */
    private function buildXml(
        string $siteName,
        string $siteUrl,
        string $siteDescription,
        string $language,
        string $lastBuildDate,
        string $feedUrl,
        array $items,
    ): string {
        $xml = [
            '<?xml version="1.0" encoding="UTF-8"?>',
            '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">',
            '<channel>',
            '<title>'.$this->xml($siteName).'</title>',
            '<link>'.$this->xml($siteUrl).'</link>',
            '<description>'.$this->xml($siteDescription).'</description>',
            '<language>'.$this->xml($language).'</language>',
            '<lastBuildDate>'.$this->xml($lastBuildDate).'</lastBuildDate>',
            '<atom:link href="'.$this->xml($feedUrl).'" rel="self" type="application/rss+xml" />',
        ];

        foreach ($items as $item) {
            $title = (string) data_get($item, 'title', 'Untitled');
            $link = $this->resolveItemLink($item, $siteUrl);
            $link = $link !== '' ? $link : $siteUrl;
            $description = (string) data_get($item, 'description', '');
            $publishedAt = (string) data_get($item, 'published_at', now()->toISOString());
            $pubDate = CarbonImmutable::parse($publishedAt)->toRfc2822String();
            $authorName = (string) data_get($item, 'author.name', '');
            $categoryName = (string) data_get($item, 'category.name', '');

            $xml[] = '<item>';
            $xml[] = '<title>'.$this->xml($title).'</title>';
            $xml[] = '<link>'.$this->xml($link).'</link>';
            $xml[] = '<guid isPermaLink="true">'.$this->xml($link).'</guid>';
            $xml[] = '<description>'.$this->xml($description).'</description>';
            $xml[] = '<pubDate>'.$this->xml($pubDate).'</pubDate>';

            if ($authorName !== '') {
                $xml[] = '<author>'.$this->xml($authorName).'</author>';
            }

            if ($categoryName !== '') {
                $xml[] = '<category>'.$this->xml($categoryName).'</category>';
            }

            $xml[] = '</item>';
        }

        $xml[] = '</channel>';
        $xml[] = '</rss>';

        return implode("\n", $xml);
    }

    /**
     * @param  array<string, mixed>  $item
     */
    private function resolveItemLink(array $item, string $siteUrl): string
    {
        $slug = trim((string) data_get($item, 'slug', ''));

        if ($slug !== '') {
            return rtrim($siteUrl, '/').route('articles.show', ['slug' => $slug], false);
        }

        return PublicSiteUrl::normalize((string) data_get($item, 'link', $siteUrl));
    }

    private function xml(string $value): string
    {
        return e($value);
    }
}
