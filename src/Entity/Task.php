<?php

declare(strict_types=1);

namespace Aeglio\Entity;

final readonly class Task
{
    private function __construct(
        public int $id,
        public string $reference,
        public int $projectId,
        public ?int $parentId,
        public string $title,
        public ?string $description,
        public string $descriptionFormat,
        public string $type,
        public string $priority,
        public ?string $statusId,
        public ?string $assigneeId,
        public ?int $categoryId,
        public ?string $plannedStart,
        public ?string $dueDate,
        public ?int $estimatedMinutes,
        public int $version,
        public int $position,
        public ?string $completedAt,
        public ?string $archivedAt,
        public array $labelIds,
        public ?string $createdAt,
        public ?string $updatedAt,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) ($data['id'] ?? 0),
            reference: (string) ($data['reference'] ?? ''),
            projectId: (int) ($data['project_id'] ?? 0),
            parentId: isset($data['parent_id']) ? (int) $data['parent_id'] : null,
            title: (string) ($data['title'] ?? ''),
            description: isset($data['description']) ? (string) $data['description'] : null,
            descriptionFormat: (string) ($data['description_format'] ?? ''),
            type: (string) ($data['type'] ?? ''),
            priority: (string) ($data['priority'] ?? ''),
            statusId: isset($data['status_id']) ? (string) $data['status_id'] : null,
            assigneeId: isset($data['assignee_id']) ? (string) $data['assignee_id'] : null,
            categoryId: isset($data['category_id']) ? (int) $data['category_id'] : null,
            plannedStart: isset($data['planned_start']) ? (string) $data['planned_start'] : null,
            dueDate: isset($data['due_date']) ? (string) $data['due_date'] : null,
            estimatedMinutes: isset($data['estimated_minutes']) ? (int) $data['estimated_minutes'] : null,
            version: (int) ($data['version'] ?? 0),
            position: (int) ($data['position'] ?? 0),
            completedAt: isset($data['completed_at']) ? (string) $data['completed_at'] : null,
            archivedAt: isset($data['archived_at']) ? (string) $data['archived_at'] : null,
            labelIds: (array) ($data['label_ids'] ?? []),
            createdAt: isset($data['created_at']) ? (string) $data['created_at'] : null,
            updatedAt: isset($data['updated_at']) ? (string) $data['updated_at'] : null,
        );
    }
}
