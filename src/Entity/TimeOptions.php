<?php

declare(strict_types=1);
namespace Aeglio\Entity;

final readonly class TimeOptions
{
    /** @param list<TimeOption> $data */
    public function __construct(public array $data, public bool $hasMore) {}
    public static function fromArray(array $data): self
    {
        return new self(array_map(fn (array $row) => new TimeOption((int) $row['id'], (string) $row['name']), $data['data']), (bool) $data['has_more']);
    }
}
