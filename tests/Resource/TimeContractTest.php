<?php

declare(strict_types=1);
namespace Aeglio\Tests\Resource;

use Aeglio\Aeglio;
use Aeglio\Http\HttpClient;
use PHPUnit\Framework\TestCase;

final class TimeContractTest extends TestCase
{
    public function test_start_preserves_operation_and_returns_versioned_public_entry(): void
    {
        $seen = null;
        $api = new Aeglio('test', httpClient: new HttpClient('https://example.test/v1', 'test', function ($method, $path, $query, $body) use (&$seen) {
            $seen = [$method, $path, $body];
            return ['status' => 201, 'body' => json_encode(['data' => ['id' => 'public-id', 'project_id' => 4, 'category_id' => 5, 'description' => 'Work', 'date' => '2026-11-06', 'start' => '2026-11-06T12:00:00Z', 'end' => null, 'duration_seconds' => 0, 'version' => 1, 'state' => 'running'], 'revision' => 2])];
        }));
        $result = $api->time()->start(new \Aeglio\Dto\StartTimerData('operation', '2026-11-06T12:00:00Z', '2026-11-06T13:00:00Z', 1, 4, 5, 'Work'));
        self::assertSame(['POST', 'timer/start'], array_slice($seen, 0, 2));
        self::assertSame('operation', $seen[2]['operation_id']);
        self::assertSame('public-id', $result->data->id);
        self::assertSame(2, $result->revision);
        self::assertNull($result->data->end);
    }
}
