<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Exceptions\UpstreamServiceException;
use App\Services\BlogContentService;
use Livewire\Component;

class HomePage extends Component
{
    /** @var array<string, mixed> */
    public array $payload = [];

    public bool $unavailable = false;

    public function mount(BlogContentService $content): void
    {
        try {
            $this->payload = $content->homepage();
        } catch (UpstreamServiceException $exception) {
            report($exception);

            $this->unavailable = true;
            $this->payload = [
                'hero' => [
                    'title' => config('app.name'),
                    'summary' => 'Connect the upstream service endpoint to load cached blog content here.',
                ],
                'featured' => [],
            ];
        }
    }

    public function render()
    {
        return view('livewire.home-page');
    }
}
