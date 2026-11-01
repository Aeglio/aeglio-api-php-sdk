<?php

declare(strict_types=1);

namespace Aeglio\Dto;

use Aeglio\Support\Optional;

final readonly class WebhookData
{
    public function __construct(
        public string $name,
        public string $url,
        public array $events,
    ) {
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'url' => $this->url,
            'events' => $this->events,
        ], static fn (mixed $value): bool => ! $value instanceof Optional);
    }
}
