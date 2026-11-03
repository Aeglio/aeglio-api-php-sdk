<?php

declare(strict_types=1);

namespace Aeglio\Tests\Dto;

use Aeglio\Dto\EstimateData;
use Aeglio\Dto\EstimateRowData;
use Aeglio\Dto\InvoiceData;
use Aeglio\Dto\RecurringInvoiceData;
use Aeglio\Dto\UpdateInvoiceData;
use Aeglio\Dto\UpdateRecurringInvoiceData;
use PHPUnit\Framework\TestCase;

final class WorkflowPayloadTest extends TestCase
{
    public function test_task_image_html_survives_entity_and_update_payload_round_trip(): void
    {
        $html = '<h2>Screenshot</h2><blockquote>Review</blockquote><pre><code data-language="javascript">example()</code></pre><table><thead><tr><th align="left">Name</th></tr></thead><tbody><tr><td>Example</td></tr></tbody></table><img data-task-image="550e8400-e29b-41d4-a716-446655440000" src="/task-images/550e8400-e29b-41d4-a716-446655440000">';
        $task = \Aeglio\Entity\Task::fromArray(['id' => 1, 'version' => 2, 'description' => $html, 'description_format' => 'html']);
        $payload = new \Aeglio\Dto\UpdateTaskData(version: $task->version, description: $task->description, descriptionFormat: $task->descriptionFormat);
        self::assertSame($html, $payload->toArray()['description']);
        self::assertSame('html', $payload->toArray()['description_format']);
    }

    public function test_estimate_rows_are_serialized_and_omitted_client_can_be_resolved_from_deal(): void
    {
        $data = new EstimateData(title: 'Work', number: 'EST-1', issuedAt: '2027-01-01', validUntil: '2027-02-01',
            currency: 'USD', operationId: 'operation', dealId: 7, rows: [new EstimateRowData('Service', 2, 50, articleId: 9)]);
        self::assertArrayNotHasKey('client_id', $data->toArray());
        self::assertSame(7, $data->toArray()['deal_id']);
        self::assertSame(9, $data->toArray()['rows'][0]['article_id']);
        self::assertSame(50.0, $data->toArray()['rows'][0]['price']);
    }

    public function test_recurring_templates_preserve_nested_null_vs_omitted(): void
    {
        $data = new RecurringInvoiceData(firstIssueAt: '2027-01-01', operationId: 'operation',
            template: new InvoiceData(clientId: 7, number: 'Monthly', issuedAt: '2027-01-01', dueAt: '2027-01-15', currency: 'EUR'));
        self::assertSame('EUR', $data->toArray()['template']['currency']);
        $update = new UpdateRecurringInvoiceData(template: new UpdateInvoiceData(notes: null));
        self::assertSame(['template' => ['notes' => null]], $update->toArray());
    }
}
