<?php

declare(strict_types=1);

namespace Aeglio\Entity;

final readonly class DealPipeline
{
    /** @param list<DealStage> $stages */
    private function __construct(
        public int $id,
        public string $name,
        public int $position,
        public array $stages,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) ($data['id'] ?? 0),
            name: (string) ($data['name'] ?? ''),
            position: (int) ($data['position'] ?? 0),
            stages: array_map(DealStage::fromArray(...), $data['stages'] ?? []),
        );
    }
}
