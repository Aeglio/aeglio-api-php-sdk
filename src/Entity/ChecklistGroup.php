<?php

declare(strict_types=1);

namespace Aeglio\Entity;

final readonly class ChecklistGroup
{
    private function __construct(
        public string $id,
        public ?string $title,
        public int $version,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (string) ($data['id'] ?? ''),
            title: isset($data['title']) ? (string) $data['title'] : null,
            version: (int) ($data['version'] ?? 0),
        );
    }
}
