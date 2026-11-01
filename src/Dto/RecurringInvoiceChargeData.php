<?php

declare(strict_types=1);

namespace Aeglio\Dto;

use Aeglio\Support\Optional;

final readonly class RecurringInvoiceChargeData
{
    public function __construct(
        public string $title,
        public string $targetDate,
        public string $operationId,
        public string|null|Optional $description = new Optional(),
        public float|Optional $quantity = new Optional(),
        public string|null|Optional $unit = new Optional(),
        public float|Optional $price = new Optional(),
        public int|null|Optional $taxRateId = new Optional(),
    ) {
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return array_filter([
            'title' => $this->title,
            'target_date' => $this->targetDate,
            'operation_id' => $this->operationId,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'unit' => $this->unit,
            'price' => $this->price,
            'tax_rate_id' => $this->taxRateId,
        ], static fn (mixed $value): bool => ! $value instanceof Optional);
    }
}
