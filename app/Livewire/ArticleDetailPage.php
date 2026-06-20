<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Support\ArticleCatalog;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

class ArticleDetailPage extends Component
{
    /** @var array<string, mixed> */
    public array $article = [];

    /** @var array<int, array<string, mixed>> */
    public array $relatedArticles = [];

    public function mount(string $slug): void
    {
        $article = ArticleCatalog::find($slug);

        if ($article === null) {
            throw (new ModelNotFoundException())->setModel('Article', [$slug]);
        }

        $this->article = $article;
        $this->relatedArticles = ArticleCatalog::related($article);
    }

    public function render()
    {
        return view('livewire.article-detail-page');
    }
}
