<?php

declare(strict_types=1);

namespace Aeglio\Entity;

final readonly class RecurringInvoiceCharge
{
    private function __construct(
        public string $id,
        public int $scheduleId,
        public string $title,
        public ?string $description,
        public float $quantity,
        public ?string $unit,
        public float $price,
        public string $currency,
        public ?int $taxRateId,
        public ?float $taxPercentage,
        public string $state,
        public int $version,
        public ?int $consumedInvoiceId,
        public ?string $consumedAt,
        public ?string $cancelledAt,
        public ?string $unitPlural,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            unitPlural: $data['unit_plural'] ?? null,
            id: (string) ($data['id'] ?? ''),
            scheduleId: (int) ($data['schedule_id'] ?? 0),
            title: (string) ($data['title'] ?? ''),
            description: isset($data['description']) ? (string) $data['description'] : null,
            quantity: (float) ($data['quantity'] ?? 0.0),
            unit: isset($data['unit']) ? (string) $data['unit'] : null,
            price: (float) ($data['price'] ?? 0.0),
            currency: (string) ($data['currency'] ?? ''),
            taxRateId: isset($data['tax_rate_id']) ? (int) $data['tax_rate_id'] : null,
            taxPercentage: isset($data['tax_percentage']) ? (float) $data['tax_percentage'] : null,
            state: (string) ($data['state'] ?? ''),
            version: (int) ($data['version'] ?? 0),
            consumedInvoiceId: isset($data['consumed_invoice_id']) ? (int) $data['consumed_invoice_id'] : null,
            consumedAt: isset($data['consumed_at']) ? (string) $data['consumed_at'] : null,
            cancelledAt: isset($data['cancelled_at']) ? (string) $data['cancelled_at'] : null,
        );
    }
}
