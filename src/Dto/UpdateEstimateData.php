<?php

declare(strict_types=1);

namespace Aeglio\Dto;

use Aeglio\Support\Optional;

final readonly class UpdateEstimateData
{
    /** @param list<EstimateRowData>|Optional $rows */
    public function __construct(
        public int|Optional $clientId = new Optional(),
        public string|Optional $title = new Optional(),
        public string|Optional $number = new Optional(),
        public string|Optional $issuedAt = new Optional(),
        public int|null|Optional $dealId = new Optional(),
        public string|Optional $currency = new Optional(),
        public string|null|Optional $validUntil = new Optional(),
        public bool|Optional $hasTax = new Optional(),
        public string|null|Optional $notes = new Optional(),
        public string|null|Optional $terms = new Optional(),
        public array|Optional $rows = new Optional(),
    ) {
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return array_filter([
            'client_id' => $this->clientId,
            'title' => $this->title,
            'number' => $this->number,
            'issued_at' => $this->issuedAt,
            'deal_id' => $this->dealId,
            'currency' => $this->currency,
            'valid_until' => $this->validUntil,
            'has_tax' => $this->hasTax,
            'notes' => $this->notes,
            'terms' => $this->terms,
            'rows' => $this->rows instanceof Optional ? $this->rows : array_map(static fn (EstimateRowData $row): array => $row->toArray(), $this->rows),
        ], static fn (mixed $value): bool => ! $value instanceof Optional);
    }
}
