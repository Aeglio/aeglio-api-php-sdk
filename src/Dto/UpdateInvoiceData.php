<?php

declare(strict_types=1);

namespace Aeglio\Dto;

use Aeglio\Support\Optional;

final readonly class UpdateInvoiceData
{
    /**
     * @param list<InvoiceRowData>|Optional $rows
     */
    public function __construct(
        public int|Optional $clientId = new Optional(),
        public string|Optional $number = new Optional(),
        public string|Optional $issuedAt = new Optional(),
        public string|Optional $dueAt = new Optional(),
        public string|null|Optional $referenceNumber = new Optional(),
        public string|Optional $state = new Optional(),
        public string|null|Optional $notes = new Optional(),
        public bool|null|Optional $hasTax = new Optional(),
        public array|Optional $rows = new Optional(),
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $payload = [];

        $map = [
            'client_id' => $this->clientId,
            'number' => $this->number,
            'issued_at' => $this->issuedAt,
            'due_at' => $this->dueAt,
            'reference_number' => $this->referenceNumber,
            'state' => $this->state,
            'notes' => $this->notes,
            'has_tax' => $this->hasTax,
        ];

        foreach ($map as $key => $value) {
            if (!$value instanceof Optional) {
                $payload[$key] = $value;
            }
        }

        if (!$this->rows instanceof Optional) {
            $payload['rows'] = array_map(
                static fn (InvoiceRowData $row): array => $row->toArray(),
                $this->rows,
            );
        }

        return $payload;
    }
}
