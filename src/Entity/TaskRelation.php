<?php

declare(strict_types=1);

namespace Aeglio\Entity;

final readonly class TaskRelation
{
    private function __construct(
        public int $taskId,
        public string $direction,
        public Task $task,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            taskId: (int) ($data['task_id'] ?? 0),
            direction: (string) ($data['direction'] ?? ''),
            task: Task::fromArray($data['task'] ?? []),
        );
    }
}
