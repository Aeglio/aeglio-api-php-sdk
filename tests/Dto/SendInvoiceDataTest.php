<?php

declare(strict_types=1);

namespace Aeglio\Tests\Dto;

use Aeglio\Dto\InvoiceRecipientData;
use Aeglio\Dto\SendInvoiceData;
use PHPUnit\Framework\TestCase;

final class SendInvoiceDataTest extends TestCase
{
    public function test_to_array_uses_team_copy_field_name(): void
    {
        $dto = new SendInvoiceData(
            recipients: [
                InvoiceRecipientData::client(10),
                InvoiceRecipientData::contact(20),
            ],
            teamCopy: true,
            locale: 'fi_FI',
            subject: 'Lasku INV-001',
            body: '<p><strong>Mukautettu viesti.</strong></p>',
            deliveryMode: 'both',
            replyToEmail: 'billing@example.test',
        );

        self::assertSame([
            'recipients' => [
                ['type' => 'client', 'id' => 10],
                ['type' => 'contact', 'id' => 20],
            ],
            'team_copy' => true,
            'locale' => 'fi_FI',
            'subject' => 'Lasku INV-001',
            'body' => '<p><strong>Mukautettu viesti.</strong></p>',
            'delivery_mode' => 'both',
            'reply_to_email' => 'billing@example.test',
        ], $dto->toArray());
    }
}
