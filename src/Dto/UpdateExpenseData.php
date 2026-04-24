<?php

declare(strict_types=1);

namespace Aeglio\Dto;

use Aeglio\Support\Optional;

final readonly class UpdateExpenseData
{
    public function __construct(
        public string|Optional $number = new Optional(),
        public float|Optional $amount = new Optional(),
        public string|Optional $date = new Optional(),
        public int|Optional $categoryId = new Optional(),
        public int|null|Optional $clientId = new Optional(),
        public int|null|Optional $projectId = new Optional(),
        public int|null|Optional $taxRateId = new Optional(),
        public string|Optional $state = new Optional(),
        public string|null|Optional $notes = new Optional(),
        public bool|null|Optional $billable = new Optional(),
        public bool|Optional $removeAttachment = new Optional(),
        public string|\SplFileInfo|null|Optional $attachment = new Optional(),
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $payload = [];

        foreach ([
            'number' => $this->number,
            'amount' => $this->amount,
            'date' => $this->date,
            'category_id' => $this->categoryId,
            'client_id' => $this->clientId,
            'project_id' => $this->projectId,
            'tax_rate_id' => $this->taxRateId,
            'state' => $this->state,
            'notes' => $this->notes,
            'billable' => $this->billable,
            'remove_attachment' => $this->removeAttachment,
        ] as $key => $value) {
            if (!$value instanceof Optional) {
                $payload[$key] = $value;
            }
        }

        return $payload;
    }
}
