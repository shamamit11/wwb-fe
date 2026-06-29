<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class RobotsController extends Controller
{
    public function __invoke(): Response
    {
        $content = implode("\n", [
            'User-agent: *',
            'Disallow:',
            'Sitemap: '.route('sitemap'),
        ]);

        return response($content)
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
