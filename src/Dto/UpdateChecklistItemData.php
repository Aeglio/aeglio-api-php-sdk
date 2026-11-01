<?php

declare(strict_types=1);

namespace Aeglio\Dto;

use Aeglio\Support\Optional;

final readonly class UpdateChecklistItemData
{
    public function __construct(
        public int $version,
        public string|Optional $text = new Optional(),
        public bool|Optional $completed = new Optional(),
        public int|Optional $position = new Optional(),
    ) {
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return array_filter([
            'version' => $this->version,
            'text' => $this->text,
            'completed' => $this->completed,
            'position' => $this->position,
        ], static fn (mixed $value): bool => ! $value instanceof Optional);
    }
}
