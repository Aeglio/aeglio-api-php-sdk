<?php

declare(strict_types=1);

namespace Aeglio\Tests\Entity;

use Aeglio\Aeglio;
use Aeglio\Entity\Expense;
use PHPUnit\Framework\TestCase;

final class ExpenseTest extends TestCase
{
    public function test_from_array_maps_nested_payments_and_attachment(): void
    {
        $expense = Expense::fromArray(
            new Aeglio(token: 'test-token'),
            [
                'id' => 5,
                'client_id' => 2,
                'project_id' => 7,
                'category_id' => 3,
                'tax_rate_id' => 9,
                'user_id' => 4,
                'invoice_row_id' => 12,
                'number' => 'EXP-005',
                'reference_number' => 'REF-EXP-5',
                'state' => 'paid',
                'issued_at' => '2026-04-24',
                'due_at' => '2026-04-30',
                'notes' => 'Hotel',
                'billable' => true,
                'amount' => 120.50,
                'tax' => 26.51,
                'payments_total' => 147.01,
                'total_to_pay' => 0,
                'payments' => [
                    [
                        'id' => 99,
                        'expense_id' => 5,
                        'sum' => 147.01,
                        'notes' => 'Bank transfer',
                        'paid_at' => '2026-04-25',
                        'created_at' => '2026-04-25T10:00:00Z',
                        'updated_at' => '2026-04-25T10:00:00Z',
                    ],
                ],
                'attachment' => [
                    'name' => 'receipt.pdf',
                    'download_url' => 'https://api.aeglio.com/v1/expenses/5/attachment',
                ],
                'created_at' => '2026-04-24T09:00:00Z',
                'updated_at' => '2026-04-24T09:30:00Z',
            ],
        );

        self::assertSame(5, $expense->id);
        self::assertSame('EXP-005', $expense->number);
        self::assertSame('REF-EXP-5', $expense->referenceNumber);
        self::assertSame('2026-04-24', $expense->issuedAt);
        self::assertSame('2026-04-30', $expense->dueAt);
        self::assertTrue($expense->billable);
        self::assertCount(1, $expense->payments);
        self::assertSame('receipt.pdf', $expense->attachment['name']);
        self::assertSame(99, $expense->payments[0]->id);
    }
}
