<?php

declare(strict_types=1);

namespace Aeglio\Resource;

final class Documents extends BaseResource
{
    /** @return \Aeglio\Collection\PaginatedResult<\Aeglio\Entity\Document> */
    public function list(int $perPage = 50, int $page = 1): \Aeglio\Collection\PaginatedResult
    {
        return $this->paginated("documents", ['per_page' => $perPage, 'page' => $page], fn (array $row) => \Aeglio\Entity\Document::fromArray($row));
    }

    public function find(int $id): \Aeglio\Entity\Document
    {
        $response = $this->http->json('GET', "documents/{$id}");
        return \Aeglio\Entity\Document::fromArray($response['data']);
    }
}
