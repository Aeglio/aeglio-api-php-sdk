<?php

declare(strict_types=1);

namespace Aeglio\Entity;

use Aeglio\Aeglio;
use Aeglio\Collection\PaginatedResult;
use Aeglio\Dto\InvoicePaymentData;
use Aeglio\Dto\SendInvoiceData;
use Aeglio\Dto\UpdateInvoiceData;

final readonly class Invoice
{
    /**
     * @param list<InvoiceRow> $rows
     * @param list<InvoicePayment> $payments
     */
    private function __construct(
        private Aeglio $client,
        public int $id,
        public int $clientId,
        public string $number,
        public ?string $referenceNumber,
        public string $state,
        public string $issuedAt,
        public ?string $sentAt,
        public string $dueAt,
        public ?string $notes,
        public bool $hasTax,
        public float $subtotal,
        public float $tax,
        public float $total,
        public float $paymentsTotal,
        public float $totalToPay,
        public array $rows,
        public array $payments,
        public ?string $createdAt,
        public ?string $updatedAt,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(Aeglio $client, array $data): self
    {
        return new self(
            client: $client,
            id: (int) $data['id'],
            clientId: (int) $data['client_id'],
            number: (string) $data['number'],
            referenceNumber: $data['reference_number'] ?? null,
            state: (string) $data['state'],
            issuedAt: (string) $data['issued_at'],
            sentAt: $data['sent_at'] ?? null,
            dueAt: (string) $data['due_at'],
            notes: $data['notes'] ?? null,
            hasTax: (bool) $data['has_tax'],
            subtotal: (float) $data['subtotal'],
            tax: (float) $data['tax'],
            total: (float) $data['total'],
            paymentsTotal: (float) $data['payments_total'],
            totalToPay: (float) $data['total_to_pay'],
            rows: array_map(
                static fn (array $row): InvoiceRow => InvoiceRow::fromArray($row),
                is_array($data['rows'] ?? null) ? $data['rows'] : [],
            ),
            payments: array_map(
                static fn (array $payment): InvoicePayment => InvoicePayment::fromArray($client, $payment),
                is_array($data['payments'] ?? null) ? $data['payments'] : [],
            ),
            createdAt: $data['created_at'] ?? null,
            updatedAt: $data['updated_at'] ?? null,
        );
    }

    public function addPayment(InvoicePaymentData $data): InvoicePayment
    {
        return $this->client->invoices()->addPayment($this->id, $data);
    }

    public function update(UpdateInvoiceData $data): self
    {
        return $this->client->invoices()->update($this->id, $data);
    }

    public function delete(): void
    {
        $this->client->invoices()->delete($this->id);
    }

    /**
     * @return PaginatedResult<InvoicePayment>
     */
    public function payments(int $perPage = 50, int $page = 1): PaginatedResult
    {
        return $this->client->invoices()->listPayments(
            invoiceId: $this->id,
            perPage: $perPage,
            page: $page,
        );
    }

    public function send(SendInvoiceData $data): SendInvoiceResult
    {
        return $this->client->invoices()->send($this->id, $data);
    }

    public function downloadPdf(): string
    {
        return $this->client->invoices()->downloadPdf($this->id);
    }
}
