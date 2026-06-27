<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Services\BlogContentService;
use App\Support\MediaUrl;
use App\Support\PublicApiValue;
use Carbon\CarbonImmutable;
use Livewire\Attributes\Validate;
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

    /** @var array<string, mixed> */
    public array $newsletterSection = [];

    #[Validate('required|email|max:255')]
    public string $newsletterEmail = '';

    public bool $newsletterToastVisible = false;

    public string $newsletterToastType = 'success';

    public string $newsletterToastMessage = 'Thank you for subscribing.';

    public function mount(BlogContentService $content, ?string $category = null, ?string $pageTitle = null, ?string $pageDescription = null): void
    {
        $this->newsletterSection = $this->defaultNewsletterSection();

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

        if ($this->activeCategory === 'all') {
            try {
                $homepage = $content->homepage();
            } catch (Throwable) {
                $homepage = [];
            }

            $resolved = is_array(data_get($homepage, 'data')) ? data_get($homepage, 'data') : $homepage;
            $newsletter = is_array(data_get($resolved, 'newsletter_section')) ? data_get($resolved, 'newsletter_section') : [];

            if (is_array($resolved)) {
                $this->newsletterSection = [
                    'enabled' => true,
                    'title' => $this->stringOrDefault(data_get($newsletter, 'title'), $this->newsletterSection['title']),
                    'description' => $this->stringOrDefault(data_get($newsletter, 'description'), $this->newsletterSection['description']),
                    'placeholder' => $this->newsletterSection['placeholder'],
                    'button' => $this->newsletterSection['button'],
                    'note' => $this->newsletterSection['note'],
                ];
            }
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
            $payload = $content->posts($category, $this->page, 8);
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
     * @return array<string, mixed>
     */
    private function defaultNewsletterSection(): array
    {
        return [
            'enabled' => true,
            'title' => 'Stay Ahead of the Curve',
            'description' => 'Join 25,000+ digital architects. Get one technical, high-signal editorial guide every week directly in your inbox.',
            'placeholder' => 'Enter your email',
            'button' => 'Subscribe',
            'note' => 'High-quality insights. No spam. Unsubscribe anytime.',
        ];
    }

    public function subscribe(BlogContentService $content): void
    {
        $this->validateOnly('newsletterEmail');
        $this->resetErrorBag('newsletterEmail');
        $this->newsletterToastVisible = false;

        try {
            $response = $content->subscribeToNewsletter([
                'email' => $this->newsletterEmail,
                'source' => 'articles',
                'metadata' => [
                    'source:fe',
                    'route:articles',
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

    private function stringOrDefault(mixed $value, string $default): string
    {
        if (! is_string($value)) {
            return $default;
        }

        $trimmed = trim($value);

        return $trimmed !== '' ? $trimmed : $default;
    }

    /**
     * @param  array<string, mixed>  $item
     * @return array<string, mixed>
     */
    private function mapApiPost(array $item): array
    {
        $category = data_get($item, 'category', []);
        $publishedAt = (string) (data_get($item, 'published_at') ?: data_get($item, 'created_at') ?: '');
        $readTime = (string) data_get($item, 'read_time', '');

        if ($readTime === '' && is_numeric(data_get($item, 'reading_time_minutes'))) {
            $readTime = (int) data_get($item, 'reading_time_minutes').' min read';
        }

        return [
            'slug' => (string) data_get($item, 'slug', ''),
            'category' => (string) data_get($category, 'name', 'Article'),
            'category_slug' => (string) data_get($category, 'slug', 'all'),
            'title' => (string) data_get($item, 'title', 'Untitled article'),
            'excerpt' => (string) (data_get($item, 'short_description') ?: data_get($item, 'excerpt') ?: data_get($item, 'description') ?: ''),
            'author' => (string) (data_get($item, 'author.name') ?: data_get($item, 'author', 'Wide Web Blog')),
            'date' => $this->formatDate($publishedAt),
            'read_time' => $readTime !== '' ? $readTime : '5 min read',
            'image' => MediaUrl::normalize((string) (data_get($item, 'featured_image') ?: data_get(PublicApiValue::firstArray(data_get($item, 'featured_media')), 'url') ?: '')),
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
