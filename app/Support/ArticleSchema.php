<?php

declare(strict_types=1);

namespace App\Support;

use Carbon\CarbonImmutable;

final class ArticleSchema
{
    /**
     * @param  array<int, array<string, mixed>>  $schema
     */
    public static function hasPrimaryArticle(array $schema): bool
    {
        foreach ($schema as $entry) {
            if (self::containsArticleType($entry)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param  array<string, mixed>  $post
     * @return array<int, array<string, mixed>>
     */
    public static function fallback(array $post, string $canonical, string $description, string $image): array
    {
        $canonical = $canonical !== '' ? $canonical : PublicSiteUrl::articleUrl((string) data_get($post, 'slug', ''));

        if ($canonical === '') {
            return [];
        }

        $title = (string) data_get($post, 'title', 'Untitled article');
        $categoryName = (string) data_get($post, 'category.name', '');
        $categorySlug = (string) data_get($post, 'category.slug', '');
        $authorName = (string) data_get($post, 'author.name', config('site.name', config('app.name')));
        $publishedAt = self::formatIsoDate((string) (data_get($post, 'published_at') ?: data_get($post, 'created_at') ?: ''));
        $modifiedAt = self::formatIsoDate((string) (data_get($post, 'updated_at') ?: data_get($post, 'last_modified_at') ?: data_get($post, 'published_at') ?: data_get($post, 'created_at') ?: ''));
        $tags = self::normalizeTags(data_get($post, 'tags'));
        $faqItems = self::normalizeFaqItems(data_get($post, 'faq'));

        $breadcrumbItems = [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => route('home'),
            ],
        ];

        $position = 2;

        if ($categoryName !== '' && $categorySlug !== '') {
            $breadcrumbItems[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $categoryName,
                'item' => PublicSiteUrl::categoryUrl($categorySlug),
            ];
        }

        $breadcrumbItems[] = [
            '@type' => 'ListItem',
            'position' => $position,
            'name' => $title,
            'item' => $canonical,
        ];

        $graph = [
            array_filter([
                '@type' => 'BreadcrumbList',
                '@id' => $canonical.'#breadcrumb',
                'itemListElement' => $breadcrumbItems,
            ]),
            array_filter([
                '@type' => 'Article',
                '@id' => $canonical.'#article',
                'headline' => $title,
                'description' => $description,
                'url' => $canonical,
                'mainEntityOfPage' => $canonical,
                'image' => $image !== '' ? [$image] : null,
                'datePublished' => $publishedAt,
                'dateModified' => $modifiedAt,
                'articleSection' => $categoryName !== '' ? $categoryName : null,
                'keywords' => $tags !== [] ? implode(', ', $tags) : null,
                'author' => [
                    '@type' => 'Person',
                    'name' => $authorName,
                ],
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => config('site.name', config('app.name')),
                    'url' => url('/'),
                ],
                'breadcrumb' => [
                    '@id' => $canonical.'#breadcrumb',
                ],
            ], static fn (mixed $value): bool => $value !== null && $value !== ''),
        ];

        if ($faqItems !== []) {
            $graph[] = [
                '@type' => 'FAQPage',
                '@id' => $canonical.'#faq',
                'mainEntity' => $faqItems,
            ];
        }

        return [[
            '@context' => 'https://schema.org',
            '@graph' => $graph,
        ]];
    }

    private static function formatIsoDate(string $value): ?string
    {
        if ($value === '') {
            return null;
        }

        try {
            return CarbonImmutable::parse($value)->toIso8601String();
        } catch (\Throwable) {
            return null;
        }
    }

    /**
     * @param  array<string, mixed>  $entry
     */
    private static function containsArticleType(array $entry): bool
    {
        $type = $entry['@type'] ?? null;

        if (is_string($type) && in_array($type, ['Article', 'BlogPosting', 'NewsArticle'], true)) {
            return true;
        }

        if (is_array($type)) {
            foreach ($type as $item) {
                if (is_string($item) && in_array($item, ['Article', 'BlogPosting', 'NewsArticle'], true)) {
                    return true;
                }
            }
        }

        $graph = $entry['@graph'] ?? null;

        if (! is_array($graph)) {
            return false;
        }

        foreach ($graph as $graphEntry) {
            if (is_array($graphEntry) && self::containsArticleType($graphEntry)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array<int, string>
     */
    private static function normalizeTags(mixed $tags): array
    {
        $tagObjects = array_values(array_filter(array_map(
            static fn (mixed $tag): string => is_array($tag)
                ? (string) (data_get($tag, 'name') ?: data_get($tag, 'slug') ?: '')
                : '',
            PublicApiValue::listValue($tags),
        )));

        if ($tagObjects !== []) {
            return $tagObjects;
        }

        return PublicApiValue::stringList($tags);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private static function normalizeFaqItems(mixed $faq): array
    {
        $items = [];

        foreach (PublicApiValue::listValue($faq) as $item) {
            if (! is_array($item)) {
                continue;
            }

            $question = trim((string) (data_get($item, 'question') ?: data_get($item, 'title') ?: data_get($item, 'label') ?: ''));
            $answer = (string) (data_get($item, 'answer_html')
                ?: data_get($item, 'answer_markdown')
                ?: data_get($item, 'answer')
                ?: data_get($item, 'content_markdown')
                ?: data_get($item, 'content')
                ?: data_get($item, 'body')
                ?: data_get($item, 'description')
                ?: '');
            $answer = trim(strip_tags($answer));

            if ($question === '' || $answer === '') {
                continue;
            }

            $items[] = [
                '@type' => 'Question',
                'name' => $question,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $answer,
                ],
            ];
        }

        return $items;
    }
}
