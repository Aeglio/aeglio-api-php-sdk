<?php

declare(strict_types=1);

namespace Aeglio\Entity;

use Aeglio\Aeglio;
use Aeglio\Dto\UpdateTaxRateData;

final readonly class TaxRate
{
    private function __construct(
        private Aeglio $client,
        public int $id,
        public string $title,
        public float $percentage,
        public bool $default,
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
            title: (string) $data['title'],
            percentage: (float) $data['percentage'],
            default: (bool) $data['default'],
            createdAt: $data['created_at'] ?? null,
            updatedAt: $data['updated_at'] ?? null,
        );
    }

    public function update(UpdateTaxRateData $data): self
    {
        return $this->client->taxRates()->update($this->id, $data);
    }

    public function delete(): void
    {
        $this->client->taxRates()->delete($this->id);
    }
}
