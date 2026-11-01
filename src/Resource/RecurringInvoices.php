<?php

declare(strict_types=1);

namespace Aeglio\Resource;

final class RecurringInvoices extends BaseResource
{
    /** @return \Aeglio\Collection\PaginatedResult<\Aeglio\Entity\RecurringInvoice> */
    public function list(int $perPage = 50, int $page = 1): \Aeglio\Collection\PaginatedResult
    {
        return $this->paginated("recurring-invoices", ['per_page' => $perPage, 'page' => $page], fn (array $row) => \Aeglio\Entity\RecurringInvoice::fromArray($this->client, $row));
    }

    public function find(int $id): \Aeglio\Entity\RecurringInvoice
    {
        $response = $this->http->json('GET', "recurring-invoices/{$id}");
        return \Aeglio\Entity\RecurringInvoice::fromArray($this->client, $response['data']);
    }

    public function create(\Aeglio\Dto\RecurringInvoiceData $data): \Aeglio\Entity\RecurringInvoice
    {
        $response = $this->http->json('POST', "recurring-invoices", json: $data->toArray());
        return \Aeglio\Entity\RecurringInvoice::fromArray($this->client, $response['data']);
    }

    public function update(int $id, \Aeglio\Dto\UpdateRecurringInvoiceData $data): \Aeglio\Entity\RecurringInvoice
    {
        $response = $this->http->json('PATCH', "recurring-invoices/{$id}", json: $data->toArray());
        return \Aeglio\Entity\RecurringInvoice::fromArray($this->client, $response['data']);
    }

    public function delete(int $id): void
    {
        $this->http->json('DELETE', "recurring-invoices/{$id}");
    }

    /** @return list<\Aeglio\Entity\Recipient> */
    public function recipients(int $id): array
    {
        $response = $this->http->json('GET', "recurring-invoices/{$id}/recipients");
        return array_map(\Aeglio\Entity\Recipient::fromArray(...), $response['data']);
    }

    /** @return \Aeglio\Collection\PaginatedResult<\Aeglio\Entity\Invoice> */
    public function invoices(int $id, int $perPage = 50, int $page = 1): \Aeglio\Collection\PaginatedResult
    {
        return $this->paginated("recurring-invoices/{$id}/invoices", ['per_page' => $perPage, 'page' => $page], fn (array $row) => \Aeglio\Entity\Invoice::fromArray($this->client, $row));
    }

    /** @return \Aeglio\Collection\PaginatedResult<\Aeglio\Entity\RecurringInvoiceCharge> */
    public function charges(int $id, int $perPage = 50, int $page = 1): \Aeglio\Collection\PaginatedResult
    {
        return $this->paginated("recurring-invoices/{$id}/charges", ['per_page' => $perPage, 'page' => $page], fn (array $row) => \Aeglio\Entity\RecurringInvoiceCharge::fromArray($row));
    }

    public function charge(int $id, string $chargeId): \Aeglio\Entity\RecurringInvoiceCharge
    {
        $response = $this->http->json('GET', "recurring-invoices/{$id}/charges/{$chargeId}");
        return \Aeglio\Entity\RecurringInvoiceCharge::fromArray($response['data']);
    }

    public function createCharge(int $id, \Aeglio\Dto\RecurringInvoiceChargeData $data): \Aeglio\Entity\RecurringInvoiceCharge
    {
        $response = $this->http->json('POST', "recurring-invoices/{$id}/charges", json: $data->toArray());
        return \Aeglio\Entity\RecurringInvoiceCharge::fromArray($response['data']);
    }

    public function updateCharge(int $id, string $chargeId, \Aeglio\Dto\UpdateRecurringInvoiceChargeData $data): \Aeglio\Entity\RecurringInvoiceCharge
    {
        $response = $this->http->json('PATCH', "recurring-invoices/{$id}/charges/{$chargeId}", json: $data->toArray());
        return \Aeglio\Entity\RecurringInvoiceCharge::fromArray($response['data']);
    }

    public function cancelCharge(int $id, string $chargeId, int $version): \Aeglio\Entity\RecurringInvoiceCharge
    {
        $response = $this->http->json('POST', "recurring-invoices/{$id}/charges/{$chargeId}/cancel", json: ['version' => $version]);
        return \Aeglio\Entity\RecurringInvoiceCharge::fromArray($response['data']);
    }

    /** @return array{state:string, items:list<array{values:array<string,string>, texts:array<string,string>, unknown:list<string>}>} */
    public function preview(int $id): array
    {
        return $this->http->json('GET', "recurring-invoices/{$id}/preview")['data'];
    }
}
