<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Livewire\ContactPage;
use Livewire\Livewire;
use Tests\TestCase;

class ContactPageTest extends TestCase
{
    public function test_the_contact_page_renders_with_contact_specific_metadata_and_form_only_content(): void
    {
        $response = $this->get('/contact');

        $response->assertOk();
        $response->assertSee('Contact Form');
        $response->assertSee('<title>Contact | Wide Web Blog</title>', false);
        $response->assertSee('<link rel="canonical" href="http://fe.test/contact">', false);
        $response->assertDontSee('Map');
        $response->assertDontSee('Phone');
    }

    public function test_the_contact_form_validates_without_a_full_page_reload(): void
    {
        Livewire::test(ContactPage::class)
            ->call('submit')
            ->assertHasErrors(['name', 'email', 'topic', 'message']);
    }

    public function test_the_contact_form_shows_a_success_state_for_valid_input(): void
    {
        Livewire::test(ContactPage::class)
            ->set('name', 'Alex Rivera')
            ->set('email', 'alex@example.com')
            ->set('topic', 'Partnership Inquiry')
            ->set('message', 'We are planning an editorial collaboration and want to discuss the best fit for your audience and format.')
            ->call('submit')
            ->assertSet('submitted', true)
            ->assertSee('Message received');
    }

    public function test_footer_contact_link_points_to_the_dedicated_contact_route(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('href="/contact"', false);
    }
}
