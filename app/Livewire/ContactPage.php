<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;

class ContactPage extends Component
{
    #[Validate('required|string|min:2|max:120')]
    public string $name = '';

    #[Validate('required|email|max:255')]
    public string $email = '';

    #[Validate('required|string|min:3|max:120')]
    public string $topic = '';

    #[Validate('required|string|min:20|max:2000')]
    public string $message = '';

    public bool $submitted = false;

    public function submit(): void
    {
        $this->validate();

        $this->submitted = true;

        $this->reset(['name', 'email', 'topic', 'message']);
    }

    public function render()
    {
        return view('livewire.contact-page');
    }
}
