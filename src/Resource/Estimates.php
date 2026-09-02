<?php

declare(strict_types=1);

namespace Aeglio\Resource;

use Aeglio\Collection\PaginatedResult;
use Aeglio\Entity\Estimate;

final class Estimates extends BaseResource
{
    /** @return PaginatedResult<Estimate> */
    public function list(int $perPage = 50, int $page = 1): PaginatedResult
    {
        return $this->paginated(
            path: 'estimates',
            query: ['per_page' => $perPage, 'page' => $page],
            mapper: fn (array $item): Estimate => Estimate::fromArray($item),
        );
    }

    public function find(int $id): Estimate
    {
        $response = $this->http->json('GET', 'estimates/'.$id);

        return Estimate::fromArray($response['data']);
    }
}
