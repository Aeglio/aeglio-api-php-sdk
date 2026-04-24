<?php

declare(strict_types=1);

namespace Aeglio\Dto;

final readonly class ProjectData
{
    /**
     * @param array<string, mixed>|null $data
     */
    public function __construct(
        public int $clientId,
        public string $name,
        public string $type,
        public ?string $code = null,
        public ?string $notes = null,
        public ?bool $archived = null,
        public ?string $startAt = null,
        public ?string $endAt = null,
        public ?string $budgetType = null,
        public ?float $budgetTotal = null,
        public ?int $budgetThreshold = null,
        public ?bool $budgetThresholdNotify = null,
        public ?array $data = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'client_id' => $this->clientId,
            'name' => $this->name,
            'type' => $this->type,
            'code' => $this->code,
            'notes' => $this->notes,
            'archived' => $this->archived,
            'start_at' => $this->startAt,
            'end_at' => $this->endAt,
            'budget_type' => $this->budgetType,
            'budget_total' => $this->budgetTotal,
            'budget_threshold' => $this->budgetThreshold,
            'budget_threshold_notify' => $this->budgetThresholdNotify,
            'data' => $this->data,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
