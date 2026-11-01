<?php

declare(strict_types=1);

namespace Aeglio\Dto;

use Aeglio\Support\Optional;

final readonly class TaskData
{
    public function __construct(
        public int $projectId,
        public string $title,
        public string $operationId,
        public string|null|Optional $description = new Optional(),
        public string|Optional $descriptionFormat = new Optional(),
        public string|Optional $type = new Optional(),
        public string|Optional $priority = new Optional(),
        public string|Optional $statusId = new Optional(),
        public string|null|Optional $assigneeId = new Optional(),
        public int|null|Optional $categoryId = new Optional(),
        public string|null|Optional $plannedStart = new Optional(),
        public string|null|Optional $dueDate = new Optional(),
        public int|null|Optional $estimatedMinutes = new Optional(),
        public array|Optional $labelIds = new Optional(),
    ) {
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return array_filter([
            'project_id' => $this->projectId,
            'title' => $this->title,
            'operation_id' => $this->operationId,
            'description' => $this->description,
            'description_format' => $this->descriptionFormat,
            'type' => $this->type,
            'priority' => $this->priority,
            'status_id' => $this->statusId,
            'assignee_id' => $this->assigneeId,
            'category_id' => $this->categoryId,
            'planned_start' => $this->plannedStart,
            'due_date' => $this->dueDate,
            'estimated_minutes' => $this->estimatedMinutes,
            'label_ids' => $this->labelIds,
        ], static fn (mixed $value): bool => ! $value instanceof Optional);
    }
}
