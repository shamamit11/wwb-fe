<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Services\BlogContentService;
use App\Support\MediaUrl;
use App\Support\PublicApiValue;
use Throwable;
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

        try {
            $items = app(BlogContentService::class)->search($this->query);
        } catch (Throwable) {
            $items = [];
        }

        $this->results = array_map(
            static fn (array $item): array => [
                'slug' => (string) data_get($item, 'slug', ''),
                'title' => (string) data_get($item, 'title', 'Untitled article'),
                'excerpt' => (string) (data_get($item, 'short_description') ?: data_get($item, 'excerpt') ?: data_get($item, 'description') ?: ''),
                'image' => MediaUrl::normalize((string) (data_get($item, 'featured_image') ?: data_get(PublicApiValue::firstArray(data_get($item, 'featured_media')), 'url') ?: '')),
                'category' => (string) data_get($item, 'category.name', 'Article'),
                'author' => (string) data_get($item, 'author.name', 'Wide Web Blog'),
                'read_time' => (string) (data_get($item, 'read_time') ?: (is_numeric(data_get($item, 'reading_time_minutes')) ? ((int) data_get($item, 'reading_time_minutes')).' min read' : '5 min read')),
            ],
            $items,
        );
    }

    public function render()
    {
        return view('livewire.search-results-page', [
            'resultCount' => count($this->results),
        ]);
    }
}
