<?php

declare(strict_types=1);

namespace Aeglio\Tests\Dto;

use Aeglio\Dto\ProjectData;
use Aeglio\Dto\UpdateProjectData;
use PHPUnit\Framework\TestCase;

final class ProjectCodeTest extends TestCase
{
    public function test_optional_code_preserves_omit_clear_and_server_normalization_intent(): void
    {
        self::assertArrayNotHasKey('code', (new ProjectData(clientId: 1, name: 'Website', type: 'time'))->toArray());
        self::assertSame([], (new UpdateProjectData())->toArray());
        self::assertSame(['code' => null], (new UpdateProjectData(code: null))->toArray());
        self::assertSame(['code' => ' web2 '], (new UpdateProjectData(code: ' web2 '))->toArray());
    }
}
