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

        $this->app->instance(BlogApiClient::class, new class implements BlogApiClient
        {
            public function get(string $path, array $query = []): array
            {
                if ($path === 'public/posts/how-ai-agent-memory-works') {
                    return [
                        'data' => [
                            'id' => 101,
                            'title' => 'How AI Agent Memory Works',
                            'slug' => 'how-ai-agent-memory-works',
                            'excerpt' => 'A practical look at short-term memory, long-term memory, retrieval patterns, and why most agent memory systems fail in production.',
                            'canonical_url' => 'https://widewebblog.test/posts/how-ai-agent-memory-works/',
                            'published_at' => '2026-06-14T10:00:00.000000Z',
                            'updated_at' => '2026-06-20T08:30:00.000000Z',
                            'reading_time_minutes' => 8,
                            'read_time' => '8 min read',
                            'word_count' => 1248,
                            'content' => "# How AI Agent Memory Works\n\nAgent memory is one of the most misunderstood parts of applied AI systems.\n\nThis article covers **bold text**, *italic text*, a [link to the docs](https://example.com/docs), lists, quotes, and code blocks.\n\n## Short-term memory\n\nShort-term memory usually refers to conversation context and recent working state.\n\n## Markdown examples\n\n### Bold\n\nUse **bold text** when you need emphasis.\n\n### Italic\n\nUse *italic text* for lighter emphasis or terminology.\n\n### Link\n\nRead the [memory architecture guide](https://example.com/memory-architecture) for more detail.\n\n### List\n\n- Store recent context separately from durable facts\n- Rank retrieved memories before injecting them\n- Expire stale memories when they stop being useful\n\n### Quote\n\n> Good memory systems reduce noise before they add context.\n\n### Code\n\nInline code example: `memory.write()`\n\n```ts\nconst memories = await memory.search({\n  query: \"user preferences\",\n  limit: 5,\n});\n```\n\n## Long-term memory\n\nLong-term memory stores durable user facts, decisions, and reusable task context.\n\n## Retrieval patterns\n\nMost production systems need retrieval, ranking, and write policies to avoid noisy context.",
                            'content_markdown' => "# How AI Agent Memory Works\n\nAgent memory is one of the most misunderstood parts of applied AI systems.\n\nThis article covers **bold text**, *italic text*, a [link to the docs](https://example.com/docs), lists, quotes, and code blocks.\n\n## Short-term memory\n\nShort-term memory usually refers to conversation context and recent working state.\n\n## Markdown examples\n\n### Bold\n\nUse **bold text** when you need emphasis.\n\n### Italic\n\nUse *italic text* for lighter emphasis or terminology.\n\n### Link\n\nRead the [memory architecture guide](https://example.com/memory-architecture) for more detail.\n\n### List\n\n- Store recent context separately from durable facts\n- Rank retrieved memories before injecting them\n- Expire stale memories when they stop being useful\n\n### Quote\n\n> Good memory systems reduce noise before they add context.\n\n### Code\n\nInline code example: `memory.write()`\n\n```ts\nconst memories = await memory.search({\n  query: \"user preferences\",\n  limit: 5,\n});\n```\n\n## Long-term memory\n\nLong-term memory stores durable user facts, decisions, and reusable task context.\n\n## Retrieval patterns\n\nMost production systems need retrieval, ranking, and write policies to avoid noisy context.",
                            'author' => ['id' => 1, 'name' => 'Amit Sharma'],
                            'featured_image' => '/media/posts/ai-agent-memory-hero.jpg',
                            'featured_media' => [
                                'id' => 55,
                                'ulid' => '01JZ8Y8A6P8D2D7R5Y3V9K1M2N',
                                'mime_type' => 'image/jpeg',
                                'width' => 1600,
                                'height' => 900,
                                'alt_text' => 'Abstract diagram showing how AI agents store and retrieve memory',
                                'caption' => 'AI agent memory systems need retrieval discipline, not just bigger context windows.',
                                'url' => '/media/posts/ai-agent-memory-hero.jpg',
                            ],
                            'category' => ['id' => 7, 'name' => 'AI Agents', 'slug' => 'ai-agents'],
                            'template' => [
                                'id' => 3,
                                'name' => 'Tutorial',
                                'slug' => 'tutorial',
                            ],
                            'tags' => [
                                ['id' => 11, 'name' => 'Memory', 'slug' => 'memory'],
                                ['id' => 12, 'name' => 'Retrieval', 'slug' => 'retrieval'],
                            ],
                            'seo' => [
                                'meta_title' => 'How AI Agent Memory Works',
                                'meta_description' => 'Understand short-term memory, long-term memory, and retrieval patterns for AI agents in production.',
                                'canonical_url' => 'https://widewebblog.test/posts/how-ai-agent-memory-works/',
                                'robots_index' => true,
                                'robots_follow' => true,
                                'og_title' => 'How AI Agent Memory Works',
                                'og_description' => 'A practical guide to memory design for AI agents.',
                                'og_image' => [
                                    'id' => 55,
                                    'ulid' => '01JZ8Y8A6P8D2D7R5Y3V9K1M2N',
                                    'mime_type' => 'image/jpeg',
                                    'width' => 1600,
                                    'height' => 900,
                                    'alt_text' => 'Abstract diagram showing how AI agents store and retrieve memory',
                                    'caption' => 'AI agent memory systems need retrieval discipline, not just bigger context windows.',
                                    'url' => '/media/posts/ai-agent-memory-hero.jpg',
                                ],
                                'schema_type' => 'TechArticle',
                            ],
                            'related_posts' => [
                                [
                                    'id' => 102,
                                    'title' => 'Agent Context Windows Explained',
                                    'slug' => 'agent-context-windows-explained',
                                    'excerpt' => 'Why larger context windows help less than most teams expect.',
                                    'canonical_url' => 'https://widewebblog.test/posts/agent-context-windows-explained/',
                                    'published_at' => '2026-06-13T09:00:00.000000Z',
                                    'updated_at' => '2026-06-18T10:15:00.000000Z',
                                    'reading_time_minutes' => 5,
                                    'read_time' => '5 min read',
                                    'featured_image' => '/media/posts/context-windows.jpg',
                                    'featured_media' => [
                                        'id' => 56,
                                        'ulid' => '01JZ8YB8M2X7F3P4Q6S8T1U2V3',
                                        'mime_type' => 'image/jpeg',
                                        'width' => 1600,
                                        'height' => 900,
                                        'alt_text' => 'Visual explaining LLM context windows',
                                        'caption' => null,
                                        'url' => '/media/posts/context-windows.jpg',
                                    ],
                                    'author' => [
                                        'id' => 1,
                                        'name' => 'Amit Sharma',
                                    ],
                                    'category' => [
                                        'id' => 7,
                                        'name' => 'AI Agents',
                                        'slug' => 'ai-agents',
                                    ],
                                    'tags' => [],
                                    'seo' => null,
                                ],
                            ],
                            'schema' => [
                                '@context' => 'https://schema.org',
                                '@type' => 'TechArticle',
                                'headline' => 'How AI Agent Memory Works',
                            ],
                            'blocks' => [
                                [
                                    'block_type' => 'heading',
                                    'content_markdown' => '## ## Structured Overview',
                                    'settings' => ['level' => 2],
                                ],
                                [
                                    'block_type' => 'paragraph',
                                    'content_markdown' => "This section comes from structured blocks.\n\n- First point\n- Second point",
                                ],
                                [
                                    'block_type' => 'callout',
                                    'content_markdown' => 'Use a human review step before publishing.',
                                    'settings' => [
                                        'title' => 'Editorial Guardrail',
                                        'tone' => 'warning',
                                    ],
                                ],
                                [
                                    'block_type' => 'code',
                                    'content_markdown' => "```ts\nmemory.write({ scope: 'session' })\n```",
                                    'settings' => [
                                        'language' => 'ts',
                                        'label' => 'Example',
                                    ],
                                ],
                                [
                                    'block_type' => 'faq',
                                    'title' => 'Frequently Asked Questions',
                                    'settings' => ['items' => [
                                        [
                                            'question' => 'How should I structure agent memory?',
                                            'answer_markdown' => "## Start simple\n\nUse short-term memory first, then add retrieval.\n\n- Keep write rules explicit\n- Rank results before injection",
                                        ],
                                        [
                                            'question' => 'When should I add retrieval?',
                                            'answer' => 'Add retrieval when important context no longer fits reliably in the active conversation window.',
                                        ],
                                    ]],
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
        $response->assertSee('<link rel="canonical" href="https://widewebblog.test/posts/how-ai-agent-memory-works/">', false);
        $response->assertSee('<meta property="og:image" content="https://media.widewebblog.com/media/posts/ai-agent-memory-hero.jpg">', false);
        $response->assertSee('Amit Sharma');
        $response->assertSee('Tutorial');
        $response->assertSee('Tags');
        $response->assertSee('#memory');
        $response->assertSee('#retrieval');
        $response->assertSee('A practical look at short-term memory, long-term memory, retrieval patterns, and why most agent memory systems fail in production.');
        $response->assertSee('Structured Overview');
        $response->assertDontSee('## ## Structured Overview', false);
        $response->assertSee('This section comes from structured blocks.');
        $response->assertSee('Editorial Guardrail');
        $response->assertSee('memory.write({ scope: &#039;session&#039; })', false);
        $response->assertSee('<div class="article-block article-block--callout article-block--callout-warning">', false);
        $response->assertSee('<div class="article-block article-block--code">', false);
        $response->assertSee('src="https://media.widewebblog.com/media/posts/ai-agent-memory-hero.jpg"', false);
        $response->assertSee('Frequently Asked Questions');
        $response->assertSee('<details class="article-faq', false);
        $response->assertSee('How should I structure agent memory?');
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
