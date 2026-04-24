<?php

declare(strict_types=1);

namespace Aeglio\Entity;

use Aeglio\Aeglio;
use Aeglio\Dto\UpdateInvoicePaymentData;

final readonly class InvoicePayment
{
    private function __construct(
        private Aeglio $client,
        public int $id,
        public ?int $invoiceId,
        public float $sum,
        public ?string $notes,
        public string $paidAt,
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
            invoiceId: isset($data['invoice_id']) ? (int) $data['invoice_id'] : null,
            sum: (float) $data['sum'],
            notes: $data['notes'] ?? null,
            paidAt: (string) $data['paid_at'],
            createdAt: $data['created_at'] ?? null,
            updatedAt: $data['updated_at'] ?? null,
        );
    }

    public function update(UpdateInvoicePaymentData $data): self
    {
        return $this->client->invoices()->updatePayment(
            invoiceId: (int) $this->invoiceId,
            paymentId: $this->id,
            data: $data,
        );
    }

    public function delete(): void
    {
        $this->client->invoices()->deletePayment((int) $this->invoiceId, $this->id);
    }
}
