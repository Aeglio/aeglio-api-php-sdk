<?php

declare(strict_types=1);

namespace Aeglio\Tests\Dto;

use Aeglio\Dto\ClientData;
use PHPUnit\Framework\TestCase;

final class ClientDataTest extends TestCase
{
    public function test_to_array_includes_extended_client_and_counterparty_fields(): void
    {
        $dto = new ClientData(
            name: 'Acme Ltd',
            locale: 'en_US',
            regCode: '12345678',
            countryCode: 'EE',
            vatNumber: 'EE123456789',
            address: 'Main Street 1',
            city: 'Tallinn',
            postalCode: '10115',
            stateRegion: 'Harju maakond',
            notes: 'Important client',
            paymentRecipientName: 'Acme Payments',
            paymentRecipientIban: 'EE471000001020145685',
            matchAliases: ['ACME', 'Acme OÜ'],
            isClient: true,
            isSupplier: true,
        );

        self::assertSame([
            'name' => 'Acme Ltd',
            'locale' => 'en_US',
            'reg_code' => '12345678',
            'country_code' => 'EE',
            'vat_number' => 'EE123456789',
            'address' => 'Main Street 1',
            'city' => 'Tallinn',
            'postal_code' => '10115',
            'state_region' => 'Harju maakond',
            'notes' => 'Important client',
            'payment_recipient_name' => 'Acme Payments',
            'payment_recipient_iban' => 'EE471000001020145685',
            'match_aliases' => ['ACME', 'Acme OÜ'],
            'is_client' => true,
            'is_supplier' => true,
        ], $dto->toArray());
    }
}
