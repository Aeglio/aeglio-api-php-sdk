<?php

declare(strict_types=1);

namespace Aeglio\Entity;

final readonly class Estimate
{
    private function __construct(
        public int $id,
        public ?int $dealId,
        public int $clientId,
        public string $number,
        public int $revisionNumber,
        public ?int $previousRevisionId,
        public string $title,
        public string $state,
        public string $currency,
        public ?string $issuedAt,
        public ?string $validUntil,
        public ?string $sentAt,
        public ?string $acceptedAt,
        public ?string $rejectedAt,
        public ?string $expiredAt,
        public ?string $supersededAt,
        public ?string $cancelledAt,
        public ?string $notes,
        public ?string $terms,
        public ?string $createdAt,
        public ?string $updatedAt,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            dealId: isset($data['deal_id']) ? (int) $data['deal_id'] : null,
            clientId: (int) $data['client_id'],
            number: (string) $data['number'],
            revisionNumber: (int) ($data['revision_number'] ?? 1),
            previousRevisionId: isset($data['previous_revision_id']) ? (int) $data['previous_revision_id'] : null,
            title: (string) $data['title'],
            state: (string) $data['state'],
            currency: (string) $data['currency'],
            issuedAt: $data['issued_at'] ?? null,
            validUntil: $data['valid_until'] ?? null,
            sentAt: $data['sent_at'] ?? null,
            acceptedAt: $data['accepted_at'] ?? null,
            rejectedAt: $data['rejected_at'] ?? null,
            expiredAt: $data['expired_at'] ?? null,
            supersededAt: $data['superseded_at'] ?? null,
            cancelledAt: $data['cancelled_at'] ?? null,
            notes: $data['notes'] ?? null,
            terms: $data['terms'] ?? null,
            createdAt: $data['created_at'] ?? null,
            updatedAt: $data['updated_at'] ?? null,
        );
    }
}
