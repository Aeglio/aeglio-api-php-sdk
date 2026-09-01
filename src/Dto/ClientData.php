<?php

declare(strict_types=1);

namespace Aeglio\Dto;

final readonly class ClientData
{
    public function __construct(
        public string $name,
        public string $locale,
        public ?string $email = null,
        public ?string $regCode = null,
        public ?string $countryCode = null,
        public ?string $vatNumber = null,
        public ?string $address = null,
        public ?string $city = null,
        public ?string $postalCode = null,
        public ?string $stateRegion = null,
        public ?string $notes = null,
        public ?string $paymentRecipientName = null,
        public ?string $paymentRecipientIban = null,
        public ?array $matchAliases = null,
        public ?bool $isClient = null,
        public ?bool $isSupplier = null,
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
            'email' => $this->email,
            'reg_code' => $this->regCode,
            'country_code' => $this->countryCode,
            'vat_number' => $this->vatNumber,
            'address' => $this->address,
            'city' => $this->city,
            'postal_code' => $this->postalCode,
            'state_region' => $this->stateRegion,
            'notes' => $this->notes,
            'payment_recipient_name' => $this->paymentRecipientName,
            'payment_recipient_iban' => $this->paymentRecipientIban,
            'match_aliases' => $this->matchAliases,
            'is_client' => $this->isClient,
            'is_supplier' => $this->isSupplier,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
