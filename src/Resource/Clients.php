<?php

declare(strict_types=1);

namespace Aeglio\Resource;

use Aeglio\Collection\PaginatedResult;
use Aeglio\Dto\ClientData;
use Aeglio\Dto\UpdateClientData;
use Aeglio\Entity\Client;

final class Clients extends BaseResource
{
    /**
     * @return PaginatedResult<Client>
     */
    public function list(int $perPage = 50, int $page = 1): PaginatedResult
    {
        return $this->paginated(
            path: 'clients',
            query: [
                'per_page' => $perPage,
                'page' => $page,
            ],
            mapper: fn (array $item): Client => Client::fromArray($this->client, $item),
        );
    }

    public function find(int $id): Client
    {
        $response = $this->http->json('GET', 'clients/'.$id);

        return Client::fromArray($this->client, $response['data']);
    }

    public function create(ClientData $data): Client
    {
        $response = $this->http->json('POST', 'clients', json: $data->toArray());

        return Client::fromArray($this->client, $response['data']);
    }

    public function update(int $id, UpdateClientData $data): Client
    {
        $response = $this->http->json('PATCH', 'clients/'.$id, json: $data->toArray());

        return Client::fromArray($this->client, $response['data']);
    }

    public function delete(int $id): void
    {
        $this->http->json('DELETE', 'clients/'.$id);
    }
}
