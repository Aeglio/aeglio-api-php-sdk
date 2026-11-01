<?php

declare(strict_types=1);

namespace Aeglio\Dto;

use Aeglio\Support\Optional;

final readonly class UpdateDealData
{
    public function __construct(
        public string|Optional $title = new Optional(),
        public int|Optional $clientId = new Optional(),
        public int|Optional $pipelineId = new Optional(),
        public int|Optional $stageId = new Optional(),
        public int|null|Optional $contactId = new Optional(),
        public string|null|Optional $ownerId = new Optional(),
        public float|null|Optional $value = new Optional(),
        public string|Optional $currency = new Optional(),
        public string|null|Optional $expectedCloseDate = new Optional(),
        public string|null|Optional $notes = new Optional(),
    ) {
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return array_filter([
            'title' => $this->title,
            'client_id' => $this->clientId,
            'pipeline_id' => $this->pipelineId,
            'stage_id' => $this->stageId,
            'contact_id' => $this->contactId,
            'owner_id' => $this->ownerId,
            'value' => $this->value,
            'currency' => $this->currency,
            'expected_close_date' => $this->expectedCloseDate,
            'notes' => $this->notes,
        ], static fn (mixed $value): bool => ! $value instanceof Optional);
    }
}
