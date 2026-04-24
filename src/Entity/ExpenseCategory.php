<?php

declare(strict_types=1);

namespace Aeglio\Entity;

use Aeglio\Aeglio;
use Aeglio\Dto\UpdateExpenseCategoryData;

final readonly class ExpenseCategory
{
    private function __construct(
        private Aeglio $client,
        public int $id,
        public string $name,
        public bool $isGos,
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
            isGos: (bool) ($data['is_gos'] ?? false),
            createdAt: $data['created_at'] ?? null,
            updatedAt: $data['updated_at'] ?? null,
        );
    }

    public function update(UpdateExpenseCategoryData $data): self
    {
        return $this->client->expenseCategories()->update($this->id, $data);
    }

    public function delete(): void
    {
        $this->client->expenseCategories()->delete($this->id);
    }
}
