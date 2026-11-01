<?php

declare(strict_types=1);

namespace Aeglio\Entity;

final readonly class Reimbursement
{
    private function __construct(
        public int $id,
        public string $title,
        public int $ownerUserId,
        public string $baseCurrency,
        public string $state,
        public string $reimbursementState,
        public string $postingState,
        public ?string $paymentReference,
        public ?string $reimbursementReference,
        public ?string $submittedAt,
        public ?string $approvedAt,
        public ?string $reimbursedAt,
        public float $total,
        public float $reimbursableTotal,
        public ?string $createdAt,
        public ?string $updatedAt,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) ($data['id'] ?? 0),
            title: (string) ($data['title'] ?? ''),
            ownerUserId: (int) ($data['owner_user_id'] ?? 0),
            baseCurrency: (string) ($data['base_currency'] ?? ''),
            state: (string) ($data['state'] ?? ''),
            reimbursementState: (string) ($data['reimbursement_state'] ?? ''),
            postingState: (string) ($data['posting_state'] ?? ''),
            paymentReference: isset($data['payment_reference']) ? (string) $data['payment_reference'] : null,
            reimbursementReference: isset($data['reimbursement_reference']) ? (string) $data['reimbursement_reference'] : null,
            submittedAt: isset($data['submitted_at']) ? (string) $data['submitted_at'] : null,
            approvedAt: isset($data['approved_at']) ? (string) $data['approved_at'] : null,
            reimbursedAt: isset($data['reimbursed_at']) ? (string) $data['reimbursed_at'] : null,
            total: (float) ($data['total'] ?? 0.0),
            reimbursableTotal: (float) ($data['reimbursable_total'] ?? 0.0),
            createdAt: isset($data['created_at']) ? (string) $data['created_at'] : null,
            updatedAt: isset($data['updated_at']) ? (string) $data['updated_at'] : null,
        );
    }
}
