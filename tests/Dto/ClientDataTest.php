<?php

declare(strict_types=1);

namespace Aeglio\Tests\Dto;

use Aeglio\Dto\ClientData;
use PHPUnit\Framework\TestCase;

final class ClientDataTest extends TestCase
{
    public function test_to_array_includes_extended_client_billing_fields(): void
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
        ], $dto->toArray());
    }
}
