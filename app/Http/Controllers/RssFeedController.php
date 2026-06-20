<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\BlogContentService;
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

        return response()
            ->view('rss.feed', [
                'items' => $items,
                'lastBuildDate' => $lastBuildDate,
            ])
            ->header('Content-Type', 'application/rss+xml; charset=UTF-8');
    }
}
