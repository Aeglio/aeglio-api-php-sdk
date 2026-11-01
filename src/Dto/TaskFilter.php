<?php

declare(strict_types=1);

namespace Aeglio\Dto;

use Aeglio\Support\Optional;

final readonly class TaskFilter
{
    public function __construct(
        public string|Optional $search = new Optional(),
        public int|Optional $projectId = new Optional(),
        public string|Optional $statusId = new Optional(),
        public string|Optional $assigneeId = new Optional(),
        public string|Optional $labelId = new Optional(),
        public string|Optional $type = new Optional(),
        public string|Optional $priority = new Optional(),
        public bool|Optional $archived = new Optional(),
        public string|Optional $dueFrom = new Optional(),
        public string|Optional $dueTo = new Optional(),
    ) {
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return array_filter([
            'search' => $this->search,
            'project_id' => $this->projectId,
            'status_id' => $this->statusId,
            'assignee_id' => $this->assigneeId,
            'label_id' => $this->labelId,
            'type' => $this->type,
            'priority' => $this->priority,
            'archived' => $this->archived,
            'due_from' => $this->dueFrom,
            'due_to' => $this->dueTo,
        ], static fn (mixed $value): bool => ! $value instanceof Optional);
    }
}
