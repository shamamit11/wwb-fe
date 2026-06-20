<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Support\ArticleCatalog;
use Livewire\Component;

class AllArticlesPage extends Component
{
    /** @var array<int, array<string, string>> */
    public array $filters = [];

    /** @var array<int, array<string, mixed>> */
    public array $articles = [];

    public string $activeCategory = 'all';

    public int $visibleCount = 7;

    public string $lastUpdated = 'May 2024';

    public function mount(): void
    {
        $this->filters = ArticleCatalog::filters();
        $this->articles = array_values(array_filter(
            ArticleCatalog::all(),
            fn (array $article): bool => ! empty($article['excerpt']),
        ));
    }

    public function setCategory(string $slug): void
    {
        $this->activeCategory = $slug;
        $this->visibleCount = 7;
    }

    public function loadMore(): void
    {
        $this->visibleCount += 3;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function filteredArticles(): array
    {
        if ($this->activeCategory === 'all') {
            return $this->articles;
        }

        return array_values(array_filter(
            $this->articles,
            fn (array $article): bool => $article['category_slug'] === $this->activeCategory,
        ));
    }

    public function render()
    {
        $filteredArticles = $this->filteredArticles();
        $visibleArticles = array_slice($filteredArticles, 0, $this->visibleCount);

        return view('livewire.all-articles-page', [
            'visibleArticles' => $visibleArticles,
            'leadArticle' => $visibleArticles[0] ?? null,
            'spotlightArticle' => $visibleArticles[1] ?? null,
            'gridArticles' => array_slice($visibleArticles, 2),
            'totalFiltered' => count($filteredArticles),
            'visibleTotal' => count($visibleArticles),
            'hasMore' => count($filteredArticles) > count($visibleArticles),
        ]);
    }
}
