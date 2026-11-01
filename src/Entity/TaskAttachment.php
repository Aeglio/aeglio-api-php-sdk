<?php

declare(strict_types=1);

namespace Aeglio\Entity;

final readonly class TaskAttachment
{
    private function __construct(
        public string $id,
        public string $name,
        public string $mimeType,
        public int $sizeBytes,
        public string $state,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (string) ($data['id'] ?? ''),
            name: (string) ($data['name'] ?? ''),
            mimeType: (string) ($data['mime_type'] ?? ''),
            sizeBytes: (int) ($data['size_bytes'] ?? 0),
            state: (string) ($data['state'] ?? ''),
        );
    }
}
