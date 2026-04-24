<?php

declare(strict_types=1);

namespace Aeglio\Dto;

final readonly class InvoiceRowData
{
    public function __construct(
        public string $type,
        public float $quantity,
        public float $price,
        public ?string $title = null,
        public ?string $description = null,
        public ?int $taxRateId = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'type' => $this->type,
            'title' => $this->title,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'tax_rate_id' => $this->taxRateId,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
