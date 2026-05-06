<?php

declare(strict_types=1);

namespace Aeglio\Tests\Dto;

use Aeglio\Dto\UpdateClientData;
use PHPUnit\Framework\TestCase;

final class UpdateClientDataTest extends TestCase
{
    public function test_to_array_includes_only_provided_extended_client_fields(): void
    {
        $dto = new UpdateClientData(
            countryCode: 'FI',
            vatNumber: 'FI12345678',
            city: 'Helsinki',
            postalCode: '00100',
            stateRegion: 'Uusimaa',
        );

        self::assertSame([
            'country_code' => 'FI',
            'vat_number' => 'FI12345678',
            'city' => 'Helsinki',
            'postal_code' => '00100',
            'state_region' => 'Uusimaa',
        ], $dto->toArray());
    }
}
