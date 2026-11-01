<?php

declare(strict_types=1);

namespace Aeglio\Entity;

final readonly class TaskStatus
{
    private function __construct(
        public string $id,
        public string $name,
        public string $semantic,
        public bool $isDefault,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (string) ($data['id'] ?? ''),
            name: (string) ($data['name'] ?? ''),
            semantic: (string) ($data['semantic'] ?? ''),
            isDefault: (bool) ($data['is_default'] ?? false),
        );
    }
}
