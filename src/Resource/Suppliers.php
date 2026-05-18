<?php

declare(strict_types=1);

namespace Aeglio\Resource;

use Aeglio\Collection\PaginatedResult;
use Aeglio\Dto\ClientData;
use Aeglio\Dto\UpdateClientData;
use Aeglio\Entity\Supplier;

final class Suppliers extends BaseResource
{
    /**
     * @return PaginatedResult<Supplier>
     */
    public function list(int $perPage = 50, int $page = 1, ?string $search = null): PaginatedResult
    {
        return $this->paginated(
            path: 'suppliers',
            query: [
                'per_page' => $perPage,
                'page' => $page,
                'search' => $search,
            ],
            mapper: fn (array $item): Supplier => Supplier::fromArray($this->client, $item),
        );
    }

    public function find(int $id): Supplier
    {
        $response = $this->http->json('GET', 'suppliers/'.$id);

        return Supplier::fromArray($this->client, $response['data']);
    }

    public function create(ClientData $data): Supplier
    {
        $response = $this->http->json('POST', 'suppliers', json: $data->toArray());

        return Supplier::fromArray($this->client, $response['data']);
    }

    public function update(int $id, UpdateClientData $data): Supplier
    {
        $response = $this->http->json('PATCH', 'suppliers/'.$id, json: $data->toArray());

        return Supplier::fromArray($this->client, $response['data']);
    }

    public function delete(int $id): void
    {
        $this->http->json('DELETE', 'suppliers/'.$id);
    }
}
