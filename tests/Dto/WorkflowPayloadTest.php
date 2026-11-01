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
