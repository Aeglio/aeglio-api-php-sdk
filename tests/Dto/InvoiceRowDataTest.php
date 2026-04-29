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
        );

        self::assertSame([
            'id' => 55,
            'type' => 'regular',
            'title' => 'Consulting',
            'quantity' => 2.0,
            'price' => 75.0,
        ], $dto->toArray());
    }
}
