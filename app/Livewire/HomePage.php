<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Component;

class HomePage extends Component
{
    /** @var array<string, mixed> */
    public array $hero = [];

    /** @var array<string, mixed> */
    public array $featured = [];

    /** @var array<int, array<string, string>> */
    public array $guides = [];

    /** @var array<int, array<string, string>> */
    public array $topics = [];

    /** @var array<string, mixed> */
    public array $resourceKit = [];

    /** @var array<string, string> */
    public array $newsletter = [];

    public function mount(): void
    {
        $this->hero = [
            'eyebrow' => 'The Knowledge Hub',
            'title' => 'Learn AI, SEO, Blogging, and Digital Growth, One Practical Guide at a Time.',
            'summary' => 'Authority-led insights and deep-dive technical tutorials for modern digital creators. Precision growth strategies without the noise.',
            'image' => 'https://lh3.googleusercontent.com/aida/AP1WRLvf6bNYE6HPvFPNQtZ3BkbryOhL_9yYAbzPHYh9DcTPvbTF3CZrsN3-1TUeiWLmY_SNeMm3mWoU-p53KXQFwYsiBW8SmvUwqzkBlnQZ7cT49nA3UbtgOAeSu4JXm7WnV90FvRK6OXZOzuupLRCzuZNoqZaxu4m82ZdhV9pqErLfj2s3QUm-3kpJtnr0k-7D4jo8CVzFa1hVZLzq29Whw1sleS28ADYq1zWYS17sHvTGuRPtS3nt7eK0vkM',
            'primary_cta' => ['label' => 'Start Reading', 'href' => '#featured'],
            'secondary_cta' => ['label' => 'View AI Tools', 'href' => '#topics'],
        ];

        $this->featured = [
            'title' => 'Featured Editorial',
            'summary' => 'Expert analysis on the evolving digital landscape.',
            'lead' => [
                'category' => 'AI Tools',
                'title' => 'Architecting the Future: How Generative AI is Redefining Content Ecosystems',
                'excerpt' => 'Understanding the shift from keyword-based content to semantically rich, AI-assisted architecture that resonates with both machines and humans.',
                'author' => 'Alex Sterling',
                'author_initials' => 'AS',
                'read_time' => '12 Min Read',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAagyzljQP04j8aSKCYjzZp0Yl8fi2Gy60GzTCVvwNVDH3EFLqWBvPH3epYvQJRl_IoyTcE1pDIK05SZXARjEev2eyZ-pSFNuS1-5meJ_6VBIrlKMjigWsmdTOFHtvD3qAZrplEkznhv32AwHEKYJautvnPz2zrA-dH99g6hYT-psl-NPQnkyYBTX38fZ53ygeq6XltGMN3dYlP6KwoqGsinySBSDD1Y2cWJi8QzxBy_LvhzlbLw1YGmmMESTlgZXlsG-NWEMmIMqLf',
            ],
            'secondary' => [
                [
                    'category' => 'SEO',
                    'title' => 'The Semantic Web: Why Entities Matter More Than Keywords',
                    'meta_left' => '2 days ago',
                    'meta_right' => '6 Min Read',
                    'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBX0meBpqEhkU_X9ZqHPRp11BCDYwsRLHTOnpUJdOpQrQjQLfNNj_cWal1DuT2r62AH-JLya5x7iGQLYuuCAYo-EJMNtiSmZlLJsLQPrLOioG_cOuFSqzXCRlv3wTLcI5mPPb7eqNpzbT9hIz8SCA4RYxAS_A1aNIYgkzgfiRdDL95JIYgAlo81pIanaiyBK-E4JLCI6KYsi8mUngXeFgj8W2TasONKoe6EORo7oOAsZOvtZVKvL8Ep6XjCX24ls6RnUOtSYpc0L5QH',
                ],
                [
                    'category' => 'Blogging',
                    'title' => 'Scaling Editorial Operations: From Solo to Media Powerhouse',
                    'meta_left' => '8 Min Read',
                    'meta_right' => 'Published Recently',
                    'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBVa-JaSoZFBep7oRqnqo2JGszAV6_eT2x2_ZAhHFQWt5CUJ25ego6gb4QskdkfOPM-TU4S5i5GyZNVPDJW_M2T1-APBs4MSc8ueUPlwom7AugPXvBQGijbeu2OAgydxUCWtIDE-QxPkSsR58_a1xt71tyXuf-P856U_STKVWUroJWOg4m4SOnno6xr7vX_r0nK_qiUX9keHkXJDhZbWU_taP2HUVVXGiMZmkI3o7SkAe1mul1VFdvoxFYWQoXsDPvT7JMvV3JlEijF',
                ],
            ],
        ];

        $this->guides = [
            [
                'icon' => 'terminal',
                'category' => 'Tech Guides',
                'title' => 'Mastering Prompt Engineering for LLMs',
                'excerpt' => 'A foundational framework for getting predictable, high-quality outputs from advanced AI models.',
                'read_time' => '15 min read',
            ],
            [
                'icon' => 'hub',
                'category' => 'SEO',
                'title' => 'Building a Knowledge Graph for Your Site',
                'excerpt' => 'How to organize your content data for superior internal linking and semantic SEO relevance.',
                'read_time' => '22 min read',
            ],
            [
                'icon' => 'currency_exchange',
                'category' => 'Online Income',
                'title' => 'Advanced Affiliate Monetization Strategies',
                'excerpt' => 'Moving beyond banners: how to integrate high-converting affiliate funnels into editorial content.',
                'read_time' => '18 min read',
            ],
            [
                'icon' => 'speed',
                'category' => 'Productivity',
                'title' => 'AI-Enhanced Editorial Workflows',
                'excerpt' => 'Automating the repetitive tasks of content creation to focus on high-impact strategy and research.',
                'read_time' => '10 min read',
            ],
        ];

        $this->topics = [
            ['icon' => 'robot', 'label' => 'AI Tools', 'href' => '#featured'],
            ['icon' => 'edit_square', 'label' => 'Blogging', 'href' => '#guides'],
            ['icon' => 'search', 'label' => 'SEO', 'href' => '#featured'],
            ['icon' => 'account_balance_wallet', 'label' => 'Digital Assets', 'href' => '#resources'],
            ['icon' => 'bolt', 'label' => 'Productivity', 'href' => '#guides'],
            ['icon' => 'auto_stories', 'label' => 'Tech Guides', 'href' => '#guides'],
            ['icon' => 'payments', 'label' => 'Online Income', 'href' => '#guides'],
            ['icon' => 'integration_instructions', 'label' => 'Tutorials', 'href' => '#guides'],
        ];

        $this->resourceKit = [
            'eyebrow' => 'Exclusive Resources',
            'title' => 'Free Digital Creator Kit',
            'summary' => 'Download our professional hub of free assets designed to streamline your editorial workflow and accelerate your site\'s growth.',
            'items' => [
                'AI Blog Post Checklist (GPT-4 Optimized)',
                'SEO Article Structure Template',
                'Editorial Content Calendar (Notion)',
                'Affiliate Blog Starter Guide',
                'Custom Prompt Pack for Bloggers',
            ],
            'stats' => [
                ['value' => '25k+', 'label' => 'Creators'],
                ['value' => '4.9/5', 'label' => 'Rating'],
                ['value' => '20+', 'label' => 'Templates'],
                ['value' => '100%', 'label' => 'Free Access'],
            ],
            'cta' => ['label' => 'Claim Your Free Kit', 'href' => '#newsletter'],
        ];

        $this->newsletter = [
            'title' => 'Stay Ahead of the Curve',
            'summary' => 'Join 25,000+ digital architects. Get one technical, high-signal editorial guide every week directly in your inbox.',
            'placeholder' => 'Enter your email',
            'button' => 'Subscribe',
            'note' => 'High-quality insights. No spam. Unsubscribe anytime.',
        ];
    }

    public function render()
    {
        return view('livewire.home-page');
    }
}
