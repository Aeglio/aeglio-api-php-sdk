<?php

declare(strict_types=1);

namespace Aeglio\Entity;

final readonly class TaskCategory
{
    private function __construct(
        public int $id,
        public string $name,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) ($data['id'] ?? 0),
            name: (string) ($data['name'] ?? ''),
        );
    }
}
