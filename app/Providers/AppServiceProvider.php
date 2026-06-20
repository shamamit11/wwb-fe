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
            $fallbackFooter = [
                'brand_name' => (string) data_get(config('site.footer'), 'brand_name', config('site.name', config('app.name'))),
                'description' => (string) data_get(config('site.footer'), 'description', ''),
                'social_links' => array_values(array_filter(
                    (array) data_get(config('site.footer'), 'social_links', []),
                    static fn (mixed $item): bool => is_array($item)
                        && filled(data_get($item, 'label'))
                        && filled(data_get($item, 'url')),
                )),
                'legal_links' => array_values(array_filter(
                    array_map(function (mixed $item): ?array {
                        if (! is_array($item) || ! filled(data_get($item, 'label'))) {
                            return null;
                        }

                        $href = $this->resolveFooterLegalHref(
                            is_string(data_get($item, 'slug')) ? (string) data_get($item, 'slug') : null,
                            is_string(data_get($item, 'url')) ? (string) data_get($item, 'url') : null,
                        );

                        if ($href === null) {
                            return null;
                        }

                        return [
                            'label' => (string) data_get($item, 'label'),
                            'href' => $href,
                        ];
                    }, (array) data_get(config('site.footer'), 'legal_links', [])),
                    static fn (mixed $item): bool => is_array($item),
                )),
            ];
            $fallbackCategories = data_get(config('site.footer'), 'categories', []);

            try {
                /** @var BlogContentService $content */
                $content = app(BlogContentService::class);
                $siteSettings = $content->siteSettings();
                $footerData = is_array(data_get($siteSettings, 'data.footer')) ? data_get($siteSettings, 'data.footer') : [];

                $view->with('categories', $content->categories());
                $view->with('footerData', [
                    'brand_name' => filled(data_get($footerData, 'brand_name'))
                        ? (string) data_get($footerData, 'brand_name')
                        : $fallbackFooter['brand_name'],
                    'description' => filled(data_get($footerData, 'description'))
                        ? (string) data_get($footerData, 'description')
                        : $fallbackFooter['description'],
                    'social_links' => $this->mapFooterSocialLinks(
                        is_array(data_get($footerData, 'social_links')) ? data_get($footerData, 'social_links') : [],
                        $fallbackFooter['social_links'],
                    ),
                    'legal_links' => $this->mapFooterLegalLinks(
                        is_array(data_get($footerData, 'legal_links')) ? data_get($footerData, 'legal_links') : [],
                        $fallbackFooter['legal_links'],
                    ),
                ]);
            } catch (\Throwable) {
                $view->with('categories', $fallbackCategories);
                $view->with('footerData', $fallbackFooter);
            }
        });
    }

    /**
     * @param  array<int, mixed>  $items
     * @param  array<int, array{label: string, url: string, icon: string}>  $fallback
     * @return array<int, array{label: string, url: string, icon: string}>
     */
    private function mapFooterSocialLinks(array $items, array $fallback): array
    {
        $mapped = array_values(array_filter(array_map(function (mixed $item): ?array {
            if (! is_array($item) || ! filled(data_get($item, 'label')) || ! filled(data_get($item, 'url'))) {
                return null;
            }

            return [
                'label' => (string) data_get($item, 'label'),
                'url' => (string) data_get($item, 'url'),
                'icon' => $this->resolveFooterIcon(is_string(data_get($item, 'icon')) ? (string) data_get($item, 'icon') : null),
            ];
        }, $items), static fn (mixed $item): bool => is_array($item)));

        return $mapped !== [] ? $mapped : $fallback;
    }

    /**
     * @param  array<int, mixed>  $items
     * @param  array<int, array{label: string, href: string}>  $fallback
     * @return array<int, array{label: string, href: string}>
     */
    private function mapFooterLegalLinks(array $items, array $fallback): array
    {
        $mapped = array_values(array_filter(array_map(function (mixed $item): ?array {
            if (! is_array($item) || ! filled(data_get($item, 'label'))) {
                return null;
            }

            $href = $this->resolveFooterLegalHref(
                is_string(data_get($item, 'slug')) ? (string) data_get($item, 'slug') : null,
                is_string(data_get($item, 'url')) ? (string) data_get($item, 'url') : null,
            );

            if ($href === null) {
                return null;
            }

            return [
                'label' => (string) data_get($item, 'label'),
                'href' => $href,
            ];
        }, $items), static fn (mixed $item): bool => is_array($item)));

        return $mapped !== [] ? $mapped : $fallback;
    }

    private function resolveFooterLegalHref(?string $slug, ?string $url): ?string
    {
        $resolvedUrl = is_string($url) ? trim($url) : '';

        if ($resolvedUrl !== '') {
            return $resolvedUrl;
        }

        $resolvedSlug = is_string($slug) ? trim($slug) : '';

        if ($resolvedSlug === '') {
            return null;
        }

        return match ($resolvedSlug) {
            'privacy-policy' => route('legal.privacy'),
            'terms-and-conditions' => route('legal.terms'),
            default => '/'.$resolvedSlug,
        };
    }

    private function resolveFooterIcon(?string $icon): string
    {
        $resolved = strtolower(trim((string) $icon));

        return match ($resolved) {
            '', 'unknown' => 'link',
            'email' => 'alternate_email',
            default => $resolved,
        };
    }
}
