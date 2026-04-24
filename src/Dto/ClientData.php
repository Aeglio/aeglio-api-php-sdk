<?php

declare(strict_types=1);

namespace Aeglio\Dto;

final readonly class ClientData
{
    public function __construct(
        public string $name,
        public string $locale,
        public ?string $regCode = null,
        public ?string $address = null,
        public ?string $notes = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'locale' => $this->locale,
            'reg_code' => $this->regCode,
            'address' => $this->address,
            'notes' => $this->notes,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
