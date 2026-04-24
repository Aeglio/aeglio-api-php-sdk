<?php

declare(strict_types=1);

namespace Aeglio\Dto;

use Aeglio\Support\Optional;

final readonly class UpdateExpenseCategoryData
{
    public function __construct(
        public string|Optional $name = new Optional(),
        public bool|null|Optional $isGos = new Optional(),
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $payload = [];

        if (!$this->name instanceof Optional) {
            $payload['name'] = $this->name;
        }

        if (!$this->isGos instanceof Optional) {
            $payload['is_gos'] = $this->isGos;
        }

        return $payload;
    }
}
