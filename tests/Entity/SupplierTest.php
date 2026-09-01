<?php

declare(strict_types=1);

namespace Aeglio\Tests\Entity;

use Aeglio\Aeglio;
use Aeglio\Entity\Supplier;
use PHPUnit\Framework\TestCase;

final class SupplierTest extends TestCase
{
    public function test_from_array_maps_supplier_fields(): void
    {
        $supplier = Supplier::fromArray(
            new Aeglio(token: 'test-token'),
            [
                'id' => 12,
                'name' => 'Vendor Ltd',
                'email' => 'billing@vendor.test',
                'locale' => 'en_US',
                'payment_recipient_name' => 'Vendor Ltd',
                'payment_recipient_iban' => 'EE471000001020145685',
                'match_aliases' => ['Vendor', 'Vendor OU'],
                'is_client' => false,
                'is_supplier' => true,
            ],
        );

        self::assertSame(12, $supplier->id);
        self::assertSame('billing@vendor.test', $supplier->email);
        self::assertSame('Vendor Ltd', $supplier->paymentRecipientName);
        self::assertSame('EE471000001020145685', $supplier->paymentRecipientIban);
        self::assertSame(['Vendor', 'Vendor OU'], $supplier->matchAliases);
        self::assertFalse($supplier->isClient);
        self::assertTrue($supplier->isSupplier);
    }
}
