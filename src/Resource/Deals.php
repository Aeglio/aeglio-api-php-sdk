<?php

declare(strict_types=1);

namespace Aeglio\Resource;

final class Deals extends BaseResource
{
    /** @return \Aeglio\Collection\PaginatedResult<\Aeglio\Entity\Deal> */
    public function list(int $perPage = 50, int $page = 1): \Aeglio\Collection\PaginatedResult
    {
        return $this->paginated("deals", ['per_page' => $perPage, 'page' => $page], fn (array $row) => \Aeglio\Entity\Deal::fromArray($row));
    }

    public function find(int $id): \Aeglio\Entity\Deal
    {
        $response = $this->http->json('GET', "deals/{$id}");
        return \Aeglio\Entity\Deal::fromArray($response['data']);
    }

    public function create(\Aeglio\Dto\DealData $data): \Aeglio\Entity\Deal
    {
        $response = $this->http->json('POST', "deals", json: $data->toArray());
        return \Aeglio\Entity\Deal::fromArray($response['data']);
    }

    public function update(int $id, \Aeglio\Dto\UpdateDealData $data): \Aeglio\Entity\Deal
    {
        $response = $this->http->json('PATCH', "deals/{$id}", json: $data->toArray());
        return \Aeglio\Entity\Deal::fromArray($response['data']);
    }

    public function delete(int $id): void
    {
        $this->http->json('DELETE', "deals/{$id}");
    }

    public function outcome(int $id, string $state): \Aeglio\Entity\Deal
    {
        $response = $this->http->json('POST', "deals/{$id}/outcome", json: ['state' => $state]);
        return \Aeglio\Entity\Deal::fromArray($response['data']);
    }

    /** @return list<\Aeglio\Entity\Person> */
    public function owners(): array
    {
        $response = $this->http->json('GET', "deal-owners");
        return array_map(\Aeglio\Entity\Person::fromArray(...), $response['data']);
    }

    /** @return \Aeglio\Collection\PaginatedResult<\Aeglio\Entity\DealContact> */
    public function contacts(int $clientId, int $perPage = 50, int $page = 1): \Aeglio\Collection\PaginatedResult
    {
        return $this->paginated("deal-clients/{$clientId}/contacts", ['per_page' => $perPage, 'page' => $page], \Aeglio\Entity\DealContact::fromArray(...));
    }
}
