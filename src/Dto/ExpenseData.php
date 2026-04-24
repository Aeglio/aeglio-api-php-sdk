<?php

declare(strict_types=1);

namespace Aeglio\Dto;

final readonly class ExpenseData
{
    public function __construct(
        public string $number,
        public float $amount,
        public string $date,
        public int $categoryId,
        public ?int $clientId = null,
        public ?int $projectId = null,
        public ?int $taxRateId = null,
        public ?string $state = null,
        public ?string $notes = null,
        public ?bool $billable = null,
        public string|\SplFileInfo|null $attachment = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
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
        ], static fn (mixed $value): bool => $value !== null);
    }
}
