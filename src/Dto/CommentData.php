<?php

declare(strict_types=1);

namespace Aeglio\Dto;

use Aeglio\Support\Optional;

final readonly class CommentData
{
    public function __construct(
        public string $body,
        public string $operationId,
        public string|Optional $bodyFormat = new Optional(),
        public array|Optional $mentions = new Optional(),
    ) {
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return array_filter([
            'body' => $this->body,
            'operation_id' => $this->operationId,
            'body_format' => $this->bodyFormat,
            'mentions' => $this->mentions,
        ], static fn (mixed $value): bool => ! $value instanceof Optional);
    }
}
