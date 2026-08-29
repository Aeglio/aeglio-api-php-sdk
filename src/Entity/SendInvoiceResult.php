<?php

declare(strict_types=1);

namespace Aeglio\Entity;

final readonly class SendInvoiceResult
{
    /**
     * @param list<array{type:'client'|'contact', id:int, name:string, email:string}> $sentTo
     */
    private function __construct(
        public string $message,
        public array $sentTo,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            message: (string) ($data['message'] ?? 'Invoice sent.'),
            sentTo: array_values(is_array($data['sent_to'] ?? null) ? $data['sent_to'] : []),
        );
    }
}
