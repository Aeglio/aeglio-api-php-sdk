<?php

declare(strict_types=1);

namespace Aeglio\Entity;

use Aeglio\Aeglio;
use Aeglio\Dto\UpdateProjectData;

final readonly class Project
{
    private function __construct(
        private Aeglio $client,
        public int $id,
        public ?int $clientId,
        public string $name,
        public string $type,
        public ?string $code,
        public ?string $notes,
        public bool $archived,
        public ?string $startAt,
        public ?string $endAt,
        public ?string $budgetType,
        public float|int|null $budgetTotal,
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
            clientId: isset($data['client_id']) ? (int) $data['client_id'] : null,
            name: (string) $data['name'],
            type: (string) $data['type'],
            code: $data['code'] ?? null,
            notes: $data['notes'] ?? null,
            archived: (bool) $data['archived'],
            startAt: $data['start_at'] ?? null,
            endAt: $data['end_at'] ?? null,
            budgetType: $data['budget_type'] ?? null,
            budgetTotal: isset($data['budget_total']) ? (float) $data['budget_total'] : null,
            createdAt: $data['created_at'] ?? null,
            updatedAt: $data['updated_at'] ?? null,
        );
    }

    public function update(UpdateProjectData $data): self
    {
        return $this->client->projects()->update($this->id, $data);
    }

    public function delete(): void
    {
        $this->client->projects()->delete($this->id);
    }
}
