<?php

declare(strict_types=1);

namespace Aeglio\Tests\Dto;

use Aeglio\Aeglio;
use Aeglio\Dto\ClientData;
use Aeglio\Dto\InvoicePaymentData;
use Aeglio\Dto\UpdateProjectData;
use Aeglio\Entity\Project;
use PHPUnit\Framework\TestCase;

final class CurrencyContractTest extends TestCase
{
    public function test_currency_is_sent_and_omission_preserved(): void
    {
        self::assertSame('USD', (new ClientData(name: 'Client', locale: 'en_US', currency: 'USD'))->toArray()['currency']);
        self::assertSame('GBP', (new UpdateProjectData(currency: 'GBP'))->toArray()['currency']);
        self::assertArrayNotHasKey('currency', (new UpdateProjectData())->toArray());
        self::assertSame('EUR', (new InvoicePaymentData(sum: 10, paidAt: '2026-11-01', currency: 'EUR'))->toArray()['currency']);
    }

    public function test_project_maps_current_currency_without_reinterpreting_legacy_fee_currency(): void
    {
        $project = Project::fromArray(new Aeglio('test'), [
            'id' => 1, 'name' => 'Project', 'type' => 'time', 'archived' => false, 'currency' => 'USD',
        ]);
        self::assertSame('USD', $project->currency);
        self::assertNull($project->feeCurrency);
    }
}
