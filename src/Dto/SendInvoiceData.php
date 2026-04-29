<?php

declare(strict_types=1);

namespace Aeglio\Dto;

final readonly class SendInvoiceData
{
    /**
     * @param list<int> $contactIds
     */
    public function __construct(
        public array $contactIds,
        public ?bool $teamCopy = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'contact_ids' => $this->contactIds,
            'team_copy' => $this->teamCopy,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
