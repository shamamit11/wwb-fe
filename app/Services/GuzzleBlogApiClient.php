<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\BlogApiClient;
use App\Exceptions\UpstreamServiceException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class GuzzleBlogApiClient implements BlogApiClient
{
    public function __construct(
        private readonly ClientInterface $client,
    ) {
    }

    public function get(string $path, array $query = []): array
    {
        return $this->request('GET', $path, ['query' => $query]);
    }

    public function post(string $path, array $body = []): array
    {
        return $this->request('POST', $path, ['json' => $body]);
    }

    /**
     * @param  array<string, mixed>  $options
     * @return array<string, mixed>
     */
    private function request(string $method, string $path, array $options = []): array
    {
        try {
            $response = retry(
                (int) config('services.wideweb_blog.retry_times', 2),
                fn () => $this->client->request($method, ltrim($path, '/'), $options),
                (int) config('services.wideweb_blog.retry_sleep_ms', 150),
            );

            /** @var mixed $payload */
            $payload = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } catch (GuzzleException|JsonException $exception) {
            throw new UpstreamServiceException('The blog API request failed.', previous: $exception);
        }

        if (! is_array($payload)) {
            throw new UpstreamServiceException('The blog API response was not a JSON object.');
        }

        return $payload;
    }
}
