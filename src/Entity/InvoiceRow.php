<?php

declare(strict_types=1);

namespace Aeglio\Entity;

final readonly class InvoiceRow
{
    private function __construct(
        public int $id,
        public string $type,
        public ?string $title,
        public ?string $description,
        public float $quantity,
        public float $price,
        public ?int $taxRateId,
        public float $subtotal,
        public float $tax,
        public float $total,
        public ?string $createdAt,
        public ?string $updatedAt,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            type: (string) $data['type'],
            title: $data['title'] ?? null,
            description: $data['description'] ?? null,
            quantity: (float) $data['quantity'],
            price: (float) $data['price'],
            taxRateId: isset($data['tax_rate_id']) ? (int) $data['tax_rate_id'] : null,
            subtotal: (float) $data['subtotal'],
            tax: (float) $data['tax'],
            total: (float) $data['total'],
            createdAt: $data['created_at'] ?? null,
            updatedAt: $data['updated_at'] ?? null,
        );
    }
}
