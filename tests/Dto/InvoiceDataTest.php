<?php

declare(strict_types=1);

namespace Aeglio\Tests\Dto;

use Aeglio\Dto\InvoiceData;
use Aeglio\Dto\InvoiceRowData;
use PHPUnit\Framework\TestCase;

final class InvoiceDataTest extends TestCase
{
    public function test_to_array_serializes_rows(): void
    {
        $dto = new InvoiceData(
            clientId: 10,
            number: 'INV-001',
            issuedAt: '2026-04-24',
            dueAt: '2026-05-01',
            rows: [
                new InvoiceRowData(
                    type: 'regular',
                    quantity: 2,
                    price: 75,
                    title: 'Consulting',
                ),
            ],
        );

        self::assertSame([
            'client_id' => 10,
            'number' => 'INV-001',
            'issued_at' => '2026-04-24',
            'due_at' => '2026-05-01',
            'rows' => [
                [
                    'type' => 'regular',
                    'title' => 'Consulting',
                    'quantity' => 2.0,
                    'price' => 75.0,
                ],
            ],
        ], $dto->toArray());
    }
}
