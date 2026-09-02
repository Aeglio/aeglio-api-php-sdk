<?php

declare(strict_types=1);

namespace Aeglio\Tests\Entity;

use Aeglio\Entity\Estimate;
use PHPUnit\Framework\TestCase;

final class EstimateTest extends TestCase
{
    public function test_from_array_maps_revision_identity_and_lifecycle(): void
    {
        $estimate = Estimate::fromArray([
            'id' => 12,
            'deal_id' => 4,
            'client_id' => 7,
            'number' => 'EST-2026-001',
            'revision_number' => 2,
            'previous_revision_id' => 11,
            'title' => 'Website implementation',
            'state' => 'superseded',
            'currency' => 'EUR',
            'issued_at' => '2026-09-01',
            'valid_until' => '2026-10-01',
            'sent_at' => '2026-09-01T10:00:00Z',
            'accepted_at' => null,
            'rejected_at' => null,
            'expired_at' => null,
            'superseded_at' => '2026-09-02T10:00:00Z',
            'cancelled_at' => null,
            'notes' => 'Customer-facing notes',
            'terms' => 'Commercial terms',
            'created_at' => '2026-09-01T09:00:00Z',
            'updated_at' => '2026-09-02T10:00:00Z',
        ]);

        self::assertSame(12, $estimate->id);
        self::assertSame(2, $estimate->revisionNumber);
        self::assertSame(11, $estimate->previousRevisionId);
        self::assertSame('superseded', $estimate->state);
        self::assertSame('2026-09-02T10:00:00Z', $estimate->supersededAt);
        self::assertNull($estimate->cancelledAt);
    }
}
