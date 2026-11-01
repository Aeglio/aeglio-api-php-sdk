<?php

declare(strict_types=1);

namespace Aeglio\Dto;

final readonly class EstimateRowData
{
    public function __construct(
        public string $title,
        public float $quantity,
        public float $price,
        public ?string $description = null,
        public ?string $unit = null,
        public ?int $taxRateId = null,
        public ?int $articleId = null,
        public ?string $unitPlural = null,
    ) {
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return ['unit_plural' => $this->unitPlural, 'title' => $this->title, 'quantity' => $this->quantity, 'price' => $this->price,
            'description' => $this->description, 'unit' => $this->unit, 'tax_rate_id' => $this->taxRateId, 'article_id' => $this->articleId];
    }
}
