<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Contracts\BlogApiClient;
use Tests\TestCase;

class LegalPagesTest extends TestCase
{
    public function test_the_privacy_policy_page_renders_api_content_with_its_own_metadata(): void
    {
        $this->app->instance(BlogApiClient::class, new class implements BlogApiClient
        {
            public function get(string $path, array $query = []): array
            {
                if ($path !== 'public/pages/privacy-policy') {
                    return ['data' => []];
                }

                return [
                    'data' => [
                        'title' => 'Privacy Policy',
                        'summary' => 'Public legal page describing how data is collected, used, and protected.',
                        'content_markdown' => "# Privacy Policy\n\n## Overview\n\nDescribe how the site collects, uses, stores, and protects personal data.",
                        'published_at' => '2026-06-20T20:30:00.000000Z',
                        'canonical_url' => 'http://wwb-service.test/pages/privacy-policy/',
                    ],
                ];
            }

            public function post(string $path, array $body = []): array
            {
                return ['data' => []];
            }
        });

        $response = $this->get('/privacy-policy');

        $response->assertOk();
        $response->assertSee('Privacy Policy');
        $response->assertSee('Describe how the site collects, uses, stores, and protects personal data.');
        $response->assertSee('<title>Privacy Policy | Wide Web Blog</title>', false);
        $response->assertSee('<link rel="canonical" href="http://wwb-service.test/pages/privacy-policy/">', false);
    }

    public function test_the_terms_page_renders_api_content_with_its_own_metadata(): void
    {
        $this->app->instance(BlogApiClient::class, new class implements BlogApiClient
        {
            public function get(string $path, array $query = []): array
            {
                if ($path !== 'public/pages/terms-and-conditions') {
                    return ['data' => []];
                }

                return [
                    'data' => [
                        'title' => 'Terms and Conditions',
                        'summary' => 'Public legal page covering site usage terms, obligations, and limitations.',
                        'content_markdown' => "# Terms and Conditions\n\n## Overview\n\nDescribe the rules, responsibilities, and conditions for using the site.",
                        'published_at' => '2026-06-20T20:30:00.000000Z',
                        'canonical_url' => 'http://wwb-service.test/pages/terms-and-conditions/',
                    ],
                ];
            }

            public function post(string $path, array $body = []): array
            {
                return ['data' => []];
            }
        });

        $response = $this->get('/terms-and-conditions');

        $response->assertOk();
        $response->assertSee('Terms and Conditions');
        $response->assertSee('Describe the rules, responsibilities, and conditions for using the site.');
        $response->assertSee('<title>Terms and Conditions | Wide Web Blog</title>', false);
        $response->assertSee('<link rel="canonical" href="http://wwb-service.test/pages/terms-and-conditions/">', false);
    }

    public function test_footer_legal_links_point_to_dedicated_routes(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('href="/privacy-policy"', false);
        $response->assertSee('href="/terms-and-conditions"', false);
    }
}
