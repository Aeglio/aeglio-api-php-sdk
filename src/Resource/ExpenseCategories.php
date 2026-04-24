<?php

declare(strict_types=1);

namespace Aeglio\Resource;

use Aeglio\Collection\PaginatedResult;
use Aeglio\Dto\ExpenseCategoryData;
use Aeglio\Dto\UpdateExpenseCategoryData;
use Aeglio\Entity\ExpenseCategory;

final class ExpenseCategories extends BaseResource
{
    /**
     * @return PaginatedResult<ExpenseCategory>
     */
    public function list(int $perPage = 50, int $page = 1): PaginatedResult
    {
        return $this->paginated(
            path: 'expenses/categories',
            query: [
                'per_page' => $perPage,
                'page' => $page,
            ],
            mapper: fn (array $item): ExpenseCategory => ExpenseCategory::fromArray($this->client, $item),
        );
    }

    public function find(int $id): ExpenseCategory
    {
        $response = $this->http->json('GET', 'expenses/categories/'.$id);

        return ExpenseCategory::fromArray($this->client, $response['data']);
    }

    public function create(ExpenseCategoryData $data): ExpenseCategory
    {
        $response = $this->http->json('POST', 'expenses/categories', json: $data->toArray());

        return ExpenseCategory::fromArray($this->client, $response['data']);
    }

    public function update(int $id, UpdateExpenseCategoryData $data): ExpenseCategory
    {
        $response = $this->http->json('PATCH', 'expenses/categories/'.$id, json: $data->toArray());

        return ExpenseCategory::fromArray($this->client, $response['data']);
    }

    public function delete(int $id): void
    {
        $this->http->json('DELETE', 'expenses/categories/'.$id);
    }
}
