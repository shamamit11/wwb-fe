<?php

declare(strict_types=1);

namespace App\Support;

class ArticleCatalog
{
    /**
     * @return array<int, array{slug: string, label: string}>
     */
    public static function filters(): array
    {
        return [
            ['slug' => 'all', 'label' => 'All Content'],
            ['slug' => 'ai-tools', 'label' => 'AI Tools'],
            ['slug' => 'ai-agents', 'label' => 'AI Agents'],
            ['slug' => 'seo', 'label' => 'SEO'],
            ['slug' => 'content-marketing', 'label' => 'Content Marketing'],
            ['slug' => 'productivity-automation', 'label' => 'Productivity & Automation'],
            ['slug' => 'developer-ai', 'label' => 'Developer AI'],
            ['slug' => 'news-trends', 'label' => 'News & Trends'],
        ];
    }

    public static function filterLabel(string $slug): ?string
    {
        foreach (self::filters() as $filter) {
            if ($filter['slug'] === $slug) {
                return $filter['label'];
            }
        }

        return null;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function all(): array
    {
        return [
            [
                'slug' => 'convergence-of-generative-ai-and-design-systems',
                'category' => 'AI Tools',
                'category_slug' => 'ai-tools',
                'title' => 'The Convergence of Generative AI and Design Systems',
                'excerpt' => 'How AI-assisted design systems are moving teams from static component libraries to adaptive content and interface engines.',
                'author' => 'Marcus Thorne',
                'author_role' => 'Design Lead at Webcore',
                'date' => 'October 24, 2024',
                'read_time' => '12 min read',
                'image' => 'https://images.unsplash.com/photo-1642427749670-f20e2e76ed8c?auto=format&fit=crop&w=1400&q=80',
                'summary' => 'An editorial deep dive into how generative AI is changing the way teams build, govern, and scale design systems.',
                'intro' => [
                    'As we stand at the precipice of a new era in digital interface construction, the role of the designer is shifting from a pixel-pusher to a system-curator.',
                    'The introduction of Generative AI into our workflows is not just about speed, it is about a fundamental transformation in how we define consistency at scale.',
                ],
                'caption' => 'Visualizing the neural connection in a modern component-based design system.',
                'sections' => [
                    [
                        'heading' => 'The Systematic Shift',
                        'body' => [
                            'For years, design systems were static repositories of colors, fonts, and buttons. They were hard-coded truths that required manual maintenance. Today, with LLMs capable of understanding design tokens, these systems are becoming living organisms that can self-heal, adapt to accessibility needs in real-time, and generate entire templates from simple natural language prompts.',
                        ],
                    ],
                    [
                        'quote' => 'The design system of 2025 will not be a library of components; it will be a library of intents and constraints.',
                    ],
                    [
                        'heading' => 'Breaking the Grid',
                        'body' => [
                            'Traditional layouts are constrained by the rigid 12-column grid. However, generative engines allow us to think in fluid spaces. By defining high-level styling tokens, much like we already see in the emergence of Tailwind-powered design environments, we can create interfaces that react not just to screen size, but to user context and emotional state.',
                        ],
                    ],
                    [
                        'cta' => [
                            'eyebrow' => 'Free Resource',
                            'title' => 'Free Digital Creator Kit',
                            'copy' => 'Get our exclusive pack of 5 UI components, style guides, and design tokens to kickstart your next project.',
                            'placeholder' => 'Enter your email',
                            'button' => 'Download Now',
                        ],
                    ],
                    [
                        'body' => [
                            'Implementing these changes requires a cultural shift within product teams. Engineering and design must share a single source of truth, one that is semantic and readable by both humans and machines. This is where the true power of the Wide Web lies, in the interoperability of our creative systems.',
                        ],
                    ],
                ],
                'tags' => ['#AI', '#DesignSystems', '#FutureOfWork', '#UXDesign'],
                'trending_topics' => [
                    'Micro-Interactions in VR',
                    'The Case for Dark Mode',
                    'Clean Code vs Fast Shipping',
                ],
                'related_slugs' => [
                    'securing-the-modern-web-stack',
                    'building-remote-first-design-teams',
                    'why-your-project-needs-a-design-token-strategy',
                ],
            ],
            [
                'slug' => 'future-of-generative-models-in-enterprise-seo',
                'category' => 'AI Tools',
                'category_slug' => 'ai-tools',
                'title' => 'The Future of Generative Models in Enterprise SEO',
                'excerpt' => 'How large language models are reshaping the way we think about content density and keyword architecture for modern search surfaces.',
                'author' => 'Sarah Jenkins',
                'author_role' => 'Editorial Strategy Lead',
                'date' => 'May 12, 2024',
                'read_time' => '8 min read',
                'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'A forward look at enterprise SEO systems where LLMs help shape research, structure, and entity coverage.',
            ],
            [
                'slug' => 'mastering-the-art-of-editorial-consistency',
                'category' => 'Content Marketing',
                'category_slug' => 'content-marketing',
                'title' => 'Mastering the Art of Editorial Consistency',
                'excerpt' => 'Developing a brand voice that resonates across diverse digital platforms without flattening your point of view.',
                'author' => 'David Cohen',
                'author_role' => 'Content Operations Editor',
                'date' => 'May 10, 2024',
                'read_time' => '5 min read',
                'image' => 'https://images.unsplash.com/photo-1516321497487-e288fb19713f?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'A practical framework for building repeatable voice and publishing standards.',
            ],
            [
                'slug' => 'post-update-recovery-a-step-by-step-guide',
                'category' => 'SEO',
                'category_slug' => 'seo',
                'title' => 'Post-Update Recovery: A Step-by-Step Guide',
                'excerpt' => 'Navigating the aftermath of the latest search algorithm core updates with data-driven diagnostics and calmer prioritization.',
                'author' => 'Marcus Thorne',
                'author_role' => 'Search Systems Editor',
                'date' => 'May 8, 2024',
                'read_time' => '12 min read',
                'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'A disciplined playbook for identifying update damage and planning a measured recovery.',
            ],
            [
                'slug' => 'headless-cms-architectures-for-content-heavy-blogs',
                'category' => 'Developer AI',
                'category_slug' => 'developer-ai',
                'title' => 'Headless CMS Architectures for Content Heavy Blogs',
                'excerpt' => 'Why decoupling your front-end from your content store is the ultimate performance play for editorial scale.',
                'author' => 'Leo Vang',
                'author_role' => 'Frontend Systems Engineer',
                'date' => 'May 6, 2024',
                'read_time' => '10 min read',
                'image' => 'https://images.unsplash.com/photo-1515879218367-8466d910aaa4?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Architectural tradeoffs for teams trying to scale content throughput and performance together.',
            ],
            [
                'slug' => 'how-streamline-scaled-their-content-to-1m-visitors',
                'category' => 'Productivity & Automation',
                'category_slug' => 'productivity-automation',
                'title' => 'How \'Streamline\' Scaled Their Content to 1M Visitors',
                'excerpt' => 'A deep dive into the operational shifts and content strategies that fueled exponential editorial growth.',
                'author' => 'Sarah Jenkins',
                'author_role' => 'Growth Research Editor',
                'date' => 'May 5, 2024',
                'read_time' => '15 min read',
                'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'What changed operationally when a content team moved from sporadic wins to systematic growth.',
            ],
            [
                'slug' => 'the-decentralization-of-online-publishing',
                'category' => 'News & Trends',
                'category_slug' => 'news-trends',
                'title' => 'The Decentralization of Online Publishing',
                'excerpt' => 'Exploring how independent writers are reclaiming ownership through newsletters, communities, and platform-light publishing.',
                'author' => 'David Cohen',
                'author_role' => 'Publishing Trends Writer',
                'date' => 'May 3, 2024',
                'read_time' => '6 min read',
                'image' => 'https://images.unsplash.com/photo-1516280440614-37939bbacd81?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Why audience ownership and direct distribution are becoming core editorial advantages.',
            ],
            [
                'slug' => 'planning-your-2025-content-calendar-today',
                'category' => 'Content Marketing',
                'category_slug' => 'content-marketing',
                'title' => 'Planning Your 2025 Content Calendar Today',
                'excerpt' => 'The long-game approach to topic clustering and seasonal relevance for authority sites that publish with intent.',
                'author' => 'Marcus Thorne',
                'author_role' => 'Editorial Planning Lead',
                'date' => 'May 1, 2024',
                'read_time' => '9 min read',
                'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'How to design an editorial roadmap with enough structure to scale and enough flexibility to react.',
            ],
            [
                'slug' => 'building-small-ai-utilities-that-actually-stick',
                'category' => 'AI Agents',
                'category_slug' => 'ai-agents',
                'title' => 'Building Small AI Utilities That Actually Stick',
                'excerpt' => 'A practical framework for creating narrowly useful AI tools that solve one problem well and compound editorial leverage.',
                'author' => 'Priya Solanki',
                'author_role' => 'Product Systems Writer',
                'date' => 'April 28, 2024',
                'read_time' => '7 min read',
                'image' => 'https://images.unsplash.com/photo-1484417894907-623942c8ee29?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'A blueprint for small, sticky utilities that fit naturally into publishing workflows.',
            ],
            [
                'slug' => 'securing-the-modern-web-stack',
                'category' => 'Developer AI',
                'category_slug' => 'developer-ai',
                'title' => 'Securing the Modern Web Stack',
                'excerpt' => 'The security layers modern editorial products need when content tooling, APIs, and teams scale together.',
                'author' => 'Jade Lin',
                'author_role' => 'Infrastructure Editor',
                'date' => 'April 20, 2024',
                'read_time' => '8 min read',
                'image' => 'https://images.unsplash.com/photo-1510511459019-5dda7724fd87?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'A field guide to hardening publishing stacks without slowing teams down.',
            ],
            [
                'slug' => 'building-remote-first-design-teams',
                'category' => 'Productivity & Automation',
                'category_slug' => 'productivity-automation',
                'title' => 'Building Remote-First Design Teams',
                'excerpt' => 'Systems, rituals, and documentation patterns that let distributed design teams move with confidence.',
                'author' => 'Alyssa Moore',
                'author_role' => 'Design Operations Lead',
                'date' => 'April 18, 2024',
                'read_time' => '6 min read',
                'image' => 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'The practices that create continuity across distributed product teams.',
            ],
            [
                'slug' => 'why-your-project-needs-a-design-token-strategy',
                'category' => 'AI Tools',
                'category_slug' => 'ai-tools',
                'title' => 'Why Your Project Needs a Design Token Strategy',
                'excerpt' => 'Treating design tokens as product infrastructure rather than visual bookkeeping changes how teams ship.',
                'author' => 'Ruben Hart',
                'author_role' => 'Systems Design Writer',
                'date' => 'April 15, 2024',
                'read_time' => '7 min read',
                'image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Why token systems create leverage across design, engineering, and content surfaces.',
            ],
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    public static function find(string $slug): ?array
    {
        foreach (self::all() as $article) {
            if ($article['slug'] === $slug) {
                return $article;
            }
        }

        return null;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function related(array $article): array
    {
        $related = [];

        foreach ($article['related_slugs'] ?? [] as $slug) {
            $item = self::find($slug);

            if ($item !== null) {
                $related[] = $item;
            }
        }

        return $related;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function search(string $query): array
    {
        $needle = mb_strtolower(trim($query));

        if ($needle === '') {
            return [];
        }

        return array_values(array_filter(
            self::all(),
            static function (array $article) use ($needle): bool {
                $haystack = mb_strtolower(implode(' ', array_filter([
                    (string) ($article['title'] ?? ''),
                    (string) ($article['excerpt'] ?? ''),
                    (string) ($article['summary'] ?? ''),
                    (string) ($article['category'] ?? ''),
                    implode(' ', $article['tags'] ?? []),
                ])));

                return str_contains($haystack, $needle);
            },
        ));
    }
}
