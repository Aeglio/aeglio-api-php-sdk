<?php

declare(strict_types=1);

namespace Aeglio\Tests\Entity;

use Aeglio\Aeglio;
use Aeglio\Entity\Invoice;
use PHPUnit\Framework\TestCase;

final class InvoiceTest extends TestCase
{
    public function test_from_array_maps_rows_and_payments(): void
    {
        $invoice = Invoice::fromArray(
            new Aeglio(token: 'test-token'),
            [
                'id' => 2,
                'client_id' => 10,
                'number' => 'INV-002',
                'reference_number' => 'REF-1',
                'state' => 'paid',
                'issued_at' => '2026-04-24',
                'sent_at' => '2026-04-24T12:00:00Z',
                'due_at' => '2026-05-01',
                'notes' => 'Thanks',
                'has_tax' => true,
                'subtotal' => 25,
                'tax' => 5.5,
                'total' => 30.5,
                'payments_total' => 30.5,
                'total_to_pay' => 0,
                'rows' => [
                    [
                        'id' => 501,
                        'type' => 'regular',
                        'title' => 'Service',
                        'description' => null,
                        'quantity' => 1,
                        'price' => 25,
                        'tax_rate_id' => 9,
                        'subtotal' => 25,
                        'tax' => 5.5,
                        'total' => 30.5,
                        'created_at' => '2026-04-24T12:00:00Z',
                        'updated_at' => '2026-04-24T12:00:00Z',
                    ],
                ],
                'payments' => [
                    [
                        'id' => 701,
                        'invoice_id' => 2,
                        'sum' => 30.5,
                        'notes' => 'Paid',
                        'paid_at' => '2026-04-24',
                        'created_at' => '2026-04-24T13:00:00Z',
                        'updated_at' => '2026-04-24T13:00:00Z',
                    ],
                ],
                'created_at' => '2026-04-24T11:00:00Z',
                'updated_at' => '2026-04-24T13:00:00Z',
            ],
        );

        self::assertSame(2, $invoice->id);
        self::assertSame('INV-002', $invoice->number);
        self::assertTrue($invoice->hasTax);
        self::assertSame(30.5, $invoice->total);
        self::assertCount(1, $invoice->rows);
        self::assertCount(1, $invoice->payments);
        self::assertSame(501, $invoice->rows[0]->id);
        self::assertSame(701, $invoice->payments[0]->id);
    }
}
