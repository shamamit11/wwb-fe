<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Services\BlogContentService;
use App\Support\MediaUrl;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use Livewire\Component;

class ArticleDetailPage extends Component
{
    /** @var array<string, mixed> */
    public array $article = [];

    /** @var array<int, array<string, mixed>> */
    public array $relatedArticles = [];

    /** @var array<int, string> */
    public array $sidebarTopics = [];

    public function mount(string $slug, ?array $postPayload = null): void
    {
        $post = $postPayload ?? app(BlogContentService::class)->post($slug);

        if ($post === null) {
            throw (new ModelNotFoundException())->setModel('Article', [$slug]);
        }

        $this->article = $this->mapArticle($post);
        $this->relatedArticles = $this->mapRelatedArticles(data_get($post, 'related_posts', []));
        $this->sidebarTopics = $this->extractSidebarTopics($post);
    }

    public function render()
    {
        return view('livewire.article-detail-page');
    }

    /**
     * @param  array<string, mixed>  $post
     * @return array<string, mixed>
     */
    private function mapArticle(array $post): array
    {
        $featuredMedia = data_get($post, 'featured_media', []);
        $authorName = (string) data_get($post, 'author.name', 'Wide Web Blog');
        $categoryName = (string) data_get($post, 'category.name', 'Articles');
        $contentMarkdown = (string) (data_get($post, 'content_markdown') ?: data_get($post, 'content') ?: '');

        return [
            'slug' => (string) data_get($post, 'slug', ''),
            'title' => (string) data_get($post, 'title', 'Untitled article'),
            'excerpt' => (string) data_get($post, 'excerpt', ''),
            'category' => $categoryName,
            'category_slug' => (string) data_get($post, 'category.slug', ''),
            'author' => $authorName,
            'author_role' => (string) data_get($post, 'template.name', 'Editorial Team'),
            'date' => $this->formatDate((string) data_get($post, 'published_at', '')),
            'read_time' => (string) (data_get($post, 'read_time') ?: '5 min read'),
            'image' => MediaUrl::normalize((string) (data_get($post, 'featured_image') ?: data_get($featuredMedia, 'url') ?: '')),
            'image_alt' => (string) (data_get($featuredMedia, 'alt_text') ?: data_get($post, 'title', '')),
            'caption' => (string) data_get($featuredMedia, 'caption', ''),
            'tags' => array_values(array_map(
                static fn (array $tag): string => '#'.Str::of((string) (data_get($tag, 'slug') ?: data_get($tag, 'name', '')))
                    ->lower()
                    ->slug('-'),
                array_filter(
                    data_get($post, 'tags', []),
                    static fn (mixed $tag): bool => is_array($tag) && filled(data_get($tag, 'name')),
                ),
            )),
            'body_html' => $this->renderMarkdown($contentMarkdown),
            'sections' => $sections = $this->buildSections(data_get($post, 'blocks', [])),
            'has_content_sections' => collect($sections)->contains(static fn (array $section): bool => ($section['type'] ?? null) === 'section'),
        ];
    }

