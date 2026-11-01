<?php

declare(strict_types=1);

namespace Aeglio\Entity;

final readonly class Document
{
    private function __construct(
        public int $id,
        public string $fileName,
        public string $mimeType,
        public int $fileSize,
        public string $sourceType,
        public ?string $classification,
        public string $state,
        public ?string $duplicateState,
        public ?float $confidenceScore,
        public ?string $convertedType,
        public ?int $convertedId,
        public ?string $processedAt,
        public ?string $reviewedAt,
        public ?string $createdAt,
        public ?string $updatedAt,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) ($data['id'] ?? 0),
            fileName: (string) ($data['file_name'] ?? ''),
            mimeType: (string) ($data['mime_type'] ?? ''),
            fileSize: (int) ($data['file_size'] ?? 0),
            sourceType: (string) ($data['source_type'] ?? ''),
            classification: isset($data['classification']) ? (string) $data['classification'] : null,
            state: (string) ($data['state'] ?? ''),
            duplicateState: isset($data['duplicate_state']) ? (string) $data['duplicate_state'] : null,
            confidenceScore: isset($data['confidence_score']) ? (float) $data['confidence_score'] : null,
            convertedType: isset($data['converted_type']) ? (string) $data['converted_type'] : null,
            convertedId: isset($data['converted_id']) ? (int) $data['converted_id'] : null,
            processedAt: isset($data['processed_at']) ? (string) $data['processed_at'] : null,
            reviewedAt: isset($data['reviewed_at']) ? (string) $data['reviewed_at'] : null,
            createdAt: isset($data['created_at']) ? (string) $data['created_at'] : null,
            updatedAt: isset($data['updated_at']) ? (string) $data['updated_at'] : null,
        );
    }
}
