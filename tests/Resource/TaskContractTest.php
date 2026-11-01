<?php

declare(strict_types=1);

namespace Aeglio\Tests\Resource;

use Aeglio\Aeglio;
use Aeglio\Dto\TaskData;
use Aeglio\Dto\UpdateTaskData;
use Aeglio\Http\HttpClient;
use PHPUnit\Framework\TestCase;

final class TaskContractTest extends TestCase
{
    public function test_assignee_paging_creation_and_explicit_unassignment(): void
    {
        $calls = [];
        $http = new HttpClient('https://example.test', 'test', function ($method, $path, $query, $json) use (&$calls): array {
            $calls[] = [$method, $path, $query, $json];
            $body = $method === 'GET'
                ? ['data' => [['id' => 'person-uuid', 'name' => 'Alex']], 'current_page' => 2, 'last_page' => 3, 'total' => 3, 'per_page' => 1]
                : ['data' => ['id' => 42, 'reference' => 'WEB-7', 'project_id' => 9, 'title' => 'Ship', 'version' => 2, 'assignee_id' => $json['assignee_id'] ?? null]];
            return ['status' => 200, 'body' => json_encode($body), 'headers' => []];
        });
        $api = new Aeglio('test', httpClient: $http);
        $people = $api->tasks()->assignees(9, perPage: 1, page: 2);
        self::assertSame(3, $people->total);
        self::assertSame(2, $people->currentPage);
        $task = $api->tasks()->create(new TaskData(projectId: 9, title: 'Ship', operationId: 'operation-uuid', assigneeId: 'person-uuid'));
        self::assertSame(42, $task->id);
        self::assertSame('person-uuid', $task->assigneeId);
        $api->tasks()->update(42, new UpdateTaskData(version: 2, assigneeId: null));
        self::assertSame(['version' => 2, 'assignee_id' => null], $calls[2][3]);
        self::assertSame('task-projects/9/assignees', $calls[0][1]);
        self::assertSame('tasks/42', $calls[2][1]);
    }
}
