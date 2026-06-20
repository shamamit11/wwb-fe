<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class ArticleDetailPageTest extends TestCase
{
    public function test_a_known_article_slug_renders_the_detail_page_with_article_specific_seo(): void
    {
        $response = $this->get('/articles/convergence-of-generative-ai-and-design-systems');

        $response->assertOk();
        $response->assertSee('The Convergence of Generative AI and Design Systems');
        $response->assertSee('<title>The Convergence of Generative AI and Design Systems | Wide Web Blog</title>', false);
        $response->assertSee('<link rel="canonical" href="http://fe.test/articles/convergence-of-generative-ai-and-design-systems">', false);
        $response->assertSee('Related Articles');
    }

    public function test_an_unknown_article_slug_returns_404(): void
    {
        $this->get('/articles/not-a-real-article')->assertNotFound();
    }

    public function test_related_articles_include_links_back_into_the_article_detail_route(): void
    {
        $response = $this->get('/articles/convergence-of-generative-ai-and-design-systems');

        $response->assertOk();
        $response->assertSee('/articles/securing-the-modern-web-stack', false);
        $response->assertSee('/articles/building-remote-first-design-teams', false);
    }
}
