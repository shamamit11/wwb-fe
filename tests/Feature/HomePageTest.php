<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Services\BlogContentService;
use Mockery;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_the_home_page_renders_cached_content_shell(): void
    {
        $service = Mockery::mock(BlogContentService::class);
        $service->shouldReceive('homepage')
            ->once()
            ->andReturn([
                'hero' => [
                    'title' => 'Fresh from the API',
                    'summary' => 'Curated posts for readers.',
                ],
                'featured' => [
                    [
                        'title' => 'Cached launch article',
                        'excerpt' => 'This content came from the mocked service layer.',
                    ],
                ],
            ]);

        $this->app->instance(BlogContentService::class, $service);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Fresh from the API');
        $response->assertSee('Cached launch article');
    }
}
