<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Services\BlogContentService;
use Carbon\CarbonImmutable;
use Throwable;
use Livewire\Component;

class AllArticlesPage extends Component
{
    /** @var array<int, array<string, string>> */
    public array $filters = [];

    /** @var array<int, array<string, mixed>> */
    public array $articles = [];

    public string $activeCategory = 'all';

    public int $page = 1;

    public int $totalFiltered = 0;

    public string $lastUpdated = 'May 2024';

    public string $pageTitle = 'All Articles';

    public string $pageDescription = 'A curated collection of professional insights on AI, productivity, and the evolving tech landscape.';

    public bool $hasMore = false;

    public function mount(BlogContentService $content, ?string $category = null, ?string $pageTitle = null, ?string $pageDescription = null): void
    {
        try {
            $this->filters = $content->articleFilters();
        } catch (Throwable) {
            $this->filters = [['slug' => 'all', 'label' => 'All Content']];
        }

        if ($this->filters === []) {
            $this->filters = [['slug' => 'all', 'label' => 'All Content']];
        }

        if (filled($category)) {
            $this->activeCategory = (string) $category;
        }

        if (filled($pageTitle)) {
            $this->pageTitle = (string) $pageTitle;
        }

        if (filled($pageDescription)) {
            $this->pageDescription = (string) $pageDescription;
        }

        if (! collect($this->filters)->contains(fn (array $filter): bool => $filter['slug'] === $this->activeCategory)) {
            $this->activeCategory = 'all';
        }

        $this->refreshArticles($content);
    }

    public function loadMore(): void
    {
        $this->page++;
        $this->refreshArticles(app(BlogContentService::class), append: true);
    }

    private function refreshArticles(BlogContentService $content, bool $append = false): void
    {
        $category = $this->activeCategory === 'all' ? null : $this->activeCategory;

        try {
            $payload = $content->posts($category, $this->page, 7);
        } catch (Throwable) {
            $this->articles = $append ? $this->articles : [];
            $this->totalFiltered = count($this->articles);
            $this->hasMore = false;

            return;
        }

        if ($payload['items'] !== []) {
            $mapped = array_map(fn (array $item): array => $this->mapApiPost($item), $payload['items']);

            $this->articles = $append ? array_values([...$this->articles, ...$mapped]) : $mapped;
            $this->totalFiltered = $payload['total'];
            $this->hasMore = $payload['has_more'];

            return;
        }

        $this->articles = $append ? $this->articles : [];
        $this->totalFiltered = count($this->articles);
        $this->hasMore = false;
    }

    /**
     * @param  array<string, mixed>  $item
     * @return array<string, mixed>
     */
    private function mapApiPost(array $item): array
    {
        $category = data_get($item, 'category', []);
        $publishedAt = (string) (data_get($item, 'published_at') ?: data_get($item, 'created_at') ?: '');

        return [
            'slug' => (string) data_get($item, 'slug', ''),
            'category' => (string) data_get($category, 'name', 'Article'),
            'category_slug' => (string) data_get($category, 'slug', 'all'),
            'title' => (string) data_get($item, 'title', 'Untitled article'),
            'excerpt' => (string) (data_get($item, 'excerpt') ?: ''),
            'author' => (string) (data_get($item, 'author.name') ?: data_get($item, 'author', 'Wide Web Blog')),
            'date' => $this->formatDate($publishedAt),
            'read_time' => (string) (data_get($item, 'read_time') ?: '5 min read'),
            'image' => (string) (data_get($item, 'featured_image') ?: data_get($item, 'featured_media.url') ?: ''),
        ];
    }

    /**
     * @return string
     */
    private function formatDate(string $value): string
    {
        if ($value === '') {
            return '';
        }

        try {
            return CarbonImmutable::parse($value)->format('F j, Y');
        } catch (Throwable) {
            return $value;
        }
    }

    public function render()
    {
        $visibleArticles = $this->articles;

        return view('livewire.all-articles-page', [
            'visibleArticles' => $visibleArticles,
            'leadArticle' => $visibleArticles[0] ?? null,
            'spotlightArticle' => $visibleArticles[1] ?? null,
            'gridArticles' => array_slice($visibleArticles, 2),
            'totalFiltered' => $this->totalFiltered,
            'visibleTotal' => count($visibleArticles),
            'hasMore' => $this->hasMore,
        ]);
    }
}
