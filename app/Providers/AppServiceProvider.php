<?php

namespace App\Providers;

use App\Contracts\BlogApiClient;
use App\Services\GuzzleBlogApiClient;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
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
        //
    }
}
