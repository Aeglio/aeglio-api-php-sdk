<?php

declare(strict_types=1);

namespace Aeglio\Dto;

final readonly class ClientData
{
    public function __construct(
        public string $name,
        public string $locale,
        public ?string $regCode = null,
        public ?string $countryCode = null,
        public ?string $vatNumber = null,
        public ?string $address = null,
        public ?string $city = null,
        public ?string $postalCode = null,
        public ?string $stateRegion = null,
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
            'country_code' => $this->countryCode,
            'vat_number' => $this->vatNumber,
            'address' => $this->address,
            'city' => $this->city,
            'postal_code' => $this->postalCode,
            'state_region' => $this->stateRegion,
            'notes' => $this->notes,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
