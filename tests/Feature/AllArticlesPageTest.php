<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Livewire\AllArticlesPage;
use Livewire\Livewire;
use Tests\TestCase;

class AllArticlesPageTest extends TestCase
{
    public function test_the_all_articles_page_renders_with_its_own_seo_metadata(): void
    {
        $response = $this->get('/articles');

        $response->assertOk();
        $response->assertSee('All Articles', false);
        $response->assertSee('<title>All Articles | Wide Web Blog</title>', false);
        $response->assertSee('<link rel="canonical" href="http://fe.test/articles">', false);
        $response->assertSee('/articles/convergence-of-generative-ai-and-design-systems', false);
    }

    public function test_category_filters_update_the_visible_article_set(): void
    {
        Livewire::test(AllArticlesPage::class)
            ->assertSee('The Convergence of Generative AI and Design Systems')
            ->assertSet('activeCategory', 'all');

        $response = $this->get('/articles/category/seo');

        $response->assertOk();
        $response->assertSee('SEO', false);
        $response->assertSee('Post-Update Recovery: A Step-by-Step Guide');
        $response->assertDontSee('Headless CMS Architectures for Content Heavy Blogs');
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
            ->assertSee('Showing 7 of 12 articles')
            ->assertDontSee('Securing the Modern Web Stack')
            ->call('loadMore')
            ->assertSee('Securing the Modern Web Stack')
            ->assertSee('Showing 12 of 12 articles');
    }

    public function test_category_route_preselects_the_matching_filter(): void
    {
        Livewire::test(AllArticlesPage::class, ['category' => 'developer-ai'])
            ->assertSet('activeCategory', 'developer-ai')
            ->assertSee('Headless CMS Architectures for Content Heavy Blogs')
            ->assertDontSee('Post-Update Recovery: A Step-by-Step Guide');
    }
}
