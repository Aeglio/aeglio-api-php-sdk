<?php

declare(strict_types=1);

namespace Aeglio\Dto;

use Aeglio\Support\Optional;

final readonly class SendEstimateData
{
    public function __construct(
        public array $recipientIds,
        public bool|Optional $teamCopy = new Optional(),
        public bool|Optional $reminder = new Optional(),
        public string|Optional $replyToEmail = new Optional(),
        public string|Optional $locale = new Optional(),
        public string|Optional $subject = new Optional(),
        public string|Optional $body = new Optional(),
        public string|Optional $deliveryMode = new Optional(),
    ) {
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return array_filter([
            'recipient_ids' => $this->recipientIds,
            'team_copy' => $this->teamCopy,
            'reminder' => $this->reminder,
            'reply_to_email' => $this->replyToEmail,
            'locale' => $this->locale,
            'subject' => $this->subject,
            'body' => $this->body,
            'delivery_mode' => $this->deliveryMode,
        ], static fn (mixed $value): bool => ! $value instanceof Optional);
    }
}
