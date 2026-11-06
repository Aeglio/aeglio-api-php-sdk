<?php

declare(strict_types=1);
namespace Aeglio\Dto;

use Aeglio\Support\Optional;

final readonly class StartTimerData
{
    public function __construct(
        public string $operationId,
        public string $issuedAt,
        public string $expiresAt,
        public int $revision,
        public int $projectId,
        public int $categoryId,
        public string $description,
        public int|null|Optional $workItemId = new Optional(),
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'operation_id' => $this->operationId,
            'issued_at' => $this->issuedAt,
            'expires_at' => $this->expiresAt,
            'revision' => $this->revision,
            'project_id' => $this->projectId,
            'category_id' => $this->categoryId,
            'description' => $this->description,
            'work_item_id' => $this->workItemId,
        ], static fn (mixed $value): bool => !$value instanceof Optional);
    }
}
