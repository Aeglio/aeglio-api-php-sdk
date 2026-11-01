<?php

declare(strict_types=1);

namespace Aeglio\Entity;

final readonly class MilestoneProgress
{
    private function __construct(
        public int $total,
        public int $completed,
        public int $excluded,
        public int $overdue,
        public bool $ready,
        public int $unfinished,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            total: (int) ($data['total'] ?? 0),
            completed: (int) ($data['completed'] ?? 0),
            excluded: (int) ($data['excluded'] ?? 0),
            overdue: (int) ($data['overdue'] ?? 0),
            ready: (bool) ($data['ready'] ?? false),
            unfinished: (int) ($data['unfinished'] ?? 0),
        );
    }
}
