<?php

declare(strict_types=1);

namespace Aeglio\Entity;

use Aeglio\Aeglio;
use Aeglio\Dto\UpdateClientData;

final readonly class Client
{
    /**
     * @param list<string> $matchAliases
     */
    private function __construct(
        private Aeglio $client,
        public int $id,
        public string $name,
        public ?string $email,
        public ?string $regCode,
        public ?string $countryCode,
        public ?string $vatNumber,
        public ?string $address,
        public ?string $city,
        public ?string $postalCode,
        public ?string $stateRegion,
        public ?string $notes,
        public string $locale,
        public ?string $paymentRecipientName,
        public ?string $paymentRecipientIban,
        public array $matchAliases,
        public ?bool $isClient,
        public ?bool $isSupplier,
        public ?string $createdAt,
        public ?string $updatedAt,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(Aeglio $client, array $data): self
    {
        return new self(
            client: $client,
            id: (int) $data['id'],
            name: (string) $data['name'],
            email: $data['email'] ?? null,
            regCode: $data['reg_code'] ?? null,
            countryCode: $data['country_code'] ?? null,
            vatNumber: $data['vat_number'] ?? null,
            address: $data['address'] ?? null,
            city: $data['city'] ?? null,
            postalCode: $data['postal_code'] ?? null,
            stateRegion: $data['state_region'] ?? null,
            notes: $data['notes'] ?? null,
            locale: (string) $data['locale'],
            paymentRecipientName: $data['payment_recipient_name'] ?? null,
            paymentRecipientIban: $data['payment_recipient_iban'] ?? null,
            matchAliases: array_values(array_filter(
                is_array($data['match_aliases'] ?? null) ? $data['match_aliases'] : [],
                static fn (mixed $value): bool => is_string($value),
            )),
            isClient: isset($data['is_client']) ? (bool) $data['is_client'] : null,
            isSupplier: isset($data['is_supplier']) ? (bool) $data['is_supplier'] : null,
            createdAt: $data['created_at'] ?? null,
            updatedAt: $data['updated_at'] ?? null,
        );
    }

    public function update(UpdateClientData $data): self
    {
        return $this->client->clients()->update($this->id, $data);
    }

    public function delete(): void
    {
        $this->client->clients()->delete($this->id);
    }
}
