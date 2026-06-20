<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Services\BlogContentService;
use Livewire\Component;
use Throwable;

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

    /** @var array<string, string> */
    public array $valuesSection = [];

    /** @var array<int, array<string, string>> */
    public array $team = [];

    /** @var array<string, string> */
    public array $teamSection = [];

    public function mount(array $aboutPayload = []): void
    {
        $this->story = [
            'eyebrow' => 'About Us',
            'title' => 'About Us',
            'summary' => '',
            'image' => '',
            'image_alt' => '',
        ];

        $this->mission = [
            'title' => '',
            'body' => '',
            'quote' => '',
        ];

        $this->stats = [];

        $this->values = [];

        $this->valuesSection = [
            'title' => '',
        ];

        $this->team = [];

        $this->teamSection = [
            'title' => '',
            'description' => '',
            'primary_cta_label' => '',
            'primary_cta_url' => '',
        ];

        $payload = $aboutPayload !== [] ? $aboutPayload : $this->resolveAboutPayload();
        $resolved = is_array(data_get($payload, 'data')) ? data_get($payload, 'data') : $payload;

        if (! is_array($resolved) || $resolved === []) {
            return;
        }

        $hero = is_array(data_get($resolved, 'hero')) ? data_get($resolved, 'hero') : [];
        $mission = is_array(data_get($resolved, 'mission_section')) ? data_get($resolved, 'mission_section') : [];
        $stats = is_array(data_get($resolved, 'stats_section.items')) ? data_get($resolved, 'stats_section.items') : [];
        $valuesSection = is_array(data_get($resolved, 'values_section')) ? data_get($resolved, 'values_section') : [];
        $teamSection = is_array(data_get($resolved, 'team_section')) ? data_get($resolved, 'team_section') : [];

        $this->story = [
            'eyebrow' => $this->stringOrDefault(data_get($hero, 'eyebrow'), $this->story['eyebrow']),
            'title' => $this->stringOrDefault(data_get($hero, 'title'), $this->story['title']),
            'summary' => $this->stringOrDefault(data_get($hero, 'description'), $this->story['summary']),
            'image' => $this->stringOrDefault(data_get($hero, 'media_url'), $this->story['image']),
            'image_alt' => $this->stringOrDefault(data_get($hero, 'media_alt'), $this->story['image_alt']),
        ];

        $this->mission = [
            'title' => $this->stringOrDefault(data_get($mission, 'title'), $this->mission['title']),
            'body' => $this->stringOrDefault(data_get($mission, 'description'), $this->mission['body']),
            'quote' => $this->stringOrDefault(data_get($mission, 'quote'), $this->mission['quote']),
        ];

        $mappedStats = array_values(array_filter(array_map(function (mixed $item): ?array {
            if (! is_array($item)) {
                return null;
            }

            $value = $this->stringOrDefault(data_get($item, 'value') ?: data_get($item, 'stat') ?: data_get($item, 'number'), '');
            $label = $this->stringOrDefault(data_get($item, 'label') ?: data_get($item, 'title') ?: data_get($item, 'name'), '');

            return filled($value) && filled($label)
                ? ['value' => $value, 'label' => $label]
                : null;
        }, $stats), static fn (?array $item): bool => is_array($item)));

        if ($mappedStats !== []) {
            $this->stats = $mappedStats;
        }

        $this->valuesSection = [
            'title' => $this->stringOrDefault(data_get($valuesSection, 'title'), $this->valuesSection['title']),
        ];

        $mappedValues = array_values(array_filter(array_map(function (mixed $item): ?array {
            if (! is_array($item)) {
                return null;
            }

            $title = $this->stringOrDefault(data_get($item, 'title') ?: data_get($item, 'name'), '');
            $body = $this->stringOrDefault(data_get($item, 'description') ?: data_get($item, 'body'), '');
            $icon = $this->stringOrDefault(data_get($item, 'icon'), 'verified');

            return filled($title) && filled($body)
                ? ['icon' => $icon, 'title' => $title, 'body' => $body]
                : null;
        }, (array) data_get($valuesSection, 'items', [])), static fn (?array $item): bool => is_array($item)));

        if ($mappedValues !== []) {
            $this->values = $mappedValues;
        }

        $this->teamSection = [
            'title' => $this->stringOrDefault(data_get($teamSection, 'title'), $this->teamSection['title']),
            'description' => $this->stringOrDefault(data_get($teamSection, 'description'), $this->teamSection['description']),
            'primary_cta_label' => $this->stringOrDefault(data_get($teamSection, 'primary_cta_label'), $this->teamSection['primary_cta_label']),
            'primary_cta_url' => $this->stringOrDefault(data_get($teamSection, 'primary_cta_url'), $this->teamSection['primary_cta_url']),
        ];

        $mappedTeam = array_values(array_filter(array_map(function (mixed $item): ?array {
            if (! is_array($item)) {
                return null;
            }

            $name = $this->stringOrDefault(data_get($item, 'name'), '');
            $role = $this->stringOrDefault(data_get($item, 'role') ?: data_get($item, 'title'), '');
            $image = $this->stringOrDefault(data_get($item, 'image_url') ?: data_get($item, 'media_url') ?: data_get($item, 'image'), '');

            return filled($name) && filled($role) && filled($image)
                ? ['name' => $name, 'role' => $role, 'image' => $image]
                : null;
        }, (array) data_get($teamSection, 'members', [])), static fn (?array $item): bool => is_array($item)));

        if ($mappedTeam !== []) {
            $this->team = $mappedTeam;
        }
    }

    public function render()
    {
        return view('livewire.about-page');
    }

    /**
     * @return array<string, mixed>
     */
    private function resolveAboutPayload(): array
    {
        try {
            return app(BlogContentService::class)->about();
        } catch (Throwable) {
            return [];
        }
    }

    private function stringOrDefault(mixed $value, string $fallback): string
    {
        return is_string($value) && trim($value) !== '' ? trim($value) : $fallback;
    }
}
