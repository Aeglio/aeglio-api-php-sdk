<?php

declare(strict_types=1);

namespace Aeglio\Entity;

final readonly class Deal
{
    private function __construct(
        public int $id,
        public int $clientId,
        public int $pipelineId,
        public int $stageId,
        public string $title,
        public ?int $contactId,
        public ?string $ownerId,
        public string $state,
        public ?float $value,
        public string $currency,
        public ?string $expectedCloseDate,
        public ?string $notes,
        public ?string $createdAt,
        public ?string $updatedAt,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) ($data['id'] ?? 0),
            clientId: (int) ($data['client_id'] ?? 0),
            pipelineId: (int) ($data['pipeline_id'] ?? 0),
            stageId: (int) ($data['stage_id'] ?? 0),
            title: (string) ($data['title'] ?? ''),
            contactId: isset($data['contact_id']) ? (int) $data['contact_id'] : null,
            ownerId: isset($data['owner_id']) ? (string) $data['owner_id'] : null,
            state: (string) ($data['state'] ?? ''),
            value: isset($data['value']) ? (float) $data['value'] : null,
            currency: (string) ($data['currency'] ?? ''),
            expectedCloseDate: isset($data['expected_close_date']) ? (string) $data['expected_close_date'] : null,
            notes: isset($data['notes']) ? (string) $data['notes'] : null,
            createdAt: isset($data['created_at']) ? (string) $data['created_at'] : null,
            updatedAt: isset($data['updated_at']) ? (string) $data['updated_at'] : null,
        );
    }
}
