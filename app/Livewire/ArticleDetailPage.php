<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Services\BlogContentService;
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
            'image' => (string) (data_get($post, 'featured_image') ?: data_get($featuredMedia, 'url') ?: ''),
            'image_alt' => (string) (data_get($featuredMedia, 'alt_text') ?: data_get($post, 'title', '')),
            'caption' => (string) data_get($featuredMedia, 'caption', ''),
            'tags' => array_values(array_map(
                static fn (array $tag): string => '#'.$tag['name'],
                array_filter(
                    data_get($post, 'tags', []),
                    static fn (mixed $tag): bool => is_array($tag) && filled(data_get($tag, 'name')),
                ),
            )),
            'body_html' => $contentMarkdown !== '' ? Str::markdown($contentMarkdown) : '',
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
                'image' => (string) (data_get($item, 'featured_image') ?: data_get($item, 'featured_media.url') ?: ''),
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
            static fn (array $tag): string => (string) $tag['name'],
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
}
