<?php

declare(strict_types=1);

namespace Aeglio\Dto;

use Aeglio\Support\Optional;

final readonly class UpdateRecurringInvoiceChargeData
{
    public function __construct(
        public int $version,
        public string|Optional $title = new Optional(),
        public string|null|Optional $description = new Optional(),
        public float|Optional $quantity = new Optional(),
        public string|null|Optional $unit = new Optional(),
        public float|Optional $price = new Optional(),
        public int|null|Optional $taxRateId = new Optional(),
        public string|null|Optional $unitPlural = new Optional(),
    ) {
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return array_filter([
            'version' => $this->version,
            'title' => $this->title,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'unit' => $this->unit,
            'price' => $this->price,
            'tax_rate_id' => $this->taxRateId,
            'unit_plural' => $this->unitPlural,
        ], static fn (mixed $value): bool => ! $value instanceof Optional);
    }
}
