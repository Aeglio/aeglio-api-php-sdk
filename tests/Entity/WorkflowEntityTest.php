<?php

declare(strict_types=1);

namespace Aeglio\Tests\Entity;

use Aeglio\Aeglio;
use Aeglio\Entity\Approval;
use Aeglio\Entity\DealPipeline;
use Aeglio\Entity\Milestone;
use Aeglio\Entity\RecurringInvoice;
use Aeglio\Entity\Task;
use Aeglio\Entity\TaskComment;
use Aeglio\Entity\TaskRelation;
use PHPUnit\Framework\TestCase;

final class WorkflowEntityTest extends TestCase
{
    public function test_task_collaboration_preserves_nested_types_and_positions(): void
    {
        $task = Task::fromArray(['id' => 42, 'position' => 3]);
        self::assertSame(3, $task->position);
        $comment = TaskComment::fromArray(['id' => 'comment', 'author' => ['id' => 'person', 'name' => 'Alex']]);
        self::assertSame('Alex', $comment->author->name);
        $relation = TaskRelation::fromArray(['task_id' => 42, 'direction' => 'blocked_by', 'task' => ['id' => 42]]);
        self::assertSame(42, $relation->task->id);
        $milestone = Milestone::fromArray(['id' => 'milestone', 'progress' => ['total' => 3, 'completed' => 2, 'ready' => false]]);
        self::assertSame(2, $milestone->progress->completed);
    }

    public function test_commercial_nested_records_are_typed(): void
    {
        $pipeline = DealPipeline::fromArray(['id' => 1, 'stages' => [['id' => 7, 'name' => 'Proposal', 'position' => 1]]]);
        self::assertSame(7, $pipeline->stages[0]->id);
        $approval = Approval::fromArray(['id' => 1, 'assignments' => [['id' => 8, 'state' => 'pending']]]);
        self::assertSame('pending', $approval->assignments[0]->state);
        $schedule = RecurringInvoice::fromArray(new Aeglio('test'), ['id' => 1, 'template' => [
            'id' => 2, 'client_id' => 3, 'number' => 'Monthly', 'state' => 'draft', 'currency' => 'USD',
            'issued_at' => '2027-01-01', 'due_at' => '2027-01-15', 'has_tax' => false,
            'subtotal' => 100, 'tax' => 0, 'total' => 100, 'payments_total' => 0, 'total_to_pay' => 100,
        ]]);
        self::assertSame('USD', $schedule->template->currency);
        self::assertSame(100.0, $schedule->template->total);
    }
}
