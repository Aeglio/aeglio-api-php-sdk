<?php

declare(strict_types=1);

namespace Aeglio\Tests\Dto;

use Aeglio\Dto\ExpenseData;
use PHPUnit\Framework\TestCase;

final class ExpenseDataTest extends TestCase
{
    public function test_to_array_omits_null_fields(): void
    {
        $dto = new ExpenseData(
            number: 'EXP-001',
            amount: 120.5,
            issuedAt: '2026-04-24',
            dueAt: '2026-04-30',
            categoryId: 3,
            supplierId: 9,
        );

        self::assertSame([
            'number' => 'EXP-001',
            'amount' => 120.5,
            'issued_at' => '2026-04-24',
            'due_at' => '2026-04-30',
            'category_id' => 3,
            'supplier_id' => 9,
        ], $dto->toArray());
    }
}
