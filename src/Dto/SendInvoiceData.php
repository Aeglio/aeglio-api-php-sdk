<?php

declare(strict_types=1);

namespace Aeglio\Dto;

final readonly class SendInvoiceData
{
    /**
     * @param list<InvoiceRecipientData> $recipients
     * @param ?string $body Plain text or safe HTML using paragraphs, line breaks, bold, italic, underline, or lists
     */
    public function __construct(
        public array $recipients,
        public ?bool $teamCopy = null,
        public ?string $locale = null,
        public ?string $subject = null,
        public ?string $body = null,
        public ?string $deliveryMode = null,
        public ?string $replyToEmail = null,
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
            'locale' => $this->locale,
            'subject' => $this->subject,
            'body' => $this->body,
            'delivery_mode' => $this->deliveryMode,
            'reply_to_email' => $this->replyToEmail,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
