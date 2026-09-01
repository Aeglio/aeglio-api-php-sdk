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
            'delivery' => [
                'id' => '5034f81f-d0ab-49ae-bc54-a42ef889cb41',
                'locale' => 'fi_FI',
                'subject' => 'Lasku INV-001',
                'delivery_mode' => 'both',
                'reply_to_email' => 'billing@example.test',
            ],
            'sent_to' => [[
                'type' => 'client',
                'id' => 134,
                'name' => 'Mari Maasikas',
                'email' => 'mari@example.test',
            ]],
        ]);

        self::assertSame('Invoice sent.', $result->message);
        self::assertSame('5034f81f-d0ab-49ae-bc54-a42ef889cb41', $result->deliveryId);
        self::assertSame('fi_FI', $result->locale);
        self::assertSame('Lasku INV-001', $result->subject);
        self::assertSame('both', $result->deliveryMode);
        self::assertSame('billing@example.test', $result->replyToEmail);
        self::assertSame('client', $result->sentTo[0]['type']);
        self::assertSame(134, $result->sentTo[0]['id']);
    }
}
