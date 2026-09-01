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
        public ?string $deliveryId,
        public ?string $locale,
        public ?string $subject,
        public ?string $deliveryMode,
        public ?string $replyToEmail,
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
            deliveryId: isset($data['delivery']['id']) ? (string) $data['delivery']['id'] : null,
            locale: isset($data['delivery']['locale']) ? (string) $data['delivery']['locale'] : null,
            subject: isset($data['delivery']['subject']) ? (string) $data['delivery']['subject'] : null,
            deliveryMode: isset($data['delivery']['delivery_mode'])
                ? (string) $data['delivery']['delivery_mode']
                : null,
            replyToEmail: isset($data['delivery']['reply_to_email'])
                ? (string) $data['delivery']['reply_to_email']
                : null,
        );
    }
}
