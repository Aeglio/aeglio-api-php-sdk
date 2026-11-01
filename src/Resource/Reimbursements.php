<?php

declare(strict_types=1);

namespace Aeglio\Resource;

final class Reimbursements extends BaseResource
{
    /** @return \Aeglio\Collection\PaginatedResult<\Aeglio\Entity\Reimbursement> */
    public function list(int $perPage = 50, int $page = 1): \Aeglio\Collection\PaginatedResult
    {
        return $this->paginated("reimbursements", ['per_page' => $perPage, 'page' => $page], fn (array $row) => \Aeglio\Entity\Reimbursement::fromArray($row));
    }

    public function find(int $id): \Aeglio\Entity\Reimbursement
    {
        $response = $this->http->json('GET', "reimbursements/{$id}");
        return \Aeglio\Entity\Reimbursement::fromArray($response['data']);
    }
}
