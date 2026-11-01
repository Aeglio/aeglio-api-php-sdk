<?php

declare(strict_types=1);

namespace Aeglio\Tests\Dto;

use Aeglio\Dto\InvoiceRowData;
use PHPUnit\Framework\TestCase;

final class InvoiceRowDataTest extends TestCase
{
    public function test_to_array_includes_row_id_for_updates(): void
    {
        $dto = new InvoiceRowData(
            id: 55,
            type: 'regular',
            quantity: 2,
            price: 75,
            title: 'Consulting',
            description: '<p><strong>Discovery</strong> workshop</p>',
        );

        self::assertSame([
            'id' => 55,
            'type' => 'regular',
            'title' => 'Consulting',
            'description' => '<p><strong>Discovery</strong> workshop</p>',
            'quantity' => 2.0,
            'price' => 75.0,
        ], $dto->toArray());
    }
    public function test_plural_snapshot_can_be_sent_and_explicitly_cleared(): void
    {
        $row = new InvoiceRowData(type: 'regular', quantity: 2, price: 10, unit: 'hour', unitPlural: 'hours');
        self::assertSame('hours', $row->toArray()['unit_plural']);
        $clear = new InvoiceRowData(type: 'regular', quantity: 2, price: 10, unitPlural: null);
        self::assertArrayHasKey('unit_plural', $clear->toArray());
        self::assertNull($clear->toArray()['unit_plural']);
        self::assertArrayNotHasKey('unit', $clear->toArray());
    }

}
