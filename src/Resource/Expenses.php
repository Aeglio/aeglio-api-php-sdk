<?php

declare(strict_types=1);

namespace Aeglio\Resource;

use Aeglio\Collection\PaginatedResult;
use Aeglio\Dto\ExpenseData;
use Aeglio\Dto\ExpensePaymentData;
use Aeglio\Dto\UpdateExpenseData;
use Aeglio\Dto\UpdateExpensePaymentData;
use Aeglio\Entity\Expense;
use Aeglio\Entity\ExpensePayment;
use Aeglio\Support\Optional;

final class Expenses extends BaseResource
{
    /**
     * @return PaginatedResult<Expense>
     */
    public function list(?array $state = null, int $perPage = 50, int $page = 1): PaginatedResult
    {
        return $this->paginated(
            path: 'expenses',
            query: [
                'state' => $state,
                'per_page' => $perPage,
                'page' => $page,
            ],
            mapper: fn (array $item): Expense => Expense::fromArray($this->client, $item),
        );
    }

    public function find(int $id): Expense
    {
        $response = $this->http->json('GET', 'expenses/'.$id);

        return Expense::fromArray($this->client, $response['data']);
    }

    public function create(ExpenseData $data): Expense
    {
        $response = $this->sendExpensePayload('POST', 'expenses', $data->toArray(), $data->attachment);

        return Expense::fromArray($this->client, $response['data']);
    }

    public function update(int $id, UpdateExpenseData $data): Expense
    {
        $attachment = $data->attachment instanceof Optional ? null : $data->attachment;
        $response = $this->sendExpensePayload('PATCH', 'expenses/'.$id, $data->toArray(), $attachment);

        return Expense::fromArray($this->client, $response['data']);
    }

    public function delete(int $id): void
    {
        $this->http->json('DELETE', 'expenses/'.$id);
    }

    public function addPayment(int $expenseId, ExpensePaymentData $data): ExpensePayment
    {
        $response = $this->http->json(
            'POST',
            'expenses/'.$expenseId.'/payments',
            json: $data->toArray(),
        );

        return ExpensePayment::fromArray($this->client, $response['data']);
    }

    public function updatePayment(int $expenseId, int $paymentId, UpdateExpensePaymentData $data): ExpensePayment
    {
        $response = $this->http->json(
            'PATCH',
            'expenses/'.$expenseId.'/payments/'.$paymentId,
            json: $data->toArray(),
        );

        return ExpensePayment::fromArray($this->client, $response['data']);
    }

    public function deletePayment(int $expenseId, int $paymentId): void
    {
        $this->http->json('DELETE', 'expenses/'.$expenseId.'/payments/'.$paymentId);
    }

    /**
     * @return PaginatedResult<ExpensePayment>
     */
    public function listPayments(int $expenseId, int $perPage = 50, int $page = 1): PaginatedResult
    {
        return $this->paginated(
            path: 'expenses/'.$expenseId.'/payments',
            query: [
                'per_page' => $perPage,
                'page' => $page,
            ],
            mapper: fn (array $item): ExpensePayment => ExpensePayment::fromArray($this->client, $item),
        );
    }

    public function findPayment(int $expenseId, int $paymentId): ExpensePayment
    {
        $response = $this->http->json('GET', 'expenses/'.$expenseId.'/payments/'.$paymentId);

        return ExpensePayment::fromArray($this->client, $response['data']);
    }

    public function downloadAttachment(int $expenseId): string
    {
        return $this->http->raw('GET', 'expenses/'.$expenseId.'/attachment');
    }

    /**
     * @param array<string, mixed> $payload
     *
     * @return array<string, mixed>
     */
    private function sendExpensePayload(
        string $method,
        string $path,
        array $payload,
        string|\SplFileInfo|null $attachment,
    ): array {
        if ($attachment !== null) {
            return $this->http->multipart(
                method: $method,
                path: $path,
                fields: $payload,
                files: ['attachment' => $attachment],
            );
        }

        return $this->http->json(
            method: $method,
            path: $path,
            json: $payload,
        );
    }
}
