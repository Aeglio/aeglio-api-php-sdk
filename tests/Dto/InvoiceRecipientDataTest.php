<?php

declare(strict_types=1);

namespace Aeglio\Tests\Dto;

use Aeglio\Dto\InvoiceRecipientData;
use PHPUnit\Framework\TestCase;

final class InvoiceRecipientDataTest extends TestCase
{
    public function test_client_and_contact_recipients_serialize_with_their_public_ids(): void
    {
        self::assertSame(
            ['type' => 'client', 'id' => 134],
            InvoiceRecipientData::client(134)->toArray(),
        );
        self::assertSame(
            ['type' => 'contact', 'id' => 27],
            InvoiceRecipientData::contact(27)->toArray(),
        );
    }
}
