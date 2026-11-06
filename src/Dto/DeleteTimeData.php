<?php

declare(strict_types=1);
namespace Aeglio\Dto;

use Aeglio\Support\Optional;

final readonly class DeleteTimeData
{
    public function __construct(
        public string $operationId,
        public string $issuedAt,
        public string $expiresAt,
        public int $version,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'operation_id' => $this->operationId,
            'issued_at' => $this->issuedAt,
            'expires_at' => $this->expiresAt,
            'version' => $this->version,
        ], static fn (mixed $value): bool => !$value instanceof Optional);
    }
}
