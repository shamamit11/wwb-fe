<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Services\BlogContentService;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Throwable;

class ContactPage extends Component
{
    /** @var array<string, string> */
    public array $hero = [];

    /** @var array<string, string> */
    public array $formSection = [];

    /** @var array<int, array<string, string>> */
    public array $reasons = [];

    #[Validate('required|string|min:2|max:120')]
    public string $name = '';

    #[Validate('required|email|max:255')]
    public string $email = '';

    #[Validate('required|string|min:3|max:120')]
    public string $topic = '';

    #[Validate('required|string|min:20|max:2000')]
    public string $message = '';

    public bool $submitted = false;

    public string $successMessage = 'Thanks for reaching out. Your note is queued on our side and we will review it with the context you provided.';

    public string $submitError = '';

    public function mount(array $contactPayload = []): void
    {
        $this->hero = [
            'eyebrow' => 'Start the Conversation',
            'title' => 'Tell us what you are building, writing, or rethinking.',
            'description' => 'Wide Web Blog is built for thoughtful builders. Use the form to reach out about collaborations, editorial opportunities, sponsorships, or ideas worth exploring.',
        ];

        $this->formSection = [
            'eyebrow' => 'Contact Form',
            'title' => 'One message, clearly framed.',
            'description' => 'Keep it concise but useful. Tell us what you need, why it matters, and what a good outcome looks like.',
            'submit_label' => 'Send Message',
            'success_message' => $this->successMessage,
        ];

        $this->reasons = [
            [
                'title' => 'Editorial partnerships',
                'description' => 'Share your concept, audience, and what the collaboration should accomplish.',
            ],
            [
                'title' => 'Product or resource ideas',
                'description' => 'If there is a template, guide, or workflow you want us to cover, describe the gap clearly.',
            ],
            [
                'title' => 'Signal over noise',
                'description' => 'The more specific your context is, the better the response will be.',
            ],
        ];

        $payload = $contactPayload !== [] ? $contactPayload : $this->resolveContactPayload();
        $resolved = is_array(data_get($payload, 'data')) ? data_get($payload, 'data') : $payload;

        if (! is_array($resolved) || $resolved === []) {
            return;
        }

        $hero = is_array(data_get($resolved, 'hero')) ? data_get($resolved, 'hero') : [];
        $form = is_array(data_get($resolved, 'contact_form')) ? data_get($resolved, 'contact_form') : [];

        $this->hero = [
            'eyebrow' => $this->stringOrDefault(data_get($hero, 'eyebrow'), $this->hero['eyebrow']),
            'title' => $this->stringOrDefault(data_get($hero, 'title'), $this->hero['title']),
            'description' => $this->stringOrDefault(data_get($hero, 'description'), $this->hero['description']),
        ];

        $this->formSection = [
            'eyebrow' => $this->stringOrDefault(data_get($form, 'eyebrow'), $this->formSection['eyebrow']),
            'title' => $this->stringOrDefault(data_get($form, 'title'), $this->formSection['title']),
            'description' => $this->stringOrDefault(data_get($form, 'description'), $this->formSection['description']),
            'submit_label' => $this->stringOrDefault(data_get($form, 'submit_label'), $this->formSection['submit_label']),
            'success_message' => $this->stringOrDefault(data_get($form, 'success_message'), $this->formSection['success_message']),
        ];

        $this->successMessage = $this->formSection['success_message'];

        $mappedReasons = array_values(array_filter(array_map(function (mixed $item): ?array {
            if (! is_array($item)) {
                return null;
            }

            $title = $this->stringOrDefault(data_get($item, 'title'), '');
            $description = $this->stringOrDefault(data_get($item, 'description'), '');

            return filled($title) && filled($description)
                ? ['title' => $title, 'description' => $description]
                : null;
        }, (array) data_get($resolved, 'contact_reasons.items', [])), static fn (?array $item): bool => is_array($item)));

        if ($mappedReasons !== []) {
            $this->reasons = $mappedReasons;
        }
    }

    public function useReason(string $title): void
    {
        $this->topic = $title;
    }

    public function submit(BlogContentService $content): void
    {
        $this->validate();
        $this->submitError = '';

        try {
            $response = $content->submitContact([
                'name' => $this->name,
                'email' => $this->email,
                'topic' => $this->topic,
                'message' => $this->message,
                'metadata' => [
                    'source:fe',
                    'route:contact',
                ],
            ]);
        } catch (Throwable) {
            $this->submitError = 'We could not submit your message right now. Please try again shortly.';

            return;
        }

        $responseMessage = data_get($response, 'data.message');

        if (is_string($responseMessage) && trim($responseMessage) !== '') {
            $this->successMessage = trim($responseMessage);
        }

        $this->submitted = true;

        $this->reset(['name', 'email', 'topic', 'message']);
    }

    public function render()
    {
        return view('livewire.contact-page');
    }

    /**
     * @return array<string, mixed>
     */
    private function resolveContactPayload(): array
    {
        try {
            return app(BlogContentService::class)->contact();
        } catch (Throwable) {
            return [];
        }
    }

    private function stringOrDefault(mixed $value, string $fallback): string
    {
        return is_string($value) && trim($value) !== '' ? trim($value) : $fallback;
    }
}
