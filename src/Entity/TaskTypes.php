<?php

declare(strict_types=1);

namespace Aeglio\Entity;

final readonly class TaskTypes
{
    private function __construct(
        public array $types,
        public array $priorities,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            types: (array) ($data['types'] ?? []),
            priorities: (array) ($data['priorities'] ?? []),
        );
    }
}
