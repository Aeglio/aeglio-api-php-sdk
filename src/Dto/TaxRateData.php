<?php

declare(strict_types=1);

namespace Aeglio\Dto;

final readonly class TaxRateData
{
    public function __construct(
        public string $title,
        public float $percentage,
        public ?bool $default = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'title' => $this->title,
            'percentage' => $this->percentage,
            'default' => $this->default,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
