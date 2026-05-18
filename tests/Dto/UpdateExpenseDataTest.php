<?php

declare(strict_types=1);

namespace Aeglio\Tests\Dto;

use Aeglio\Dto\UpdateExpenseData;
use PHPUnit\Framework\TestCase;

final class UpdateExpenseDataTest extends TestCase
{
    public function test_to_array_omits_unset_fields_and_keeps_explicit_nulls(): void
    {
        $dto = new UpdateExpenseData(
            clientId: null,
            supplierId: 11,
            referenceNumber: 'REF-123',
            notes: 'Updated through SDK',
            billable: true,
        );

        self::assertSame([
            'client_id' => null,
            'supplier_id' => 11,
            'reference_number' => 'REF-123',
            'notes' => 'Updated through SDK',
            'billable' => true,
        ], $dto->toArray());
    }
}
