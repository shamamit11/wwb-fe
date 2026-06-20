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
            ->call('setCategory', 'seo-strategy')
            ->assertSet('activeCategory', 'seo-strategy')
            ->assertSee('Post-Update Recovery: A Step-by-Step Guide')
            ->assertDontSee('Headless CMS Architectures for Content Heavy Blogs')
            ->assertSee('Showing 1 of 1 articles');
    }

    public function test_load_more_reveals_additional_articles_without_a_full_reload(): void
    {
        Livewire::test(AllArticlesPage::class)
            ->assertSee('Showing 7 of 12 articles')
            ->assertDontSee('Securing the Modern Web Stack')
            ->call('loadMore')
            ->assertSee('Securing the Modern Web Stack')
            ->assertSee('Showing 10 of 12 articles');
    }
}
