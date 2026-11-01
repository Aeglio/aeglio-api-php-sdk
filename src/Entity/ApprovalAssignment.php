<?php

declare(strict_types=1);

namespace Aeglio\Entity;

final readonly class ApprovalAssignment
{
    private function __construct(
        public int $id,
        public int $stepId,
        public ?int $assignedToUserId,
        public string $state,
        public ?string $actedAt,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) ($data['id'] ?? 0),
            stepId: (int) ($data['step_id'] ?? 0),
            assignedToUserId: isset($data['assigned_to_user_id']) ? (int) $data['assigned_to_user_id'] : null,
            state: (string) ($data['state'] ?? ''),
            actedAt: isset($data['acted_at']) ? (string) $data['acted_at'] : null,
        );
    }
}
