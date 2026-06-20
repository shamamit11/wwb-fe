<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class AboutPageTest extends TestCase
{
    public function test_the_about_page_renders_with_its_own_metadata_and_sections(): void
    {
        $response = $this->get('/about');

        $response->assertOk();
        $response->assertSee('Navigating the digital frontier together.');
        $response->assertSee('The Values We Live By');
        $response->assertSee('Meet the Minds');
        $response->assertSee('<title>About Us | Wide Web Blog</title>', false);
        $response->assertSee('<link rel="canonical" href="http://fe.test/about">', false);
    }

    public function test_the_primary_navigation_points_about_to_the_dedicated_route(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('href="/about"', false);
    }
}
