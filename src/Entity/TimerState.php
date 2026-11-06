<?php

declare(strict_types=1);
namespace Aeglio\Entity;

final readonly class TimerState
{
    public function __construct(public ?TimeEntry $data, public int $revision, public bool $replayed = false, public bool $blocked = false, public ?string $serverTime = null, public ?string $timezone = null) {}
    public static function fromArray(array $data): self
    {
        return new self(isset($data['data']) ? TimeEntry::fromArray($data['data']) : null, (int) $data['revision'], $data['replayed'] ?? false, $data['blocked'] ?? false, $data['server_time'] ?? null, $data['timezone'] ?? null);
    }
}
