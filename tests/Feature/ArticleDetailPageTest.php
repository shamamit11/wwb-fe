<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Contracts\BlogApiClient;
use Tests\TestCase;

class ArticleDetailPageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config(['services.wideweb_blog.base_url' => 'https://service.widewebblog.com/api/v1']);
        config(['app.url' => 'https://widewebblog.com']);

        $this->app->instance(BlogApiClient::class, new class implements BlogApiClient
        {
            public function get(string $path, array $query = []): array
            {
                if ($path === 'public/posts/how-ai-agent-memory-works') {
                    return [
                        'data' => [
                            'id' => '101',
                            'title' => 'How AI Agent Memory Works',
                            'slug' => 'how-ai-agent-memory-works',
                            'short_description' => 'A practical look at short-term memory, long-term memory, retrieval patterns, and why most agent memory systems fail in production.',
                            'description' => 'A practical guide to memory design for AI agents.',
                            'canonical_url' => 'https://service.widewebblog.com/posts/how-ai-agent-memory-works/',
                            'published_at' => '2026-06-14T10:00:00.000000Z',
                            'updated_at' => '2026-06-20T08:30:00.000000Z',
                            'reading_time_minutes' => 8,
                            'read_time' => '8 min read',
                            'word_count' => 1248,
                            'content' => 'Legacy fallback content that should not be used when HTML is present.',
                            'full_article_html' => '<h1>How AI Agent Memory Works</h1><p>Agent memory is one of the most misunderstood parts of applied AI systems.</p><h2>Short-term memory</h2><p>Short-term memory usually refers to conversation context and recent working state.</p><pre><code class="language-ts">const memories = await memory.search({ query: "user preferences", limit: 5 });</code></pre><p>Most production systems need retrieval, ranking, and write policies to avoid noisy context.</p>',
                            'full_article_delta' => '{"ops":[{"insert":"Agent memory is one of the most misunderstood parts of applied AI systems."}]}',
                            'faq' => '[{"question":"How should I structure agent memory?","answer_markdown":"## Start simple\n\nUse short-term memory first, then add retrieval.\n\n- Keep write rules explicit\n- Rank results before injection"},{"question":"When should I add retrieval?","answer":"Add retrieval when important context no longer fits reliably in the active conversation window."}]',
                            'author' => ['id' => '1', 'name' => 'Amit Sharma'],
                            'featured_image' => '/media/posts/ai-agent-memory-hero.jpg',
                            'featured_media' => [
                                'id' => '55',
                                'ulid' => '01JZ8Y8A6P8D2D7R5Y3V9K1M2N',
                                'original_filename' => 'ai-agent-memory-hero.jpg',
                                'mime_type' => 'image/jpeg',
                                'source_type' => 'upload',
                                'source_url' => 'https://source.example/ai-agent-memory-hero.jpg',
                                'attribution_text' => 'Wide Web Blog',
                                'file_size_bytes' => '120000',
                                'width' => '1600',
                                'height' => '900',
                                'alt_text' => 'Abstract diagram showing how AI agents store and retrieve memory',
                                'caption' => 'AI agent memory systems need retrieval discipline, not just bigger context windows.',
                                'url' => '/media/posts/ai-agent-memory-hero.jpg',
                                'status' => 'ready',
                                'usage_count' => '1',
                                'usage' => [],
                                'created_at' => '2026-06-14T10:00:00.000000Z',
                                'updated_at' => '2026-06-20T08:30:00.000000Z',
                            ],
                            'category' => ['id' => '7', 'name' => 'AI Agents', 'slug' => 'ai-agents'],
                            'tags' => '["Memory","Retrieval"]',
                            'seo' => [
                                'id' => 'seo-1',
                                'seoable_type' => 'post',
                                'seoable_id' => '101',
                                'meta_title' => 'How AI Agent Memory Works',
                                'meta_description' => 'Understand short-term memory, long-term memory, and retrieval patterns for AI agents in production.',
                                'canonical_url' => 'https://service.widewebblog.com/posts/how-ai-agent-memory-works/',
                                'robots_index' => true,
                                'robots_follow' => true,
                                'og_title' => 'How AI Agent Memory Works',
                                'og_description' => 'A practical guide to memory design for AI agents.',
                                'og_image_media' => [
                                    'id' => '55',
                                    'ulid' => '01JZ8Y8A6P8D2D7R5Y3V9K1M2N',
                                    'original_filename' => 'ai-agent-memory-hero.jpg',
                                    'mime_type' => 'image/jpeg',
                                    'alt_text' => 'Abstract diagram showing how AI agents store and retrieve memory',
                                    'caption' => 'AI agent memory systems need retrieval discipline, not just bigger context windows.',
                                    'alt_text' => 'Abstract diagram showing how AI agents store and retrieve memory',
                                    'url' => '/media/posts/ai-agent-memory-hero.jpg',
                                ],
                                'schema_type' => 'TechArticle',
                                'schema_payload' => [],
                                'focus_keyword' => 'agent memory',
                                'created_at' => '2026-06-14T10:00:00.000000Z',
                                'updated_at' => '2026-06-20T08:30:00.000000Z',
                            ],
                            'related_posts' => [
                                [
                                    'id' => '102',
                                    'title' => 'Agent Context Windows Explained',
                                    'slug' => 'agent-context-windows-explained',
                                    'short_description' => 'Why larger context windows help less than most teams expect.',
                                    'canonical_url' => 'https://service.widewebblog.com/posts/agent-context-windows-explained/',
                                    'published_at' => '2026-06-13T09:00:00.000000Z',
                                    'updated_at' => '2026-06-18T10:15:00.000000Z',
                                    'reading_time_minutes' => 5,
                                    'read_time' => '5 min read',
                                    'featured_image' => '/media/posts/context-windows.jpg',
                                    'featured_media' => [
                                        'id' => '56',
                                        'ulid' => '01JZ8YB8M2X7F3P4Q6S8T1U2V3',
                                        'original_filename' => 'context-windows.jpg',
                                        'mime_type' => 'image/jpeg',
                                        'source_type' => 'upload',
                                        'source_url' => 'https://source.example/context-windows.jpg',
                                        'attribution_text' => 'Wide Web Blog',
                                        'file_size_bytes' => '110000',
                                        'width' => '1600',
                                        'height' => '900',
                                        'alt_text' => 'Visual explaining LLM context windows',
                                        'caption' => null,
                                        'url' => '/media/posts/context-windows.jpg',
                                        'status' => 'ready',
                                        'usage_count' => '1',
                                        'usage' => [],
                                        'created_at' => '2026-06-13T09:00:00.000000Z',
                                        'updated_at' => '2026-06-18T10:15:00.000000Z',
                                    ],
                                    'author' => [
                                        'id' => '1',
                                        'name' => 'Amit Sharma',
                                    ],
                                    'category' => [
                                        'id' => '7',
                                        'name' => 'AI Agents',
                                        'slug' => 'ai-agents',
                                    ],
                                    'tags' => '',
                                    'seo' => [],
                                ],
                            ],
                            'schema' => [
                                '@context' => 'https://schema.org',
                                '@type' => 'TechArticle',
                                'headline' => 'How AI Agent Memory Works',
                                'url' => 'https://service.widewebblog.com/posts/how-ai-agent-memory-works/',
                                'mainEntityOfPage' => 'https://service.widewebblog.com/posts/how-ai-agent-memory-works/',
                                'publisher' => [
                                    '@type' => 'Organization',
                                    'url' => 'https://service.widewebblog.com/',
                                ],
                            ],
                        ],
                    ];
                }

                return ['data' => null];
            }

            public function post(string $path, array $body = []): array
            {
                return ['data' => []];
            }
        });
    }

    public function test_a_known_article_slug_renders_the_detail_page_with_article_specific_seo(): void
    {
        $response = $this->get('/articles/how-ai-agent-memory-works');

        $response->assertOk();
        $response->assertSee('How AI Agent Memory Works');
        $response->assertSee('<title>How AI Agent Memory Works</title>', false);
        $response->assertSee('<link rel="canonical" href="https://widewebblog.com/posts/how-ai-agent-memory-works/">', false);
        $response->assertSee('<meta property="og:url" content="https://widewebblog.com/posts/how-ai-agent-memory-works/">', false);
        $response->assertSee('<meta property="og:image" content="https://media.widewebblog.com/media/posts/ai-agent-memory-hero.jpg">', false);
        $response->assertSee('Amit Sharma');
        $response->assertSee('Tags');
        $response->assertSee('Memory');
        $response->assertSee('Retrieval');
        $response->assertSee('A practical look at short-term memory, long-term memory, retrieval patterns, and why most agent memory systems fail in production.');
        $response->assertSee('Short-term memory');
        $response->assertSee('language-ts', false);
        $response->assertSee('const memories = await memory.search', false);
        $response->assertDontSee('<div class="article-richtext mt-12 max-w-3xl"><h1>How AI Agent Memory Works</h1>', false);
        $response->assertSee('src="https://media.widewebblog.com/media/posts/ai-agent-memory-hero.jpg"', false);
        $response->assertSee('"url": "https://widewebblog.com/posts/how-ai-agent-memory-works/"', false);
        $response->assertSee('"mainEntityOfPage": "https://widewebblog.com/posts/how-ai-agent-memory-works/"', false);
        $response->assertSee('"url": "https://widewebblog.com/"', false);
        $response->assertDontSee('https://service.widewebblog.com/posts/how-ai-agent-memory-works/', false);
        $response->assertSee('Frequently Asked Questions');
        $response->assertSee('<details class="article-faq', false);
        $response->assertSee('How should I structure agent memory?');
        $response->assertSee('<h3 class="article-faq__question">How should I structure agent memory?</h3>', false);
        $response->assertSee('<h2>Start simple</h2>', false);
        $response->assertDontSee('## Start simple', false);
        $response->assertSee('Related Articles');
        $response->assertSee('Agent Context Windows Explained');
        $response->assertSee('/articles/agent-context-windows-explained', false);
    }

    public function test_an_unknown_article_slug_returns_404(): void
    {
        $this->get('/articles/not-a-real-article')->assertNotFound();
    }

    public function test_related_articles_include_links_back_into_the_article_detail_route(): void
    {
        $response = $this->get('/articles/how-ai-agent-memory-works');

        $response->assertOk();
        $response->assertSee('/articles/agent-context-windows-explained', false);
    }
}
