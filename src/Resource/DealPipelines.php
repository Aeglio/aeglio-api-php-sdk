<?php

declare(strict_types=1);

namespace Aeglio\Resource;

final class DealPipelines extends BaseResource
{
    /** @return \Aeglio\Collection\PaginatedResult<\Aeglio\Entity\DealPipeline> */
    public function list(int $perPage = 50, int $page = 1): \Aeglio\Collection\PaginatedResult
    {
        return $this->paginated("deal-pipelines", ['per_page' => $perPage, 'page' => $page], fn (array $row) => \Aeglio\Entity\DealPipeline::fromArray($row));
    }

    public function find(int $id): \Aeglio\Entity\DealPipeline
    {
        $response = $this->http->json('GET', "deal-pipelines/{$id}");
        return \Aeglio\Entity\DealPipeline::fromArray($response['data']);
    }
}
