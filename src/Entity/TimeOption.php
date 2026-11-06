<?php

declare(strict_types=1);
namespace Aeglio\Entity;

final readonly class TimeOption
{
    public function __construct(public int $id, public string $name) {}
}
