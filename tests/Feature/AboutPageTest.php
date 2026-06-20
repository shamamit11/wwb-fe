<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Contracts\BlogApiClient;
use Tests\TestCase;

class AboutPageTest extends TestCase
{
    public function test_the_about_page_renders_with_its_own_metadata_and_sections(): void
    {
        $this->app->instance(BlogApiClient::class, new class implements BlogApiClient
        {
            public function get(string $path, array $query = []): array
            {
                return ['data' => []];
            }

            public function post(string $path, array $body = []): array
            {
                return ['data' => []];
            }
        });

        $response = $this->get('/about');

        $response->assertOk();
        $response->assertSee('About Us');
        $response->assertSee('<title>About Us | Wide Web Blog</title>', false);
        $response->assertSee('<link rel="canonical" href="http://fe.test/about">', false);
    }

    public function test_the_about_page_can_render_managed_api_content_and_seo(): void
    {
        $this->app->instance(BlogApiClient::class, new class implements BlogApiClient
        {
            public function get(string $path, array $query = []): array
            {
                if ($path !== 'public/about') {
                    return ['data' => []];
                }

                return [
                    'data' => [
                        'hero' => [
                            'title' => 'About the Wide Web Blog Team',
                            'eyebrow' => 'Editorial Story',
                            'media_alt' => 'Wide Web Blog team workspace',
                            'media_url' => 'https://example.com/about-hero.jpg',
                            'description' => 'A clearer description of the publication mission.',
                        ],
                        'mission_section' => [
                            'quote' => 'Technology should create leverage, not noise.',
                            'title' => 'Our Editorial Mission',
                            'description' => 'We turn technical complexity into practical insight.',
                        ],
                        'stats_section' => [
                            'items' => [
                                ['value' => '250+', 'label' => 'Guides Published'],
                            ],
                        ],
                        'values_section' => [
                            'title' => 'What We Value',
                            'items' => [
                                ['title' => 'Useful Depth', 'description' => 'We explain the why, not only the what.'],
                            ],
                        ],
                        'team_section' => [
                            'title' => 'Our Team',
                            'description' => 'Writers, operators, and builders behind the publication.',
                            'primary_cta_url' => 'https://widewebblog.com/join',
                            'primary_cta_label' => 'View Open Roles',
                            'members' => [
                                [
                                    'name' => 'Amit Sharma',
                                    'role' => 'Founder',
                                    'image_url' => 'https://example.com/amit.jpg',
                                ],
                            ],
                        ],
                        'seo' => [
                            'meta_title' => 'About Wide Web Blog',
                            'meta_description' => 'Custom about page description.',
                        ],
                    ],
                ];
            }

            public function post(string $path, array $body = []): array
            {
                return ['data' => []];
            }
        });

        $response = $this->get('/about');

        $response->assertOk();
        $response->assertSee('About the Wide Web Blog Team');
        $response->assertSee('Our Editorial Mission');
        $response->assertSee('What We Value');
        $response->assertSee('Our Team');
        $response->assertSee('Amit Sharma');
        $response->assertSee('<title>About Wide Web Blog</title>', false);
        $response->assertSee('<meta name="description" content="Custom about page description.">', false);
    }

    public function test_the_primary_navigation_points_about_to_the_dedicated_route(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('href="/about"', false);
    }

    public function test_the_shared_subscribe_cta_points_to_the_home_newsletter_section(): void
    {
        $response = $this->get('/about');

        $response->assertOk();
        $response->assertSee('href="http://fe.test#newsletter"', false);
    }
}
