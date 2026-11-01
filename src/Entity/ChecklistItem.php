<?php

declare(strict_types=1);

namespace Aeglio\Entity;

final readonly class ChecklistItem
{
    private function __construct(
        public string $id,
        public ?string $groupId,
        public string $text,
        public bool $completed,
        public int $position,
        public int $version,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (string) ($data['id'] ?? ''),
            groupId: isset($data['group_id']) ? (string) $data['group_id'] : null,
            text: (string) ($data['text'] ?? ''),
            completed: (bool) ($data['completed'] ?? false),
            position: (int) ($data['position'] ?? 0),
            version: (int) ($data['version'] ?? 0),
        );
    }
}
