<?php

declare(strict_types=1);

namespace Aeglio\Entity;

use Aeglio\Aeglio;
use Aeglio\Dto\UpdateClientData;

final readonly class Client
{
    private function __construct(
        private Aeglio $client,
        public int $id,
        public string $name,
        public ?string $regCode,
        public ?string $address,
        public ?string $notes,
        public string $locale,
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
            regCode: $data['reg_code'] ?? null,
            address: $data['address'] ?? null,
            notes: $data['notes'] ?? null,
            locale: (string) $data['locale'],
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
