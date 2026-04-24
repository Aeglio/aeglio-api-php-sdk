<?php

declare(strict_types=1);

namespace Aeglio\Dto;

final readonly class ExpenseCategoryData
{
    public function __construct(
        public string $name,
        public ?bool $isGos = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'is_gos' => $this->isGos,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
