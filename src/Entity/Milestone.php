<?php

declare(strict_types=1);

namespace Aeglio\Entity;

final readonly class Milestone
{
    private function __construct(
        public string $id,
        public int $projectId,
        public string $name,
        public ?string $description,
        public ?string $dueDate,
        public ?string $ownerId,
        public string $state,
        public int $version,
        public ?string $achievedAt,
        public MilestoneProgress $progress,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (string) ($data['id'] ?? ''),
            projectId: (int) ($data['project_id'] ?? 0),
            name: (string) ($data['name'] ?? ''),
            description: isset($data['description']) ? (string) $data['description'] : null,
            dueDate: isset($data['due_date']) ? (string) $data['due_date'] : null,
            ownerId: isset($data['owner_id']) ? (string) $data['owner_id'] : null,
            state: (string) ($data['state'] ?? ''),
            version: (int) ($data['version'] ?? 0),
            achievedAt: isset($data['achieved_at']) ? (string) $data['achieved_at'] : null,
            progress: MilestoneProgress::fromArray($data['progress'] ?? []),
        );
    }
}
