<?php

declare(strict_types=1);

namespace Aeglio\Resource;

final class Approvals extends BaseResource
{
    /** @return \Aeglio\Collection\PaginatedResult<\Aeglio\Entity\Approval> */
    public function list(int $perPage = 50, int $page = 1): \Aeglio\Collection\PaginatedResult
    {
        return $this->paginated("approvals", ['per_page' => $perPage, 'page' => $page], fn (array $row) => \Aeglio\Entity\Approval::fromArray($row));
    }

    public function find(int $id): \Aeglio\Entity\Approval
    {
        $response = $this->http->json('GET', "approvals/{$id}");
        return \Aeglio\Entity\Approval::fromArray($response['data']);
    }

    public function approve(int $id, ?string $comment = null): \Aeglio\Entity\Approval
    {
        $response = $this->http->json('POST', "approvals/{$id}/approve", json: ['comment' => $comment]);
        return \Aeglio\Entity\Approval::fromArray($response['data']);
    }

    public function reject(int $id, ?string $comment = null): \Aeglio\Entity\Approval
    {
        $response = $this->http->json('POST', "approvals/{$id}/reject", json: ['comment' => $comment]);
        return \Aeglio\Entity\Approval::fromArray($response['data']);
    }
}
