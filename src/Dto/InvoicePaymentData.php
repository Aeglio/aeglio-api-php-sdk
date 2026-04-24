<?php

declare(strict_types=1);

namespace Aeglio\Dto;

final readonly class InvoicePaymentData
{
    public function __construct(
        public float $sum,
        public string $paidAt,
        public ?string $notes = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'sum' => $this->sum,
            'paid_at' => $this->paidAt,
            'notes' => $this->notes,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
