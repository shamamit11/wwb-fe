<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class SearchPageTest extends TestCase
{
    public function test_the_header_renders_a_clickable_search_trigger_and_search_route(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('data-search-open', false);
        $response->assertSee('action="http://fe.test/search"', false);
    }

    public function test_the_search_results_page_displays_matching_articles_with_detail_links(): void
    {
        $response = $this->get('/search?q=design');

        $response->assertOk();
        $response->assertSee('Results for “design”', false);
        $response->assertSee('The Convergence of Generative AI and Design Systems');
        $response->assertSee('/articles/convergence-of-generative-ai-and-design-systems', false);
    }

    public function test_the_search_results_page_shows_an_empty_state_when_nothing_matches(): void
    {
        $response = $this->get('/search?q=nonexistentkeyword');

        $response->assertOk();
        $response->assertSee('No articles found');
        $response->assertSee('View All Articles');
    }
}
