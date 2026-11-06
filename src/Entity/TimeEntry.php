<?php

declare(strict_types=1);
namespace Aeglio\Entity;

final readonly class TimeEntry
{
    public function __construct(
        public string $id,
        public int $projectId,
        public int $categoryId,
        public ?int $workItemId,
        public string $description,
        public string $date,
        public string $start,
        public ?string $end,
        public int $durationSeconds,
        public int $version,
        public string $state,
    ) {}
    public static function fromArray(array $data): self
    {
        return new self(
            id: (string) $data['id'],
            projectId: (int) $data['project_id'],
            categoryId: (int) $data['category_id'],
            workItemId: isset($data['work_item_id']) ? (int) $data['work_item_id'] : null,
            description: (string) $data['description'],
            date: (string) $data['date'],
            start: (string) $data['start'],
            end: isset($data['end']) ? (string) $data['end'] : null,
            durationSeconds: (int) $data['duration_seconds'],
            version: (int) $data['version'],
            state: (string) $data['state'],
        );
    }
}
