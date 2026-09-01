<?php

declare(strict_types=1);

namespace Aeglio\Tests\Entity;

use Aeglio\Aeglio;
use Aeglio\Entity\Client;
use PHPUnit\Framework\TestCase;

final class ClientTest extends TestCase
{
    public function test_from_array_maps_extended_client_and_counterparty_fields(): void
    {
        $client = Client::fromArray(
            new Aeglio(token: 'test-token'),
            [
                'id' => 7,
                'name' => 'Acme Ltd',
                'email' => 'billing@acme.test',
                'reg_code' => '12345678',
                'country_code' => 'EE',
                'vat_number' => 'EE123456789',
                'address' => 'Main Street 1',
                'city' => 'Tallinn',
                'postal_code' => '10115',
                'state_region' => 'Harju maakond',
                'notes' => 'Important client',
                'locale' => 'en_US',
                'payment_recipient_name' => 'Acme Payments',
                'payment_recipient_iban' => 'EE471000001020145685',
                'match_aliases' => ['ACME', 'Acme OÜ'],
                'is_client' => true,
                'is_supplier' => true,
                'created_at' => '2026-05-06T09:00:00Z',
                'updated_at' => '2026-05-06T10:00:00Z',
            ],
        );

        self::assertSame(7, $client->id);
        self::assertSame('billing@acme.test', $client->email);
        self::assertSame('EE', $client->countryCode);
        self::assertSame('EE123456789', $client->vatNumber);
        self::assertSame('Tallinn', $client->city);
        self::assertSame('10115', $client->postalCode);
        self::assertSame('Harju maakond', $client->stateRegion);
        self::assertSame('Acme Payments', $client->paymentRecipientName);
        self::assertSame('EE471000001020145685', $client->paymentRecipientIban);
        self::assertSame(['ACME', 'Acme OÜ'], $client->matchAliases);
        self::assertTrue($client->isClient);
        self::assertTrue($client->isSupplier);
    }
}
