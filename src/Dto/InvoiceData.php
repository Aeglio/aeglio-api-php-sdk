<?php

declare(strict_types=1);

namespace Aeglio\Dto;

final readonly class InvoiceData
{
    /**
     * @param list<InvoiceRowData> $rows
     */
    public function __construct(
        public int $clientId,
        public string $number,
        public string $issuedAt,
        public string $dueAt,
        public ?string $referenceNumber = null,
        public ?string $state = null,
        public ?string $notes = null,
        public ?bool $hasTax = null,
        public array $rows = [],
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'client_id' => $this->clientId,
            'number' => $this->number,
            'issued_at' => $this->issuedAt,
            'due_at' => $this->dueAt,
            'reference_number' => $this->referenceNumber,
            'state' => $this->state,
            'notes' => $this->notes,
            'has_tax' => $this->hasTax,
            'rows' => array_map(
                static fn (InvoiceRowData $row): array => $row->toArray(),
                $this->rows,
            ),
        ], static fn (mixed $value): bool => $value !== null);
    }
}
