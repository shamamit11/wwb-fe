<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Contracts\BlogApiClient;
use App\Livewire\ContactPage;
use Livewire\Livewire;
use Tests\TestCase;

class ContactPageTest extends TestCase
{
    public function test_the_contact_page_renders_with_contact_specific_metadata_and_form_only_content(): void
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

        $response = $this->get('/contact');

        $response->assertOk();
        $response->assertSee('Contact Us');
        $response->assertSee('<title>Contact | Wide Web Blog</title>', false);
        $response->assertSee('<link rel="canonical" href="http://fe.test/contact">', false);
        $response->assertDontSee('Map');
        $response->assertDontSee('Phone');
    }

    public function test_the_contact_page_can_render_managed_api_content_and_seo(): void
    {
        $this->app->instance(BlogApiClient::class, new class implements BlogApiClient
        {
            public function get(string $path, array $query = []): array
            {
                if ($path !== 'public/contact') {
                    return ['data' => []];
                }

                return [
                    'data' => [
                        'hero' => [
                            'title' => 'Talk to the Editorial Team',
                            'eyebrow' => 'Contact Wide Web Blog',
                            'description' => 'Custom hero description.',
                        ],
                        'contact_form' => [
                            'title' => 'Send us a clear message',
                            'eyebrow' => 'Message Form',
                            'description' => 'Tell us what you need.',
                            'submit_label' => 'Submit Inquiry',
                            'success_message' => 'Your message has been submitted.',
                        ],
                        'contact_reasons' => [
                            'items' => [
                                [
                                    'title' => 'Editorial Collaboration',
                                    'description' => 'Let us know what you have in mind.',
                                ],
                            ],
                        ],
                        'seo' => [
                            'meta_title' => 'Contact the Wide Web Blog Team',
                            'meta_description' => 'Custom contact meta description.',
                        ],
                    ],
                ];
            }

            public function post(string $path, array $body = []): array
            {
                return ['data' => []];
            }
        });

        $response = $this->get('/contact');

        $response->assertOk();
        $response->assertSee('Talk to the Editorial Team');
        $response->assertSee('Send us a clear message');
        $response->assertSee('Editorial Collaboration');
        $response->assertSee('<title>Contact the Wide Web Blog Team</title>', false);
        $response->assertSee('<meta name="description" content="Custom contact meta description.">', false);
    }

    public function test_the_contact_form_validates_without_a_full_page_reload(): void
    {
        Livewire::test(ContactPage::class)
            ->call('submit')
            ->assertHasErrors(['name', 'email', 'topic', 'message']);
    }

    public function test_the_contact_form_shows_a_success_state_for_valid_input(): void
    {
        $this->app->instance(BlogApiClient::class, new class implements BlogApiClient
        {
            public function get(string $path, array $query = []): array
            {
                return ['data' => []];
            }

            public function post(string $path, array $body = []): array
            {
                return [
                    'data' => [
                        'status' => 'submitted',
                        'message' => 'Custom API success message.',
                        'submitted_at' => '2026-06-20T18:00:00+00:00',
                    ],
                ];
            }
        });

        Livewire::test(ContactPage::class)
            ->set('name', 'Alex Rivera')
            ->set('email', 'alex@example.com')
            ->set('topic', 'Partnership Inquiry')
            ->set('message', 'We are planning an editorial collaboration and want to discuss the best fit for your audience and format.')
            ->call('submit')
            ->assertSet('submitted', true)
            ->assertSee('Custom API success message.');
    }
}
