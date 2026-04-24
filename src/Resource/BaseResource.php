<?php

declare(strict_types=1);

namespace Aeglio\Resource;

use Aeglio\Aeglio;
use Aeglio\Collection\PaginatedResult;
use Aeglio\Http\HttpClient;

abstract class BaseResource
{
    public function __construct(
        protected readonly Aeglio $client,
        protected readonly HttpClient $http,
    ) {
    }

    /**
     * @param array<string, scalar|list<scalar>|null> $query
     * @param callable(array<string, mixed>): object $mapper
     *
     * @return PaginatedResult<object>
     */
    protected function paginated(string $path, array $query, callable $mapper): PaginatedResult
    {
        $response = $this->http->json('GET', $path, $query);
        $items = array_map(
            $mapper,
            is_array($response['data'] ?? null) ? $response['data'] : [],
        );

        $meta = is_array($response['meta'] ?? null) ? $response['meta'] : [];

        return new PaginatedResult(
            items: $items,
            currentPage: (int) ($meta['current_page'] ?? 1),
            perPage: (int) ($meta['per_page'] ?? count($items)),
            total: (int) ($meta['total'] ?? count($items)),
            lastPage: (int) ($meta['last_page'] ?? 1),
        );
    }
}
