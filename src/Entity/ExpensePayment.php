<?php

declare(strict_types=1);

namespace Aeglio\Entity;

use Aeglio\Aeglio;
use Aeglio\Dto\UpdateExpensePaymentData;

final readonly class ExpensePayment
{
    private function __construct(
        private Aeglio $client,
        public int $id,
        public ?int $expenseId,
        public float $sum,
        public ?string $notes,
        public string $paidAt,
        public ?string $createdAt,
        public ?string $updatedAt,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(Aeglio $client, array $data): self
    {
        return new self(
            client: $client,
            id: (int) $data['id'],
            expenseId: isset($data['expense_id']) ? (int) $data['expense_id'] : null,
            sum: (float) $data['sum'],
            notes: $data['notes'] ?? null,
            paidAt: (string) $data['paid_at'],
            createdAt: $data['created_at'] ?? null,
            updatedAt: $data['updated_at'] ?? null,
        );
    }

    public function update(UpdateExpensePaymentData $data): self
    {
        return $this->client->expenses()->updatePayment(
            expenseId: (int) $this->expenseId,
            paymentId: $this->id,
            data: $data,
        );
    }

    public function delete(): void
    {
        $this->client->expenses()->deletePayment((int) $this->expenseId, $this->id);
    }
}
