<?php

declare(strict_types=1);

namespace Aeglio\Entity;

final readonly class TaskComment
{
    private function __construct(
        public string $id,
        public string $body,
        public string $bodyFormat,
        public Person $author,
        public array $mentions,
        public int $version,
        public ?string $createdAt,
        public ?string $updatedAt,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (string) ($data['id'] ?? ''),
            body: (string) ($data['body'] ?? ''),
            bodyFormat: (string) ($data['body_format'] ?? ''),
            author: Person::fromArray($data['author'] ?? []),
            mentions: (array) ($data['mentions'] ?? []),
            version: (int) ($data['version'] ?? 0),
            createdAt: isset($data['created_at']) ? (string) $data['created_at'] : null,
            updatedAt: isset($data['updated_at']) ? (string) $data['updated_at'] : null,
        );
    }
}
