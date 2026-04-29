<?php

declare(strict_types=1);

namespace Aeglio\Tests\Dto;

use Aeglio\Dto\SendInvoiceData;
use PHPUnit\Framework\TestCase;

final class SendInvoiceDataTest extends TestCase
{
    public function test_to_array_uses_team_copy_field_name(): void
    {
        $dto = new SendInvoiceData(
            contactIds: [10, 20],
            teamCopy: true,
        );

        self::assertSame([
            'contact_ids' => [10, 20],
            'team_copy' => true,
        ], $dto->toArray());
    }
}
