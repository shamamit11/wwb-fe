<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Services\BlogContentService;
use App\Support\MediaUrl;
use App\Support\PublicApiValue;
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
        $featuredMedia = PublicApiValue::firstArray(data_get($post, 'featured_media'));
        $faq = $this->normalizeFaq(data_get($post, 'faq'));

        return [
            'slug' => (string) data_get($post, 'slug', ''),
            'title' => (string) data_get($post, 'title', 'Untitled article'),
            'excerpt' => (string) (data_get($post, 'short_description') ?: data_get($post, 'excerpt') ?: data_get($post, 'description') ?: ''),
            'category' => (string) data_get($post, 'category.name', 'Articles'),
            'category_slug' => (string) data_get($post, 'category.slug', ''),
            'author' => (string) data_get($post, 'author.name', 'Wide Web Blog'),
            'author_role' => '',
            'date' => $this->formatDate((string) data_get($post, 'published_at', '')),
            'read_time' => $this->resolveReadTime($post),
            'image' => MediaUrl::normalize((string) (data_get($post, 'featured_image') ?: data_get($featuredMedia, 'url') ?: '')),
            'image_alt' => (string) (data_get($featuredMedia, 'alt_text') ?: data_get($post, 'title', '')),
            'caption' => (string) data_get($featuredMedia, 'caption', ''),
            'tags' => $this->normalizeTags(data_get($post, 'tags')),
            'body_html' => $this->resolveBodyHtml($post),
            'faq_items' => $faq['items'],
            'faq_html' => $faq['html'],
        ];
    }

    /**
     * @param  mixed  $faq
     * @return array{items: array<int, array<string, mixed>>, html: string}
     */
    private function normalizeFaq(mixed $faq): array
    {
        $list = PublicApiValue::listValue($faq);
        $items = array_values(array_filter(array_map(
            fn (mixed $item, int $index): ?array => $this->mapFaqItem($item, $index),
            $list,
            array_keys($list),
        )));

        return [
            'items' => $items,
            'html' => $items === [] ? $this->renderFlexibleContent(PublicApiValue::stringValue($faq)) : '',
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    private function mapFaqItem(mixed $item, int $index): ?array
    {
        if (! is_array($item)) {
            return null;
        }

        $question = $this->cleanQuestion((string) (data_get($item, 'question') ?: data_get($item, 'title') ?: data_get($item, 'label') ?: ''));
        $answer = (string) (data_get($item, 'answer_html')
            ?: data_get($item, 'answer_markdown')
            ?: data_get($item, 'answer')
            ?: data_get($item, 'content_markdown')
            ?: data_get($item, 'content')
            ?: data_get($item, 'body')
            ?: data_get($item, 'description')
            ?: '');
        $answerHtml = $this->renderFlexibleContent($answer);

        if ($question === '' || $answerHtml === '') {
            return null;
        }

        return [
            'question' => $question,
            'answer_html' => $answerHtml,
            'open' => $index === 0,
        ];
    }

    /**
     * @param  mixed  $postTags
     * @return array<int, string>
     */
    private function normalizeTags(mixed $postTags): array
    {
        $tagObjects = array_values(array_filter(array_map(
            static fn (mixed $tag): string => is_array($tag)
                ? (string) (data_get($tag, 'name') ?: data_get($tag, 'slug') ?: '')
                : '',
            PublicApiValue::listValue($postTags),
        )));

        if ($tagObjects !== []) {
            return $tagObjects;
        }

        return array_values(array_filter(PublicApiValue::stringList($postTags)));
    }

    /**
     * @param  array<string, mixed>  $post
     */
    private function resolveBodyHtml(array $post): string
    {
        $html = PublicApiValue::stringValue(data_get($post, 'full_article_html'));

        if ($html !== '') {
            return $this->normalizeRichHtml(
                $this->stripDuplicateLeadingHeading($html, (string) data_get($post, 'title', ''))
            );
        }

        return $this->renderFlexibleContent((string) (data_get($post, 'content') ?: data_get($post, 'description') ?: ''));
    }

    /**
     * @param  array<string, mixed>  $item
     */
    private function resolveReadTime(array $item): string
    {
        $explicit = PublicApiValue::stringValue(data_get($item, 'read_time'));

        if ($explicit !== '') {
            return $explicit;
        }

        $minutes = data_get($item, 'reading_time_minutes');

        if (is_numeric($minutes) && (int) $minutes > 0) {
            return (int) $minutes.' min read';
        }

        return '5 min read';
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
                'read_time' => $this->resolveReadTime($item),
                'image' => MediaUrl::normalize((string) (data_get($item, 'featured_image') ?: data_get(PublicApiValue::firstArray(data_get($item, 'featured_media')), 'url') ?: '')),
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
        $tags = $this->normalizeTags(data_get($post, 'tags', []));

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

    private function renderFlexibleContent(string $content): string
    {
        $trimmed = trim($this->normalizeTextEncoding($content));

        if ($trimmed === '') {
            return '';
        }

        if ($this->looksLikeHtml($trimmed)) {
            return $trimmed;
        }

        return $this->renderMarkdown($trimmed);
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

    private function cleanQuestion(string $question): string
    {
        $cleaned = preg_replace('/^#{1,6}\s*/', '', trim($question));

        return is_string($cleaned) ? trim($cleaned) : trim($question);
    }

    private function looksLikeHtml(string $content): bool
    {
        return preg_match('/<\s*[a-zA-Z][^>]*>/', $content) === 1;
    }

    private function stripDuplicateLeadingHeading(string $html, string $title): string
    {
        $trimmedHtml = ltrim($html);
        $normalizedTitle = Str::of(strip_tags($title))->squish()->lower()->toString();

        if ($trimmedHtml === '' || $normalizedTitle === '') {
            return $html;
        }

        if (preg_match('/^\s*<h1\b[^>]*>(.*?)<\/h1>/is', $html, $matches) !== 1) {
            return $html;
        }

        $headingText = Str::of(strip_tags((string) ($matches[1] ?? '')))->squish()->lower()->toString();

        if ($headingText !== $normalizedTitle) {
            return $html;
        }

        $stripped = preg_replace('/^\s*<h1\b[^>]*>.*?<\/h1>\s*/is', '', $html, 1);

        return is_string($stripped) ? $stripped : $html;
    }

    private function normalizeRichHtml(string $html): string
    {
        return $this->normalizeQuillCodeBlocks($this->normalizeTextEncoding($html));
    }

    private function normalizeTextEncoding(string $content): string
    {
        if ($content === '' || ! $this->looksLikeMojibake($content)) {
            return $content;
        }

        return strtr($content, [
            'â€”' => '—',
            'â€“' => '–',
            'â€™' => '’',
            'â€˜' => '‘',
            'â€œ' => '“',
            'â€�' => '”',
            'â€¦' => '…',
            'â†’' => '→',
            'Â ' => ' ',
            'Â ' => ' ',
        ]);
    }

    private function looksLikeMojibake(string $content): bool
    {
        return preg_match('/(?:â€”|â€“|â€˜|â€™|â€œ|â€�|â€¦|Â |Â\xa0|Ã)/u', $content) === 1;
    }

    private function normalizeQuillCodeBlocks(string $html): string
    {
        $previous = libxml_use_internal_errors(true);
        $document = new \DOMDocument('1.0', 'UTF-8');
        $wrappedHtml = '<?xml encoding="UTF-8"><!DOCTYPE html><html><body>'.$html.'</body></html>';

        if (! $document->loadHTML($wrappedHtml, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD)) {
            libxml_clear_errors();
            libxml_use_internal_errors($previous);

            return $html;
        }

        $xpath = new \DOMXPath($document);
        $containers = $xpath->query('//div[contains(concat(" ", normalize-space(@class), " "), " ql-code-block-container ")]');

        if ($containers === false || $containers->length === 0) {
            libxml_clear_errors();
            libxml_use_internal_errors($previous);

            return $html;
        }

        /** @var \DOMElement $container */
        foreach ($containers as $container) {
            $lines = $xpath->query('.//div[contains(concat(" ", normalize-space(@class), " "), " ql-code-block ")]', $container);

            if ($lines === false || $lines->length === 0) {
                continue;
            }

            $codeLines = [];

            /** @var \DOMElement $line */
            foreach ($lines as $line) {
                $codeLines[] = trim($line->textContent);
            }

            $pre = $document->createElement('pre');
            $code = $document->createElement('code');
            $code->appendChild($document->createTextNode(implode("\n", $codeLines)));
            $pre->appendChild($code);

            $container->parentNode?->replaceChild($pre, $container);
        }

        $body = $document->getElementsByTagName('body')->item(0);

        if (! $body instanceof \DOMElement) {
            libxml_clear_errors();
            libxml_use_internal_errors($previous);

            return $html;
        }

        $result = '';

        foreach ($body->childNodes as $child) {
            $result .= $document->saveHTML($child);
        }

        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        return $result !== '' ? $result : $html;
    }
}
