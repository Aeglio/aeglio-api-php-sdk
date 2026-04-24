<?php

declare(strict_types=1);

namespace Aeglio\Collection;

use Countable;
use IteratorAggregate;
use Traversable;

/**
 * @template T
 *
 * @implements IteratorAggregate<int, T>
 */
final readonly class PaginatedResult implements IteratorAggregate, Countable
{
    /**
     * @param list<T> $items
     */
    public function __construct(
        public array $items,
        public int $currentPage,
        public int $perPage,
        public int $total,
        public int $lastPage,
    ) {
    }

    /**
     * @return list<T>
     */
    public function items(): array
    {
        return $this->items;
    }

    public function hasMorePages(): bool
    {
        return $this->currentPage < $this->lastPage;
    }

    public function getIterator(): Traversable
    {
        yield from $this->items;
    }

    public function count(): int
    {
        return count($this->items);
    }
}
