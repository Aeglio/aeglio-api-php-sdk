<?php

declare(strict_types=1);
namespace Aeglio\Dto;

use Aeglio\Support\Optional;

final readonly class UpdateTimeData
{
    public function __construct(
        public string $operationId,
        public string $issuedAt,
        public string $expiresAt,
        public int $version,
        public int|Optional $projectId = new Optional(),
        public int|Optional $categoryId = new Optional(),
        public string|Optional $description = new Optional(),
        public string|Optional $date = new Optional(),
        public int|Optional $durationMinutes = new Optional(),
        public int|Optional $revision = new Optional(),
        public int|null|Optional $workItemId = new Optional(),
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'operation_id' => $this->operationId,
            'issued_at' => $this->issuedAt,
            'expires_at' => $this->expiresAt,
            'version' => $this->version,
            'revision' => $this->revision,
            'project_id' => $this->projectId,
            'category_id' => $this->categoryId,
            'description' => $this->description,
            'date' => $this->date,
            'duration_minutes' => $this->durationMinutes,
            'work_item_id' => $this->workItemId,
        ], static fn (mixed $value): bool => !$value instanceof Optional);
    }
}
