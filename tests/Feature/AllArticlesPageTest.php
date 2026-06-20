<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Contracts\BlogApiClient;
use App\Livewire\AllArticlesPage;
use Livewire\Livewire;
use Tests\TestCase;

class AllArticlesPageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config(['services.wideweb_blog.base_url' => 'https://service.widewebblog.com/api/v1']);

        $this->app->instance(BlogApiClient::class, new class implements BlogApiClient
        {
            public function get(string $path, array $query = []): array
            {
                if ($path === 'public/categories') {
                    return [
                        'data' => [
                            ['name' => 'SEO', 'slug' => 'seo'],
                            ['name' => 'Content Marketing', 'slug' => 'content-marketing'],
                            ['name' => 'Developer AI', 'slug' => 'developer-ai'],
                        ],
                    ];
                }

                if ($path === 'public/categories/seo') {
                    return [
                        'data' => [
                            'name' => 'SEO',
                            'slug' => 'seo',
                            'description' => 'Browse SEO articles from Wide Web Blog.',
                        ],
                    ];
                }

                if ($path === 'public/categories/content-marketing') {
                    return [
                        'data' => [
                            'name' => 'Content Marketing',
                            'slug' => 'content-marketing',
                            'description' => 'Browse content marketing articles from Wide Web Blog.',
                        ],
                    ];
                }

                if ($path === 'public/posts') {
                    $category = $query['category'] ?? null;
                    $page = (int) ($query['page'] ?? 1);
                    $items = collect($this->posts())
                        ->when($category, fn ($collection) => $collection->where('category.slug', $category))
                        ->values();

                    $perPage = (int) ($query['per_page'] ?? 7);
                    $offset = max(0, ($page - 1) * $perPage);
                    $slice = $items->slice($offset, $perPage)->values()->all();
                    $total = $items->count();
                    $lastPage = max(1, (int) ceil($total / $perPage));

                    return [
                        'data' => $slice,
                        'meta' => [
                            'total' => $total,
                            'current_page' => $page,
                            'per_page' => $perPage,
                            'last_page' => $lastPage,
                        ],
                    ];
                }

                return ['data' => []];
            }

            public function post(string $path, array $body = []): array
            {
                return ['data' => []];
            }

            /**
             * @return array<int, array<string, mixed>>
             */
            private function posts(): array
            {
                return [
                    $this->postItem('service-design-systems', 'Service Design Systems', 'Developer AI', 'developer-ai'),
                    $this->postItem('seo-recovery-guide', 'SEO Recovery Guide', 'SEO', 'seo'),
                    $this->postItem('content-marketing-playbook', 'Content Marketing Playbook', 'Content Marketing', 'content-marketing'),
                    $this->postItem('developer-ai-systems', 'Developer AI Systems', 'Developer AI', 'developer-ai'),
                    $this->postItem('technical-seo-audits', 'Technical SEO Audits', 'SEO', 'seo'),
                    $this->postItem('editorial-automation', 'Editorial Automation', 'Content Marketing', 'content-marketing'),
                    $this->postItem('llm-tooling-stack', 'LLM Tooling Stack', 'Developer AI', 'developer-ai'),
                    $this->postItem('search-intent-briefs', 'Search Intent Briefs', 'SEO', 'seo'),
                ];
            }

            /**
             * @return array<string, mixed>
             */
            private function postItem(string $slug, string $title, string $categoryName, string $categorySlug): array
            {
                return [
                    'slug' => $slug,
                    'title' => $title,
                    'excerpt' => 'Summary for '.$title,
                    'published_at' => '2026-06-14T10:00:00.000000Z',
                    'read_time' => '5 min read',
                    'featured_image' => '/media/'.$slug.'.jpg',
                    'author' => ['name' => 'Author Name'],
                    'category' => [
                        'name' => $categoryName,
                        'slug' => $categorySlug,
                    ],
                ];
            }
        });
    }

    public function test_the_all_articles_page_renders_with_its_own_seo_metadata(): void
    {
        $response = $this->get('/articles');

        $response->assertOk();
        $response->assertSee('All Articles', false);
        $response->assertDontSee('Last updated:', false);
        $response->assertSee('<title>All Articles | Wide Web Blog</title>', false);
        $response->assertSee('<link rel="canonical" href="http://fe.test/articles">', false);
        $response->assertSee('/articles/service-design-systems', false);
        $response->assertSee('src="https://media.widewebblog.com/media/service-design-systems.jpg"', false);
    }

    public function test_category_filters_update_the_visible_article_set(): void
    {
        Livewire::test(AllArticlesPage::class)
            ->assertSee('Service Design Systems')
            ->assertSet('activeCategory', 'all');

        $response = $this->get('/articles/category/seo');

        $response->assertOk();
        $response->assertSee('SEO', false);
        $response->assertSee('SEO Recovery Guide');
        $response->assertDontSee('Developer AI Systems');
        $response->assertSee('<link rel="canonical" href="http://fe.test/articles/category/seo">', false);
    }

    public function test_category_archive_uses_category_specific_heading_and_seo_title(): void
    {
        $response = $this->get('/articles/category/content-marketing');

        $response->assertOk();
        $response->assertSee('Content Marketing', false);
        $response->assertSee('<title>Content Marketing | Wide Web Blog</title>', false);
        $response->assertSee('<link rel="canonical" href="http://fe.test/articles/category/content-marketing">', false);
    }

    public function test_load_more_reveals_additional_articles_without_a_full_reload(): void
    {
        Livewire::test(AllArticlesPage::class)
            ->assertSee('Showing 7 of 8 articles')
            ->assertDontSee('Search Intent Briefs')
            ->call('loadMore')
            ->assertSee('Search Intent Briefs')
            ->assertSee('Showing 8 of 8 articles');
    }

    public function test_category_route_preselects_the_matching_filter(): void
    {
        Livewire::test(AllArticlesPage::class, ['category' => 'developer-ai'])
            ->assertSet('activeCategory', 'developer-ai')
            ->assertSee('Developer AI Systems')
            ->assertDontSee('SEO Recovery Guide');
    }
}
