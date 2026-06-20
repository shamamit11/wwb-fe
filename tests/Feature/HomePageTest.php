<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_the_home_page_renders_the_livewire_marketing_homepage(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Learn AI, SEO, Blogging, and Digital Growth, One Practical Guide at a Time.');
        $response->assertSee('Featured Editorial');
        $response->assertSee('Practical Wisdom for Builders');
        $response->assertSee('All Articles');
        $response->assertSee('Contact Us');
        $response->assertDontSee('Editorial Guidelines');
        $response->assertSee('AI Agents');
    }

    public function test_the_home_page_outputs_reusable_seo_metadata_without_cdn_tailwind(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('<meta name="description" content="Learn AI, SEO, blogging, and digital growth through practical editorial guides, creator playbooks, and technical walkthroughs.">', false);
        $response->assertSee('<link rel="canonical" href="http://fe.test">', false);
        $response->assertSee('<meta property="og:title" content="Wide Web Blog | Premium Digital Editorial &amp; Creator Guides">', false);
        $response->assertDontSee('cdn.tailwindcss.com');
    }
}
