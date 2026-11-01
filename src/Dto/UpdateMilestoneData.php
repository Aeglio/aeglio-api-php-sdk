<?php

declare(strict_types=1);

namespace Aeglio\Dto;

use Aeglio\Support\Optional;

final readonly class UpdateMilestoneData
{
    public function __construct(
        public int $version,
        public string|Optional $name = new Optional(),
        public string|null|Optional $description = new Optional(),
        public string|null|Optional $dueDate = new Optional(),
        public string|null|Optional $ownerId = new Optional(),
    ) {
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return array_filter([
            'version' => $this->version,
            'name' => $this->name,
            'description' => $this->description,
            'due_date' => $this->dueDate,
            'owner_id' => $this->ownerId,
        ], static fn (mixed $value): bool => ! $value instanceof Optional);
    }
}
