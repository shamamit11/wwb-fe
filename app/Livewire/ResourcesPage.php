<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Services\BlogContentService;
use App\Support\ResourceCatalog;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Throwable;

class ResourcesPage extends Component
{
    /** @var array<int, array<string, string>> */
    public array $filters = [];

    /** @var array<int, array<string, string>> */
    public array $sortOptions = [];

    /** @var array<int, array<string, mixed>> */
    public array $resources = [];

    public string $activeCategory = 'all';

    public string $sort = 'newest';

    #[Validate('required|email|max:255')]
    public string $newsletterEmail = '';

    public bool $newsletterToastVisible = false;

    public string $newsletterToastType = 'success';

    public string $newsletterToastMessage = 'Thank you for subscribing.';

    public function mount(): void
    {
        $this->filters = ResourceCatalog::filters();
        $this->sortOptions = ResourceCatalog::sortOptions();
        $this->resources = ResourceCatalog::all();
    }

    public function setCategory(string $slug): void
    {
        $this->activeCategory = $slug;
    }

    public function subscribe(BlogContentService $content): void
    {
        $this->validateOnly('newsletterEmail');
        $this->resetErrorBag('newsletterEmail');
        $this->newsletterToastVisible = false;

        try {
            $response = $content->subscribeToNewsletter([
                'email' => $this->newsletterEmail,
                'source' => 'resources',
                'metadata' => [
                    'source:fe',
                    'route:resources',
                ],
            ]);
        } catch (Throwable) {
            $this->newsletterToastType = 'error';
            $this->newsletterToastMessage = 'We could not subscribe you right now. Please try again shortly.';
            $this->newsletterToastVisible = true;

            return;
        }

        $message = data_get($response, 'data.message');

        $this->newsletterToastType = 'success';
        $this->newsletterToastMessage = is_string($message) && trim($message) !== ''
            ? trim($message)
            : 'Thank you for subscribing.';
        $this->newsletterToastVisible = true;
        $this->newsletterEmail = '';
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function filteredAndSortedResources(): array
    {
        $items = array_filter($this->resources, function (array $resource): bool {
            if ($this->activeCategory === 'all') {
                return $resource['slug'] !== 'free-digital-creator-kit';
            }

            return $resource['category_slug'] === $this->activeCategory;
        });

        $items = array_values($items);

        usort($items, function (array $left, array $right): int {
            return match ($this->sort) {
                'oldest' => strcmp((string) $left['updated_at'], (string) $right['updated_at']),
                'alphabetical' => strcmp((string) $left['title'], (string) $right['title']),
                default => strcmp((string) $right['updated_at'], (string) $left['updated_at']),
            };
        });

        return $items;
    }

    public function render()
    {
        return view('livewire.resources-page', [
            'featured' => ResourceCatalog::all()[0],
            'items' => $this->filteredAndSortedResources(),
        ]);
    }
}
