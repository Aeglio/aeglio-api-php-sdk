<?php

declare(strict_types=1);

namespace Aeglio\Dto;

use Aeglio\Support\Optional;

final readonly class UpdateWebhookData
{
    public function __construct(
        public string|Optional $name = new Optional(),
        public string|Optional $url = new Optional(),
        public array|Optional $events = new Optional(),
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
