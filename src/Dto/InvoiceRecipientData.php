<?php

declare(strict_types=1);

namespace Aeglio\Dto;

final readonly class InvoiceRecipientData
{
    private function __construct(
        public string $type,
        public int $id,
    ) {
    }

    public static function client(int $id): self
    {
        return new self('client', $id);
    }

    public static function contact(int $id): self
    {
        return new self('contact', $id);
    }

    /**
     * @return array{type: 'client'|'contact', id: int}
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'id' => $this->id,
        ];
    }
}
