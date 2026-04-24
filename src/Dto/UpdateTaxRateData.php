<?php

declare(strict_types=1);

namespace Aeglio\Dto;

use Aeglio\Support\Optional;

final readonly class UpdateTaxRateData
{
    public function __construct(
        public string|Optional $title = new Optional(),
        public float|Optional $percentage = new Optional(),
        public bool|null|Optional $default = new Optional(),
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $payload = [];

        foreach ([
            'title' => $this->title,
            'percentage' => $this->percentage,
            'default' => $this->default,
        ] as $key => $value) {
            if (!$value instanceof Optional) {
                $payload[$key] = $value;
            }
        }

        return $payload;
    }
}
