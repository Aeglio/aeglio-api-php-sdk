<?php

declare(strict_types=1);

namespace Aeglio\Dto;

use Aeglio\Support\Optional;

final readonly class UpdateClientData
{
    public function __construct(
        public string|Optional $name = new Optional(),
        public string|Optional $locale = new Optional(),
        public string|null|Optional $email = new Optional(),
        public string|null|Optional $regCode = new Optional(),
        public string|null|Optional $countryCode = new Optional(),
        public string|null|Optional $vatNumber = new Optional(),
        public string|null|Optional $address = new Optional(),
        public string|null|Optional $city = new Optional(),
        public string|null|Optional $postalCode = new Optional(),
        public string|null|Optional $stateRegion = new Optional(),
        public string|null|Optional $notes = new Optional(),
        public string|null|Optional $paymentRecipientName = new Optional(),
        public string|null|Optional $paymentRecipientIban = new Optional(),
        public array|null|Optional $matchAliases = new Optional(),
        public bool|null|Optional $isClient = new Optional(),
        public bool|null|Optional $isSupplier = new Optional(),
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $payload = [];

        foreach ([
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
        ] as $key => $value) {
            if (!$value instanceof Optional) {
                $payload[$key] = $value;
            }
        }

        return $payload;
    }
}
