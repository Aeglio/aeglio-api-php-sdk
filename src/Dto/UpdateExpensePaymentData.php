<?php

declare(strict_types=1);

namespace Aeglio\Dto;

use Aeglio\Support\Optional;

final readonly class UpdateExpensePaymentData
{
    public function __construct(
        public float|Optional $sum = new Optional(),
        public string|Optional $paidAt = new Optional(),
        public string|null|Optional $notes = new Optional(),
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $payload = [];

        foreach ([
            'sum' => $this->sum,
            'paid_at' => $this->paidAt,
            'notes' => $this->notes,
        ] as $key => $value) {
            if (!$value instanceof Optional) {
                $payload[$key] = $value;
            }
        }

        return $payload;
    }
}
