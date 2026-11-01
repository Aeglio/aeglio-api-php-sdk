<?php

declare(strict_types=1);

namespace Aeglio\Dto;

use Aeglio\Support\Optional;

final readonly class MilestoneData
{
    public function __construct(
        public int $projectId,
        public string $name,
        public string $operationId,
        public string|null|Optional $description = new Optional(),
        public string|null|Optional $dueDate = new Optional(),
        public string|null|Optional $ownerId = new Optional(),
    ) {
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return array_filter([
            'project_id' => $this->projectId,
            'name' => $this->name,
            'operation_id' => $this->operationId,
            'description' => $this->description,
            'due_date' => $this->dueDate,
            'owner_id' => $this->ownerId,
        ], static fn (mixed $value): bool => ! $value instanceof Optional);
    }
}