    /**
     * @param  mixed  $blocks
     * @return array<int, array<string, mixed>>
     */
    private function buildSections(mixed $blocks): array
    {
        if (! is_array($blocks)) {
            return [];
        }

        $mappedSections = [];
        $currentSection = null;

        foreach ($blocks as $block) {
            if (! is_array($block)) {
                continue;
            }

            $blockType = Str::lower(trim((string) (data_get($block, 'block_type') ?: data_get($block, 'type') ?: '')));

            if ($blockType === 'heading') {
                if ($currentSection !== null && $currentSection['blocks'] !== []) {
                    $mappedSections[] = $currentSection;
                }

                $title = $this->extractHeadingText((string) data_get($block, 'content_markdown', ''));

                $currentSection = [
                    'type' => 'section',
                    'title' => $title,
                    'level' => max(2, (int) data_get($block, 'settings.level', 2)),
                    'blocks' => [],
                    'variant' => $this->sectionVariant($title),
                ];

                continue;
            }

            if ($blockType !== 'faq') {
                $mappedBlock = $this->mapSectionBlock($blockType, $block);

                if ($mappedBlock === null) {
                    continue;
                }

                if ($currentSection === null) {
                    $currentSection = [
                        'type' => 'section',
                        'title' => '',
                        'level' => 2,
                        'blocks' => [],
                        'variant' => 'standard',
                    ];
                }

                $currentSection['blocks'][] = $mappedBlock;
                continue;
            }

            if ($currentSection !== null && $currentSection['blocks'] !== []) {
                $mappedSections[] = $currentSection;
                $currentSection = null;
            }

            $items = data_get($block, 'settings.items')
                ?: data_get($block, 'data.items')
                ?: data_get($block, 'content.items')
                ?: data_get($block, 'faqs');

            if (! is_array($items)) {
                continue;
            }

            $mappedItems = array_map(function (mixed $item, int $index): ?array {
                if (! is_array($item)) {
                    return null;
                }

                $question = $this->cleanQuestion((string) (data_get($item, 'question') ?: data_get($item, 'title') ?: data_get($item, 'label') ?: ''));
                $answer = (string) (data_get($item, 'answer_markdown')
                    ?: data_get($item, 'answer')
                    ?: data_get($item, 'content_markdown')
                    ?: data_get($item, 'content')
                    ?: data_get($item, 'body')
                    ?: data_get($item, 'description')
                    ?: '');

                if ($question === '' || trim($answer) === '') {
                    return null;
                }

                return [
                    'question' => $question,
                    'answer_html' => $this->renderMarkdown($answer),
                    'open' => $index === 0,
                ];
            }, $items, array_keys($items));

            $mappedItems = array_values(array_filter(
                $mappedItems,
                static fn (?array $item): bool => is_array($item) && $item['answer_html'] !== '',
            ));

            if ($mappedItems === []) {
                continue;
            }

            $mappedSections[] = [
                'type' => 'faq',
                'title' => $this->extractHeadingText((string) (data_get($block, 'title') ?: data_get($block, 'heading') ?: 'Frequently Asked Questions')),
                'items' => $mappedItems,
            ];
        }

        if ($currentSection !== null && $currentSection['blocks'] !== []) {
            $mappedSections[] = $currentSection;
        }

        return $mappedSections;
    }

    /**
     * @param  array<string, mixed>  $block
     * @return array<string, mixed>|null
     */
    private function mapSectionBlock(string $blockType, array $block): ?array
    {
        $content = (string) (data_get($block, 'content_markdown') ?: data_get($block, 'content') ?: '');

        return match ($blockType) {
            'paragraph' => $this->mapHtmlBlock('paragraph', $content),
            'list' => $this->mapHtmlBlock('list', $content),
            'quote' => $this->mapQuoteBlock($block, $content),
            'callout' => $this->mapCalloutBlock($block, $content),
            'code' => $this->mapCodeBlock($block, $content),
            'image' => $this->mapImageBlock($block),
            default => null,
        };
    }

    /**
     * @return array<string, mixed>|null
     */
    private function mapHtmlBlock(string $type, string $content): ?array
    {
        $html = $this->renderMarkdown($content);

        if ($html === '') {
            return null;
        }

        return [
            'type' => $type,
            'html' => $html,
        ];
    }

    /**
     * @param  array<string, mixed>  $block
     * @return array<string, mixed>|null
     */
    private function mapQuoteBlock(array $block, string $content): ?array
    {
        $html = $this->renderMarkdown($content);

        if ($html === '') {
            return null;
        }

        return [
            'type' => 'quote',
            'html' => $html,
            'citation' => trim((string) (data_get($block, 'settings.citation') ?: data_get($block, 'settings.attribution') ?: '')),
        ];
    }

    /**
     * @param  array<string, mixed>  $block
     * @return array<string, mixed>|null
     */
    private function mapCalloutBlock(array $block, string $content): ?array
    {
        $html = $this->renderMarkdown($content);

        if ($html === '') {
            return null;
        }

        return [
            'type' => 'callout',
            'html' => $html,
            'title' => trim((string) (data_get($block, 'settings.title') ?: data_get($block, 'settings.heading') ?: 'Key Insight')),
            'tone' => Str::lower(trim((string) (data_get($block, 'settings.tone') ?: data_get($block, 'settings.variant') ?: 'insight'))),
        ];
    }

    /**
     * @param  array<string, mixed>  $block
     * @return array<string, mixed>|null
     */
    private function mapCodeBlock(array $block, string $content): ?array
    {
        $language = trim((string) data_get($block, 'settings.language', ''));
        $code = trim($content);

        if (preg_match('/^```([a-zA-Z0-9_-]+)?\n(?P<code>.*)\n```$/s', $code, $matches) === 1) {
            $language = $language !== '' ? $language : trim((string) ($matches[1] ?? ''));
            $code = trim((string) ($matches['code'] ?? ''));
        }

        if ($code === '') {
            return null;
        }

        return [
            'type' => 'code',
            'code' => $code,
            'language' => $language,
            'label' => trim((string) (data_get($block, 'settings.label') ?: data_get($block, 'settings.title') ?: '')),
        ];
    }

