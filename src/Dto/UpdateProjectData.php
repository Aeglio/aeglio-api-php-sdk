<?php

declare(strict_types=1);

namespace Aeglio\Dto;

use Aeglio\Support\Optional;

final readonly class UpdateProjectData
{
    /**
     * @param array<string, mixed>|null|Optional $data
     */
    public function __construct(
        public int|Optional $clientId = new Optional(),
        public string|Optional $name = new Optional(),
        public string|Optional $type = new Optional(),
        public string|null|Optional $code = new Optional(),
        public string|null|Optional $notes = new Optional(),
        public bool|null|Optional $archived = new Optional(),
        public string|null|Optional $startAt = new Optional(),
        public string|null|Optional $endAt = new Optional(),
        public string|null|Optional $budgetType = new Optional(),
        public float|null|Optional $budgetTotal = new Optional(),
        public int|null|Optional $budgetThreshold = new Optional(),
        public bool|null|Optional $budgetThresholdNotify = new Optional(),
        public array|null|Optional $data = new Optional(),
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $payload = [];

        foreach ([
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
        ] as $key => $value) {
            if (!$value instanceof Optional) {
                $payload[$key] = $value;
            }
        }

        return $payload;
    }
}
