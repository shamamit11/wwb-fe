<?php

namespace App\Providers;

use App\Contracts\BlogApiClient;
use App\Services\BlogContentService;
use App\Services\GuzzleBlogApiClient;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\View\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ClientInterface::class, function (): ClientInterface {
            $config = config('services.wideweb_blog');

            return new Client([
                'base_uri' => rtrim((string) $config['base_url'], '/').'/',
                'timeout' => (float) $config['timeout'],
                'connect_timeout' => (float) $config['connect_timeout'],
                'headers' => array_filter([
                    'Accept' => 'application/json',
                    'Authorization' => filled($config['token']) ? 'Bearer '.$config['token'] : null,
                    'User-Agent' => (string) config('app.name'),
                ]),
            ]);
        });

        $this->app->singleton(BlogApiClient::class, GuzzleBlogApiClient::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\View::composer('components.site.footer', function (View $view): void {
            $fallbackCategories = data_get(config('site.footer'), 'categories', []);

            if (app()->runningUnitTests()) {
                $view->with('categories', $fallbackCategories);

                return;
            }

            try {
                /** @var BlogContentService $content */
                $content = app(BlogContentService::class);
                $view->with('categories', $content->categories());
            } catch (\Throwable) {
                $view->with('categories', $fallbackCategories);
            }
        });
    }
}
