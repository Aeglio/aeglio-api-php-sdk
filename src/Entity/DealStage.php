<?php

declare(strict_types=1);

namespace Aeglio\Entity;

final readonly class DealStage
{
    private function __construct(
        public int $id,
        public string $name,
        public int $position,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) ($data['id'] ?? 0),
            name: (string) ($data['name'] ?? ''),
            position: (int) ($data['position'] ?? 0),
        );
    }
}
