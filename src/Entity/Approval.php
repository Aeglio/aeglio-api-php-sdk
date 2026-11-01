<?php

declare(strict_types=1);

namespace Aeglio\Entity;

final readonly class Approval
{
    /** @param list<ApprovalAssignment> $assignments */
    private function __construct(
        public int $id,
        public int $workflowId,
        public ?string $workflowName,
        public string $reviewableType,
        public int $reviewableId,
        public string $state,
        public ?int $currentStepId,
        public ?string $currentStepName,
        public ?int $submittedByUserId,
        public ?string $submittedAt,
        public ?string $decidedAt,
        public array $assignments,
        public ?string $createdAt,
        public ?string $updatedAt,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) ($data['id'] ?? 0),
            workflowId: (int) ($data['workflow_id'] ?? 0),
            workflowName: isset($data['workflow_name']) ? (string) $data['workflow_name'] : null,
            reviewableType: (string) ($data['reviewable_type'] ?? ''),
            reviewableId: (int) ($data['reviewable_id'] ?? 0),
            state: (string) ($data['state'] ?? ''),
            currentStepId: isset($data['current_step_id']) ? (int) $data['current_step_id'] : null,
            currentStepName: isset($data['current_step_name']) ? (string) $data['current_step_name'] : null,
            submittedByUserId: isset($data['submitted_by_user_id']) ? (int) $data['submitted_by_user_id'] : null,
            submittedAt: isset($data['submitted_at']) ? (string) $data['submitted_at'] : null,
            decidedAt: isset($data['decided_at']) ? (string) $data['decided_at'] : null,
            assignments: array_map(ApprovalAssignment::fromArray(...), $data['assignments'] ?? []),
            createdAt: isset($data['created_at']) ? (string) $data['created_at'] : null,
            updatedAt: isset($data['updated_at']) ? (string) $data['updated_at'] : null,
        );
    }
}
