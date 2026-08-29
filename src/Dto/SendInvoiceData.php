<?php

declare(strict_types=1);

namespace Aeglio\Dto;

final readonly class SendInvoiceData
{
    /**
     * @param list<InvoiceRecipientData> $recipients
     */
    public function __construct(
        public array $recipients,
        public ?bool $teamCopy = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'recipients' => array_map(
                static fn (InvoiceRecipientData $recipient): array => $recipient->toArray(),
                $this->recipients,
            ),
            'team_copy' => $this->teamCopy,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
