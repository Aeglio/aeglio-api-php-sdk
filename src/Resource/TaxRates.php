<?php

declare(strict_types=1);

namespace Aeglio\Resource;

use Aeglio\Collection\PaginatedResult;
use Aeglio\Dto\TaxRateData;
use Aeglio\Dto\UpdateTaxRateData;
use Aeglio\Entity\TaxRate;

final class TaxRates extends BaseResource
{
    /**
     * @return PaginatedResult<TaxRate>
     */
    public function list(int $perPage = 50, int $page = 1): PaginatedResult
    {
        return $this->paginated(
            path: 'tax-rates',
            query: [
                'per_page' => $perPage,
                'page' => $page,
            ],
            mapper: fn (array $item): TaxRate => TaxRate::fromArray($this->client, $item),
        );
    }

    public function find(int $id): TaxRate
    {
        $response = $this->http->json('GET', 'tax-rates/'.$id);

        return TaxRate::fromArray($this->client, $response['data']);
    }

    public function create(TaxRateData $data): TaxRate
    {
        $response = $this->http->json('POST', 'tax-rates', json: $data->toArray());

        return TaxRate::fromArray($this->client, $response['data']);
    }

    public function update(int $id, UpdateTaxRateData $data): TaxRate
    {
        $response = $this->http->json('PATCH', 'tax-rates/'.$id, json: $data->toArray());

        return TaxRate::fromArray($this->client, $response['data']);
    }

    public function delete(int $id): void
    {
        $this->http->json('DELETE', 'tax-rates/'.$id);
    }
}
