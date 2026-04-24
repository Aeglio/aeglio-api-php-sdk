<?php

declare(strict_types=1);

namespace Aeglio\Entity;

use Aeglio\Aeglio;
use Aeglio\Collection\PaginatedResult;
use Aeglio\Dto\ExpensePaymentData;
use Aeglio\Dto\UpdateExpenseData;

final readonly class Expense
{
    /**
     * @param list<ExpensePayment> $payments
     * @param array{name:string, download_url:string}|null $attachment
     */
    private function __construct(
        private Aeglio $client,
        public int $id,
        public ?int $clientId,
        public ?int $projectId,
        public ?int $categoryId,
        public ?int $taxRateId,
        public ?int $userId,
        public ?int $invoiceRowId,
        public string $number,
        public string $state,
        public string $date,
        public ?string $notes,
        public bool $billable,
        public float $amount,
        public float $tax,
        public float $paymentsTotal,
        public float $totalToPay,
        public array $payments,
        public ?array $attachment,
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
            clientId: isset($data['client_id']) ? (int) $data['client_id'] : null,
            projectId: isset($data['project_id']) ? (int) $data['project_id'] : null,
            categoryId: isset($data['category_id']) ? (int) $data['category_id'] : null,
            taxRateId: isset($data['tax_rate_id']) ? (int) $data['tax_rate_id'] : null,
            userId: isset($data['user_id']) ? (int) $data['user_id'] : null,
            invoiceRowId: isset($data['invoice_row_id']) ? (int) $data['invoice_row_id'] : null,
            number: (string) $data['number'],
            state: (string) $data['state'],
            date: (string) $data['date'],
            notes: $data['notes'] ?? null,
            billable: (bool) $data['billable'],
            amount: (float) $data['amount'],
            tax: (float) $data['tax'],
            paymentsTotal: (float) $data['payments_total'],
            totalToPay: (float) $data['total_to_pay'],
            payments: array_map(
                static fn (array $payment): ExpensePayment => ExpensePayment::fromArray($client, $payment),
                is_array($data['payments'] ?? null) ? $data['payments'] : [],
            ),
            attachment: is_array($data['attachment'] ?? null) ? $data['attachment'] : null,
            createdAt: $data['created_at'] ?? null,
            updatedAt: $data['updated_at'] ?? null,
        );
    }

    public function addPayment(ExpensePaymentData $data): ExpensePayment
    {
        return $this->client->expenses()->addPayment($this->id, $data);
    }

    public function update(UpdateExpenseData $data): self
    {
        return $this->client->expenses()->update($this->id, $data);
    }

    public function delete(): void
    {
        $this->client->expenses()->delete($this->id);
    }

    /**
     * @return PaginatedResult<ExpensePayment>
     */
    public function payments(int $perPage = 50, int $page = 1): PaginatedResult
    {
        return $this->client->expenses()->listPayments(
            expenseId: $this->id,
            perPage: $perPage,
            page: $page,
        );
    }

    public function downloadAttachment(): string
    {
        return $this->client->expenses()->downloadAttachment($this->id);
    }
}
