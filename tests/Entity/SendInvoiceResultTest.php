<?php

declare(strict_types=1);

namespace Aeglio\Tests\Entity;

use Aeglio\Entity\SendInvoiceResult;
use PHPUnit\Framework\TestCase;

final class SendInvoiceResultTest extends TestCase
{
    public function test_from_array_keeps_typed_recipient_public_id(): void
    {
        $result = SendInvoiceResult::fromArray([
            'message' => 'Invoice sent.',
            'sent_to' => [[
                'type' => 'client',
                'id' => 134,
                'name' => 'Mari Maasikas',
                'email' => 'mari@example.test',
            ]],
        ]);

        self::assertSame('Invoice sent.', $result->message);
        self::assertSame('client', $result->sentTo[0]['type']);
        self::assertSame(134, $result->sentTo[0]['id']);
    }
}
