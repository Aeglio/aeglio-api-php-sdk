<?php

declare(strict_types=1);
namespace Aeglio\Dto;

use Aeglio\Support\Optional;

final readonly class TimeEntryData
{
    public function __construct(
        public string $operationId,
        public string $issuedAt,
        public string $expiresAt,
        public int $projectId,
        public int $categoryId,
        public string $description,
        public string $date,
        public int $durationMinutes,
        public int|null|Optional $workItemId = new Optional(),
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'operation_id' => $this->operationId,
            'issued_at' => $this->issuedAt,
            'expires_at' => $this->expiresAt,
            'project_id' => $this->projectId,
            'category_id' => $this->categoryId,
            'description' => $this->description,
            'date' => $this->date,
            'duration_minutes' => $this->durationMinutes,
            'work_item_id' => $this->workItemId,
        ], static fn (mixed $value): bool => !$value instanceof Optional);
    }
}
