<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\BlogContentService;
use App\Support\PublicSiteUrl;
use Carbon\CarbonImmutable;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(BlogContentService $content): Response
    {
        $urls = array_merge(
            $this->staticUrls(),
            $this->categoryUrls($content),
            $this->articleUrls($content),
        );

        $xml = $this->buildXml($urls);

        return response($xml)
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    /**
     * @return array<int, array{loc: string, lastmod?: string}>
     */
    private function staticUrls(): array
    {
        $today = now()->toDateString();

        return [
            ['loc' => route('home'), 'lastmod' => $today],
            ['loc' => route('resources.index'), 'lastmod' => $today],
            ['loc' => route('about.index'), 'lastmod' => $today],
            ['loc' => route('contact.index'), 'lastmod' => $today],
            ['loc' => route('legal.privacy'), 'lastmod' => $today],
            ['loc' => route('legal.terms'), 'lastmod' => $today],
            ['loc' => route('rss.feed'), 'lastmod' => $today],
        ];
    }

    /**
     * @return array<int, array{loc: string, lastmod?: string}>
     */
    private function categoryUrls(BlogContentService $content): array
    {
        try {
            $categories = $content->detailedCategories();
        } catch (\Throwable) {
            return [];
        }

        return array_values(array_filter(array_map(function (array $category): ?array {
            $slug = trim((string) data_get($category, 'slug', ''));

            if ($slug === '') {
                return null;
            }

            return array_filter([
                'loc' => PublicSiteUrl::categoryUrl($slug),
                'lastmod' => $this->normalizeDate(
                    (string) (data_get($category, 'updated_at') ?: data_get($category, 'created_at') ?: '')
                ),
            ]);
        }, $categories)));
    }

    /**
     * @return array<int, array{loc: string, lastmod?: string}>
     */
    private function articleUrls(BlogContentService $content): array
    {
        $page = 1;
        $urls = [];

        do {
            try {
                $payload = $content->posts(page: $page, perPage: 100);
            } catch (\Throwable) {
                break;
            }

            foreach (($payload['items'] ?? []) as $item) {
                if (! is_array($item)) {
                    continue;
                }

                $slug = trim((string) data_get($item, 'slug', ''));

                if ($slug === '') {
                    continue;
                }

                $urls[] = array_filter([
                    'loc' => PublicSiteUrl::articleUrl($slug),
                    'lastmod' => $this->normalizeDate(
                        (string) (data_get($item, 'updated_at')
                            ?: data_get($item, 'last_modified_at')
                            ?: data_get($item, 'published_at')
                            ?: data_get($item, 'created_at')
                            ?: '')
                    ),
                ]);
            }

            $page++;
            $hasMore = (bool) ($payload['has_more'] ?? false);
        } while ($hasMore);

        return $urls;
    }

    /**
     * @param  array<int, array{loc: string, lastmod?: string}>  $urls
     */
    private function buildXml(array $urls): string
    {
        $lines = [
            '<?xml version="1.0" encoding="UTF-8"?>',
            '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">',
        ];

        foreach ($urls as $url) {
            $loc = trim((string) ($url['loc'] ?? ''));

            if ($loc === '') {
                continue;
            }

            $lines[] = '  <url>';
            $lines[] = '    <loc>'.$this->xml($loc).'</loc>';

            if (filled($url['lastmod'] ?? null)) {
                $lines[] = '    <lastmod>'.$this->xml((string) $url['lastmod']).'</lastmod>';
            }

            $lines[] = '  </url>';
        }

        $lines[] = '</urlset>';

        return implode("\n", $lines);
    }

    private function normalizeDate(string $value): ?string
    {
        if ($value === '') {
            return null;
        }

        try {
            return CarbonImmutable::parse($value)->toDateString();
        } catch (\Throwable) {
            return null;
        }
    }

    private function xml(string $value): string
    {
        return e($value);
    }
}
