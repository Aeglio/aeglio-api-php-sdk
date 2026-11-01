<?php

declare(strict_types=1);

namespace Aeglio\Entity;

final readonly class Webhook
{
    private function __construct(
        public int $id,
        public string $name,
        public string $url,
        public array $events,
        public string $status,
        public int $consecutiveFailures,
        public ?string $lastDeliveredAt,
        public ?string $lastFailedAt,
        public ?string $pausedAt,
        public ?string $createdAt,
        public ?string $updatedAt,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) ($data['id'] ?? 0),
            name: (string) ($data['name'] ?? ''),
            url: (string) ($data['url'] ?? ''),
            events: (array) ($data['events'] ?? []),
            status: (string) ($data['status'] ?? ''),
            consecutiveFailures: (int) ($data['consecutive_failures'] ?? 0),
            lastDeliveredAt: isset($data['last_delivered_at']) ? (string) $data['last_delivered_at'] : null,
            lastFailedAt: isset($data['last_failed_at']) ? (string) $data['last_failed_at'] : null,
            pausedAt: isset($data['paused_at']) ? (string) $data['paused_at'] : null,
            createdAt: isset($data['created_at']) ? (string) $data['created_at'] : null,
            updatedAt: isset($data['updated_at']) ? (string) $data['updated_at'] : null,
        );
    }
}
