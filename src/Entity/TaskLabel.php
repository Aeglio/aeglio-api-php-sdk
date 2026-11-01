<?php

declare(strict_types=1);

namespace Aeglio\Entity;

final readonly class TaskLabel
{
    private function __construct(
        public string $id,
        public string $name,
        public string $color,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (string) ($data['id'] ?? ''),
            name: (string) ($data['name'] ?? ''),
            color: (string) ($data['color'] ?? ''),
        );
    }
}
