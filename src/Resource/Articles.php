<?php

declare(strict_types=1);

namespace Aeglio\Resource;

use Aeglio\Collection\PaginatedResult;
use Aeglio\Dto\ArticleData;
use Aeglio\Dto\UpdateArticleData;
use Aeglio\Entity\Article;

final class Articles extends BaseResource
{
    /**
     * @return PaginatedResult<Article>
     */
    public function list(int $perPage = 50, int $page = 1, ?string $search = null, ?bool $active = null, ?bool $sellable = null, ?bool $purchasable = null): PaginatedResult
    {
        return $this->paginated(
            path: 'articles',
            query: array_filter([
                'per_page' => $perPage,
                'page' => $page,
                'search' => $search,
                'active' => $active === null ? null : (int) $active,
                'sellable' => $sellable === null ? null : (int) $sellable,
                'purchasable' => $purchasable === null ? null : (int) $purchasable,
            ], static fn ($value): bool => $value !== null),
            mapper: fn (array $item): Article => Article::fromArray($this->client, $item),
        );
    }

    public function find(int $id): Article
    {
        $response = $this->http->json('GET', 'articles/'.$id);

        return Article::fromArray($this->client, $response['data']);
    }

    public function create(ArticleData $data): Article
    {
        $response = $this->http->json('POST', 'articles', json: $data->toArray());

        return Article::fromArray($this->client, $response['data']);
    }

    public function update(int $id, UpdateArticleData $data): Article
    {
        $response = $this->http->json('PATCH', 'articles/'.$id, json: $data->toArray());

        return Article::fromArray($this->client, $response['data']);
    }

}
