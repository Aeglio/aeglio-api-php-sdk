<?php

declare(strict_types=1);

namespace Aeglio\Entity;

final readonly class EstimateRow
{
    private function __construct(
        public int $id,
        public string $title,
        public ?string $description,
        public float $quantity,
        public ?string $unit,
        public float $price,
        public ?int $taxRateId,
        public int $position,
        public ?string $unitPlural,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            unitPlural: $data['unit_plural'] ?? null,
            id: (int) ($data['id'] ?? 0),
            title: (string) ($data['title'] ?? ''),
            description: isset($data['description']) ? (string) $data['description'] : null,
            quantity: (float) ($data['quantity'] ?? 0.0),
            unit: isset($data['unit']) ? (string) $data['unit'] : null,
            price: (float) ($data['price'] ?? 0.0),
            taxRateId: isset($data['tax_rate_id']) ? (int) $data['tax_rate_id'] : null,
            position: (int) ($data['position'] ?? 0),
        );
    }
}
