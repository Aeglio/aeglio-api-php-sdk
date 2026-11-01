<?php

declare(strict_types=1);

namespace Aeglio\Entity;

final readonly class TaskActivity
{
    private function __construct(
        public ?string $occurredAt,
        public string $action,
        public ?string $actor,
        public array $changes,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            occurredAt: isset($data['occurred_at']) ? (string) $data['occurred_at'] : null,
            action: (string) ($data['action'] ?? ''),
            actor: isset($data['actor']) ? (string) $data['actor'] : null,
            changes: (array) ($data['changes'] ?? []),
        );
    }
}
