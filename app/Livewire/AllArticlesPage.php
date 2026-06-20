<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Component;

class AllArticlesPage extends Component
{
    /** @var array<int, array<string, string>> */
    public array $filters = [];

    /** @var array<int, array<string, mixed>> */
    public array $articles = [];

    public string $activeCategory = 'all';

    public int $visibleCount = 7;

    public string $lastUpdated = 'May 2024';

    public function mount(): void
    {
        $this->filters = [
            ['slug' => 'all', 'label' => 'All Content'],
            ['slug' => 'ai-tools', 'label' => 'AI Tools'],
            ['slug' => 'blogging', 'label' => 'Blogging'],
            ['slug' => 'seo-strategy', 'label' => 'SEO Strategy'],
            ['slug' => 'web-dev', 'label' => 'Web Dev'],
            ['slug' => 'case-studies', 'label' => 'Case Studies'],
            ['slug' => 'news', 'label' => 'News'],
        ];

        $this->articles = [
            [
                'slug' => 'future-of-generative-models-in-enterprise-seo',
                'category' => 'Artificial Intelligence',
                'category_slug' => 'ai-tools',
                'title' => 'The Future of Generative Models in Enterprise SEO',
                'excerpt' => 'How large language models are reshaping the way we think about content density and keyword architecture for modern search surfaces.',
                'author' => 'Sarah Jenkins',
                'date' => 'May 12, 2024',
                'read_time' => '8 min read',
                'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'slug' => 'mastering-the-art-of-editorial-consistency',
                'category' => 'Blogging',
                'category_slug' => 'blogging',
                'title' => 'Mastering the Art of Editorial Consistency',
                'excerpt' => 'Developing a brand voice that resonates across diverse digital platforms without flattening your point of view.',
                'author' => 'David Cohen',
                'date' => 'May 10, 2024',
                'read_time' => '5 min read',
                'image' => 'https://images.unsplash.com/photo-1516321497487-e288fb19713f?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'slug' => 'post-update-recovery-a-step-by-step-guide',
                'category' => 'SEO Strategy',
                'category_slug' => 'seo-strategy',
                'title' => 'Post-Update Recovery: A Step-by-Step Guide',
                'excerpt' => 'Navigating the aftermath of the latest search algorithm core updates with data-driven diagnostics and calmer prioritization.',
                'author' => 'Marcus Thorne',
                'date' => 'May 8, 2024',
                'read_time' => '12 min read',
                'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'slug' => 'headless-cms-architectures-for-content-heavy-blogs',
                'category' => 'Web Dev',
                'category_slug' => 'web-dev',
                'title' => 'Headless CMS Architectures for Content Heavy Blogs',
                'excerpt' => 'Why decoupling your front-end from your content store is the ultimate performance play for editorial scale.',
                'author' => 'Leo Vang',
                'date' => 'May 6, 2024',
                'read_time' => '10 min read',
                'image' => 'https://images.unsplash.com/photo-1515879218367-8466d910aaa4?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'slug' => 'how-streamline-scaled-their-content-to-1m-visitors',
                'category' => 'Case Studies',
                'category_slug' => 'case-studies',
                'title' => 'How \'Streamline\' Scaled Their Content to 1M Visitors',
                'excerpt' => 'A deep dive into the operational shifts and content strategies that fueled exponential editorial growth.',
                'author' => 'Sarah Jenkins',
                'date' => 'May 5, 2024',
                'read_time' => '15 min read',
                'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'slug' => 'the-decentralization-of-online-publishing',
                'category' => 'News',
                'category_slug' => 'news',
                'title' => 'The Decentralization of Online Publishing',
                'excerpt' => 'Exploring how independent writers are reclaiming ownership through newsletters, communities, and platform-light publishing.',
                'author' => 'David Cohen',
                'date' => 'May 3, 2024',
                'read_time' => '6 min read',
                'image' => 'https://images.unsplash.com/photo-1516280440614-37939bbacd81?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'slug' => 'planning-your-2025-content-calendar-today',
                'category' => 'Blogging',
                'category_slug' => 'blogging',
                'title' => 'Planning Your 2025 Content Calendar Today',
                'excerpt' => 'The long-game approach to topic clustering and seasonal relevance for authority sites that publish with intent.',
                'author' => 'Marcus Thorne',
                'date' => 'May 1, 2024',
                'read_time' => '9 min read',
                'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'slug' => 'building-small-ai-utilities-that-actually-stick',
                'category' => 'Artificial Intelligence',
                'category_slug' => 'ai-tools',
                'title' => 'Building Small AI Utilities That Actually Stick',
                'excerpt' => 'A practical framework for creating narrowly useful AI tools that solve one problem well and compound editorial leverage.',
                'author' => 'Priya Solanki',
                'date' => 'April 28, 2024',
                'read_time' => '7 min read',
                'image' => 'https://images.unsplash.com/photo-1484417894907-623942c8ee29?auto=format&fit=crop&w=1200&q=80',
            ],
        ];
    }

    public function setCategory(string $slug): void
    {
        $this->activeCategory = $slug;
        $this->visibleCount = 7;
    }

    public function loadMore(): void
    {
        $this->visibleCount += 3;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function filteredArticles(): array
    {
        if ($this->activeCategory === 'all') {
            return $this->articles;
        }

        return array_values(array_filter(
            $this->articles,
            fn (array $article): bool => $article['category_slug'] === $this->activeCategory,
        ));
    }

    public function render()
    {
        $filteredArticles = $this->filteredArticles();
        $visibleArticles = array_slice($filteredArticles, 0, $this->visibleCount);

        return view('livewire.all-articles-page', [
            'visibleArticles' => $visibleArticles,
            'leadArticle' => $visibleArticles[0] ?? null,
            'spotlightArticle' => $visibleArticles[1] ?? null,
            'gridArticles' => array_slice($visibleArticles, 2),
            'totalFiltered' => count($filteredArticles),
            'visibleTotal' => count($visibleArticles),
            'hasMore' => count($filteredArticles) > count($visibleArticles),
        ]);
    }
}
