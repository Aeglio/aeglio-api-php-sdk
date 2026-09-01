<?php

declare(strict_types=1);

namespace Aeglio\Dto;

final readonly class InvoiceRowData
{
    /**
     * @param string|null $description Safe HTML supporting p, div, br, strong, b, em, i, u, ul, ol, and li tags.
     */
    public function __construct(
        public string $type,
        public float $quantity,
        public float $price,
        public ?int $id = null,
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
            'id' => $this->id,
            'type' => $this->type,
            'title' => $this->title,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'tax_rate_id' => $this->taxRateId,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
