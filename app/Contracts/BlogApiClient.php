<?php

declare(strict_types=1);

namespace App\Contracts;

interface BlogApiClient
{
    /**
     * @return array<string, mixed>
     */
    public function get(string $path, array $query = []): array;

    /**
     * @return array<string, mixed>
     */
    public function post(string $path, array $body = []): array;
}