    /**
     * @param  array<string, mixed>  $block
     * @return array<string, mixed>|null
     */
    private function mapImageBlock(array $block): ?array
    {
        $src = MediaUrl::normalize((string) (
            data_get($block, 'settings.url')
            ?: data_get($block, 'settings.src')
            ?: data_get($block, 'settings.image_url')
            ?: data_get($block, 'url')
            ?: data_get($block, 'image_url')
            ?: data_get($block, 'content')
            ?: ''
        ));

        if ($src === '') {
            return null;
        }

        return [
            'type' => 'image',
            'src' => $src,
            'alt' => trim((string) (data_get($block, 'settings.alt') ?: data_get($block, 'settings.alt_text') ?: 'Article image')),
            'caption' => trim((string) (data_get($block, 'settings.caption') ?: data_get($block, 'settings.description') ?: '')),
        ];
    }

    /**
     * @param  mixed  $items
     * @return array<int, array<string, mixed>>
     */
    private function mapRelatedArticles(mixed $items): array
    {
        if (! is_array($items)) {
            return [];
        }

        return array_values(array_map(
            fn (array $item): array => [
                'slug' => (string) data_get($item, 'slug', ''),
                'title' => (string) data_get($item, 'title', 'Untitled article'),
                'category' => (string) data_get($item, 'category.name', 'Article'),
                'read_time' => (string) (data_get($item, 'read_time') ?: '5 min read'),
                'image' => MediaUrl::normalize((string) (data_get($item, 'featured_image') ?: data_get($item, 'featured_media.url') ?: '')),
            ],
            array_filter($items, static fn (mixed $item): bool => is_array($item) && filled(data_get($item, 'slug'))),
        ));
    }

    /**
     * @param  array<string, mixed>  $post
     * @return array<int, string>
     */
    private function extractSidebarTopics(array $post): array
    {
        $tags = array_values(array_map(
            static fn (array $tag): string => '#'.Str::of((string) (data_get($tag, 'slug') ?: data_get($tag, 'name', '')))
                ->lower()
                ->slug('-'),
            array_filter(
                data_get($post, 'tags', []),
                static fn (mixed $tag): bool => is_array($tag) && filled(data_get($tag, 'name')),
            ),
        ));

        if ($tags !== []) {
            return $tags;
        }

        return array_values(array_map(
            static fn (array $related): string => (string) data_get($related, 'title', 'Article'),
            array_filter(
                data_get($post, 'related_posts', []),
                static fn (mixed $related): bool => is_array($related) && filled(data_get($related, 'title')),
            ),
        ));
    }

    private function formatDate(string $value): string
    {
        if ($value === '') {
            return '';
        }

        try {
            return CarbonImmutable::parse($value)->format('F j, Y');
        } catch (\Throwable) {
            return $value;
        }
    }

    private function renderMarkdown(string $content): string
    {
        $trimmed = trim($this->normalizeMarkdown($content));

        return $trimmed !== '' ? Str::markdown($trimmed) : '';
    }

    private function normalizeMarkdown(string $content): string
    {
        $normalized = preg_replace('/^(#{1,6})\s+\1\s+/m', '$1 ', trim($content));

        return is_string($normalized) ? $normalized : trim($content);
    }

    private function extractHeadingText(string $content): string
    {
        $normalized = $this->normalizeMarkdown($content);
        $firstLine = trim(Str::before($normalized, "\n"));
        $withoutHashes = preg_replace('/^#{1,6}\s*/', '', $firstLine);

        return is_string($withoutHashes) ? trim($withoutHashes) : trim($firstLine);
    }

    private function cleanQuestion(string $question): string
    {
        $cleaned = preg_replace('/^#{1,6}\s*/', '', trim($question));

        return is_string($cleaned) ? trim($cleaned) : trim($question);
    }

    private function sectionVariant(string $title): string
    {
        $normalized = Str::lower($title);

        return match (true) {
            Str::contains($normalized, 'quick tl;dr') => 'summary',
            Str::contains($normalized, 'checklist') => 'checklist',
            Str::contains($normalized, 'recommended tools') => 'recommendations',
            default => 'standard',
        };
    }

}
