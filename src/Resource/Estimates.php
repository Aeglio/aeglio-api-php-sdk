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

    /** @return list<\Aeglio\Entity\Recipient> */
    public function recipients(int $id): array
    {
        $response = $this->http->json('GET', "estimates/{$id}/recipients");
        return array_map(\Aeglio\Entity\Recipient::fromArray(...), $response['data']);
    }

    public function create(\Aeglio\Dto\EstimateData $data): \Aeglio\Entity\Estimate
    {
        $response = $this->http->json('POST', "estimates", json: $data->toArray());
        return \Aeglio\Entity\Estimate::fromArray($response['data']);
    }

    public function update(int $id, \Aeglio\Dto\UpdateEstimateData $data): \Aeglio\Entity\Estimate
    {
        $response = $this->http->json('PATCH', "estimates/{$id}", json: $data->toArray());
        return \Aeglio\Entity\Estimate::fromArray($response['data']);
    }

    public function delete(int $id): void
    {
        $this->http->json('DELETE', "estimates/{$id}");
    }

    public function duplicate(int $id, string $operationId): \Aeglio\Entity\Estimate
    {
        $response = $this->http->json('POST', "estimates/{$id}/duplicate", json: ['operation_id' => $operationId]);
        return \Aeglio\Entity\Estimate::fromArray($response['data']);
    }

    public function revision(int $id, string $operationId): \Aeglio\Entity\Estimate
    {
        $response = $this->http->json('POST', "estimates/{$id}/revision", json: ['operation_id' => $operationId]);
        return \Aeglio\Entity\Estimate::fromArray($response['data']);
    }

    public function cancel(int $id): \Aeglio\Entity\Estimate
    {
        $response = $this->http->json('POST', "estimates/{$id}/cancel");
        return \Aeglio\Entity\Estimate::fromArray($response['data']);
    }

    public function markAsSent(int $id): \Aeglio\Entity\Estimate
    {
        $response = $this->http->json('POST', "estimates/{$id}/mark-as-sent");
        return \Aeglio\Entity\Estimate::fromArray($response['data']);
    }

    public function recordAcceptance(int $id, string $acceptanceDate, ?string $acceptanceNote = null): \Aeglio\Entity\Estimate
    {
        $response = $this->http->json('POST', "estimates/{$id}/acceptance", json: ['acceptance_date' => $acceptanceDate, 'acceptance_note' => $acceptanceNote]);
        return \Aeglio\Entity\Estimate::fromArray($response['data']);
    }

    public function send(int $id, \Aeglio\Dto\SendEstimateData $data): \Aeglio\Entity\Estimate
    {
        $response = $this->http->json('POST', "estimates/{$id}/send", json: $data->toArray());
        return \Aeglio\Entity\Estimate::fromArray($response['data']);
    }

    public function convertToInvoice(int $id, string $operationId): \Aeglio\Entity\Invoice
    {
        $response = $this->http->json('POST', "estimates/{$id}/convert/invoice", json: ['operation_id' => $operationId]);
        return \Aeglio\Entity\Invoice::fromArray($this->client, $response['data']);
    }

    public function convertToProject(int $id, string $operationId, array $rows = []): \Aeglio\Entity\Project
    {
        $response = $this->http->json('POST', "estimates/{$id}/convert/project", json: ['operation_id' => $operationId, 'rows' => $rows]);
        return \Aeglio\Entity\Project::fromArray($this->client, $response['data']);
    }
}
