<?php

declare(strict_types=1);

namespace Aeglio\Entity;

final readonly class TaskProject
{
    private function __construct(
        public int $id,
        public string $name,
        public bool $archived,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) ($data['id'] ?? 0),
            name: (string) ($data['name'] ?? ''),
            archived: (bool) ($data['archived'] ?? false),
        );
    }
}
