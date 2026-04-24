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
        public ?bool $sendCopy = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'contact_ids' => $this->contactIds,
            'send_copy' => $this->sendCopy,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
