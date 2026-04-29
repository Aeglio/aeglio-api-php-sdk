<?php

declare(strict_types=1);

namespace Aeglio\Tests\Entity;

use Aeglio\Aeglio;
use Aeglio\Entity\Project;
use PHPUnit\Framework\TestCase;

final class ProjectTest extends TestCase
{
    public function test_from_array_maps_budget_and_rate_fields(): void
    {
        $project = Project::fromArray(
            new Aeglio(token: 'test-token'),
            [
                'id' => 8,
                'client_id' => 3,
                'name' => 'Website rebuild',
                'type' => 'time',
                'code' => 'WEB',
                'notes' => 'Priority project',
                'archived' => false,
                'start_at' => '2026-04-01',
                'end_at' => '2026-05-01',
                'budget_type' => 'hours',
                'budget_total' => 120,
                'budget_threshold' => 80,
                'budget_threshold_notify' => true,
                'hourly_rate_type' => 'project_hourly_rate',
                'hourly_rate' => 95.5,
                'fee' => 1500,
                'fee_currency' => 'EUR',
                'created_at' => '2026-04-01T09:00:00Z',
                'updated_at' => '2026-04-02T09:00:00Z',
            ],
        );

        self::assertSame(8, $project->id);
        self::assertSame(80, $project->budgetThreshold);
        self::assertTrue($project->budgetThresholdNotify);
        self::assertSame('project_hourly_rate', $project->hourlyRateType);
        self::assertSame(95.5, $project->hourlyRate);
        self::assertSame(1500.0, $project->fee);
        self::assertSame('EUR', $project->feeCurrency);
    }
}
