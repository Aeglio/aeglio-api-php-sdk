<?php

declare(strict_types=1);

namespace Aeglio\Dto;

use Aeglio\Support\Optional;

final readonly class UpdateTaskData
{
    public function __construct(
        public int $version,
        public string|Optional $title = new Optional(),
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
        public array|Optional $acknowledgements = new Optional(),
    ) {
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return array_filter([
            'version' => $this->version,
            'title' => $this->title,
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
            'acknowledgements' => $this->acknowledgements,
        ], static fn (mixed $value): bool => ! $value instanceof Optional);
    }
}
