<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class LegalPagesTest extends TestCase
{
    public function test_the_privacy_policy_page_renders_with_its_own_metadata(): void
    {
        $response = $this->get('/privacy-policy');

        $response->assertOk();
        $response->assertSee('Privacy Policy');
        $response->assertSee('<title>Privacy Policy | Wide Web Blog</title>', false);
        $response->assertSee('<link rel="canonical" href="http://fe.test/privacy-policy">', false);
    }

    public function test_the_terms_page_renders_with_its_own_metadata(): void
    {
        $response = $this->get('/terms-and-conditions');

        $response->assertOk();
        $response->assertSee('Terms and Conditions');
        $response->assertSee('<title>Terms and Conditions | Wide Web Blog</title>', false);
        $response->assertSee('<link rel="canonical" href="http://fe.test/terms-and-conditions">', false);
    }

    public function test_footer_legal_links_point_to_dedicated_routes(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('href="/privacy-policy"', false);
        $response->assertSee('href="/terms-and-conditions"', false);
    }
}
