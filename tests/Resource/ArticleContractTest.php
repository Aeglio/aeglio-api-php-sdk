<?php

declare(strict_types=1);

namespace Aeglio\Tests\Resource;

use Aeglio\Aeglio;
use Aeglio\Dto\ArticleData;
use Aeglio\Dto\UpdateArticleData;
use Aeglio\Http\HttpClient;
use PHPUnit\Framework\TestCase;

final class ArticleContractTest extends TestCase
{
    public function test_article_catalogue_requests_and_plural_snapshots(): void
    {
        $calls = [];
        $http = new HttpClient('https://example.test', 'test', function ($method, $path, $query, $json) use (&$calls): array {
            $calls[] = [$method, $path, $query, $json];
            $article = ['id' => 8, 'name' => 'Labour', 'currency' => 'EUR', 'unit' => 'hour', 'unit_plural' => 'hours',
                'default_sales_price' => '25.1200', 'sellable' => true, 'purchasable' => true, 'active' => true];
            $body = $path === 'articles' && $method === 'GET'
                ? ['data' => [$article], 'meta' => ['current_page' => 2, 'last_page' => 2, 'total' => 2, 'per_page' => 1]]
                : ['data' => $article];
            return ['status' => 200, 'body' => json_encode($body), 'headers' => []];
        });
        $api = new Aeglio('test', httpClient: $http);
        $api->articles()->list(perPage: 1, page: 2, search: 'Labour', active: false);
        $article = $api->articles()->find(8);
        self::assertSame('hours', $article->unitPlural);
        self::assertSame('25.1200', $article->defaultSalesPrice);
        $api->articles()->create(new ArticleData(name: 'Labour', currency: 'EUR', unit: 'hour', unitPlural: 'hours'));
        $article->update(new UpdateArticleData(active: false, unitPlural: null));
        self::assertSame(['unit_plural' => null, 'active' => false], $calls[3][3]);
        self::assertSame('hours', $calls[2][3]['unit_plural']);
        self::assertFalse((bool) $calls[0][2]['active']);
        self::assertSame('PATCH', $calls[3][0]);
        self::assertSame('articles/8', $calls[3][1]);
    }
}
