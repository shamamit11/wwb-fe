<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Livewire\ResourcesPage;
use Livewire\Livewire;
use Tests\TestCase;

class ResourcesPageTest extends TestCase
{
    public function test_the_resources_page_renders_with_page_specific_seo_and_featured_content(): void
    {
        $response = $this->get('/resources');

        $response->assertOk();
        $response->assertSee('Free Digital Creator Kit');
        $response->assertSee('<title>Resources | Wide Web Blog</title>', false);
        $response->assertSee('<link rel="canonical" href="http://fe.test/resources">', false);
    }

    public function test_resource_filters_update_the_grid_without_a_full_page_reload(): void
    {
        Livewire::test(ResourcesPage::class)
            ->assertSee('Minimalist Dashboard Kit')
            ->call('setCategory', 'checklists')
            ->assertSet('activeCategory', 'checklists')
            ->assertSee('Pre-Launch Website Checklist')
            ->assertDontSee('SEO for Developers');
    }

    public function test_sorting_reorders_the_resources(): void
    {
        Livewire::test(ResourcesPage::class)
            ->assertSeeInOrder([
                'Minimalist Dashboard Kit',
                'SEO for Developers',
                'Tailwind Animation Library',
            ])
            ->set('sort', 'alphabetical')
            ->assertSeeInOrder([
                '2024 Brand Identity Kit',
                'Content Strategy Notion Template',
                'Minimalist Dashboard Kit',
            ]);
    }
}
