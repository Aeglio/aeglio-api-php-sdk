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
            date: '2026-04-24',
            categoryId: 3,
        );

        self::assertSame([
            'number' => 'EXP-001',
            'amount' => 120.5,
            'date' => '2026-04-24',
            'category_id' => 3,
        ], $dto->toArray());
    }
}
