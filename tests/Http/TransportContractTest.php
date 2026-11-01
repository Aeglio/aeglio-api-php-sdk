<?php

declare(strict_types=1);

namespace Aeglio\Tests\Http;

use Aeglio\Exception\ApiException;
use Aeglio\Http\HttpClient;
use PHPUnit\Framework\TestCase;

class TransportContractTest extends TestCase
{
    public function test_rate_limit_preserves_retry_metadata_without_retrying(): void
    {
        $calls = 0;
        $http = new HttpClient('https://example.test/v1', 'test', function () use (&$calls): array {
            $calls++;
            return ['status' => 429, 'body' => '{"message":"Slow down"}', 'headers' => ['retry-after' => '30']];
        });
        try {
            $http->json('POST', 'invoices/1/send', json: ['recipients' => []]);
            self::fail('Expected rate limit error');
        } catch (ApiException $error) {
            self::assertSame(429, $error->getCode());
            self::assertSame('30', $error->headers['retry-after']);
        }
        self::assertSame(1, $calls);
    }

    public function test_successful_invalid_json_is_not_an_empty_result(): void
    {
        $http = new HttpClient('https://example.test/v1', 'test', fn () => ['status' => 200, 'body' => '<html>Proxy error</html>', 'headers' => []]);
        $this->expectException(ApiException::class);
        $http->json('GET', 'tasks');
    }
    public function test_multipart_uses_laravel_boolean_values(): void
    {
        $fields = [];
        $http = new HttpClient('https://example.test', 'test', function ($method, $path, $query, $json, $multipart) use (&$fields): array {
            $fields = $multipart;
            return ['status' => 204, 'body' => '', 'headers' => []];
        });
        $http->multipart('POST', 'expenses', fields: ['billable' => true]);
        self::assertSame('1', $fields['billable']);
    }

    public function test_false_query_filter_is_encoded_as_zero(): void
    {
        $http = new HttpClient('https://example.test/v1', 'test');
        $method = new \ReflectionMethod(HttpClient::class, 'buildUrl');
        self::assertSame('https://example.test/v1/tasks?archived=0', $method->invoke($http, 'tasks', ['archived' => false]));
    }

}
