<?php

declare(strict_types=1);

namespace Aeglio\Entity;

final readonly class WebhookDelivery
{
    private function __construct(
        public int $id,
        public ?string $eventId,
        public ?string $event,
        public string $status,
        public int $attemptCount,
        public ?int $responseStatus,
        public ?int $durationMs,
        public ?string $errorCode,
        public ?string $lastAttemptedAt,
        public ?string $queuedAt,
        public ?string $deliveredAt,
        public ?string $failedAt,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) ($data['id'] ?? 0),
            eventId: isset($data['event_id']) ? (string) $data['event_id'] : null,
            event: isset($data['event']) ? (string) $data['event'] : null,
            status: (string) ($data['status'] ?? ''),
            attemptCount: (int) ($data['attempt_count'] ?? 0),
            responseStatus: isset($data['response_status']) ? (int) $data['response_status'] : null,
            durationMs: isset($data['duration_ms']) ? (int) $data['duration_ms'] : null,
            errorCode: isset($data['error_code']) ? (string) $data['error_code'] : null,
            lastAttemptedAt: isset($data['last_attempted_at']) ? (string) $data['last_attempted_at'] : null,
            queuedAt: isset($data['queued_at']) ? (string) $data['queued_at'] : null,
            deliveredAt: isset($data['delivered_at']) ? (string) $data['delivered_at'] : null,
            failedAt: isset($data['failed_at']) ? (string) $data['failed_at'] : null,
        );
    }
}
