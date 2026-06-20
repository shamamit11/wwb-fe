<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Component;

class AboutPage extends Component
{
    /** @var array<string, mixed> */
    public array $story = [];

    /** @var array<string, mixed> */
    public array $mission = [];

    /** @var array<int, array<string, string>> */
    public array $stats = [];

    /** @var array<int, array<string, string>> */
    public array $values = [];

    /** @var array<int, array<string, string>> */
    public array $team = [];

    public function mount(): void
    {
        $this->story = [
            'eyebrow' => 'Our Story',
            'title' => 'Navigating the digital frontier together.',
            'highlight' => 'frontier',
            'summary' => 'Wide Web Blog was founded on the belief that technology should be accessible, insightful, and growth-oriented. We dissect the noise to bring you the signal.',
            'image' => 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1600&q=80',
        ];

        $this->mission = [
            'title' => 'Our Mission: Fueling Digital Growth',
            'body' => 'We do not just report on news; we provide the context needed to thrive in an era of rapid AI and technological evolution. Our mission is to bridge the gap between complex engineering concepts and strategic business outcomes.',
            'quote' => 'The future is not just about code, it is about how we leverage it to amplify human potential.',
        ];

        $this->stats = [
            ['value' => '500+', 'label' => 'Articles Published'],
            ['value' => '120K', 'label' => 'Monthly Readers'],
            ['value' => '12', 'label' => 'Global Experts'],
            ['value' => '100%', 'label' => 'Independent'],
        ];

        $this->values = [
            [
                'icon' => 'verified',
                'title' => 'Authentic Clarity',
                'body' => 'We prioritize honesty and transparency in every piece of content, ensuring our readers get the truth behind the hype.',
            ],
            [
                'icon' => 'trending_up',
                'title' => 'Growth Mindset',
                'body' => 'Continuous learning is at our core. We explore emerging technologies with curiosity and a focus on long-term value.',
            ],
            [
                'icon' => 'forum',
                'title' => 'Community Focused',
                'body' => 'Technology is human. We build platforms that foster dialogue, collaboration, and shared digital success.',
            ],
        ];

        $this->team = [
            [
                'name' => 'Alexander Chen',
                'role' => 'Editor-in-Chief',
                'image' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'name' => 'Sarah Jenkins',
                'role' => 'Head of AI Research',
                'image' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'name' => 'Marcus Thorne',
                'role' => 'Lead Developer',
                'image' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'name' => 'Elena Rodriguez',
                'role' => 'Strategy Director',
                'image' => 'https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?auto=format&fit=crop&w=900&q=80',
            ],
        ];
    }

    public function render()
    {
        return view('livewire.about-page');
    }
}
