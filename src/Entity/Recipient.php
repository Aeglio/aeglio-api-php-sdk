<?php

declare(strict_types=1);

namespace Aeglio\Entity;

final readonly class Recipient
{
    private function __construct(
        public string $id,
        public string $name,
        public string $email,
        public bool $isClient,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (string) ($data['id'] ?? ''),
            name: (string) ($data['name'] ?? ''),
            email: (string) ($data['email'] ?? ''),
            isClient: (bool) ($data['is_client'] ?? false),
        );
    }
}
