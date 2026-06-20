<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Support\ArticleCatalog;
use Livewire\Attributes\Url;
use Livewire\Component;

class SearchResultsPage extends Component
{
    #[Url(as: 'q')]
    public string $query = '';

    /**
     * @var array<int, array<string, mixed>>
     */
    public array $results = [];

    public function mount(?string $q = null): void
    {
        if ($q !== null) {
            $this->query = $q;
        }

        $this->results = ArticleCatalog::search($this->query);
    }

    public function render()
    {
        return view('livewire.search-results-page', [
            'resultCount' => count($this->results),
        ]);
    }
}
