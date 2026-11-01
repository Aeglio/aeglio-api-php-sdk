<?php

declare(strict_types=1);

namespace Aeglio\Entity;

final readonly class RecurringInvoice
{
    private function __construct(
        public int $id,
        public string $firstIssueAt,
        public int $frequency,
        public string $frequencyUnit,
        public ?string $dateRule,
        public ?string $periodUnit,
        public ?int $periodOffset,
        public ?int $numberOfTimes,
        public ?string $endsAt,
        public int $dueInDays,
        public bool $sendAutomatically,
        public bool $sendCopy,
        public array $recipientIds,
        public ?string $generationError,
        public int $generationAttempts,
        public ?string $nextIssueAt,
        public Invoice $template,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(\Aeglio\Aeglio $client, array $data): self
    {
        return new self(
            id: (int) ($data['id'] ?? 0),
            firstIssueAt: (string) ($data['first_issue_at'] ?? ''),
            frequency: (int) ($data['frequency'] ?? 0),
            frequencyUnit: (string) ($data['frequency_unit'] ?? ''),
            dateRule: isset($data['date_rule']) ? (string) $data['date_rule'] : null,
            periodUnit: isset($data['period_unit']) ? (string) $data['period_unit'] : null,
            periodOffset: isset($data['period_offset']) ? (int) $data['period_offset'] : null,
            numberOfTimes: isset($data['number_of_times']) ? (int) $data['number_of_times'] : null,
            endsAt: isset($data['ends_at']) ? (string) $data['ends_at'] : null,
            dueInDays: (int) ($data['due_in_days'] ?? 0),
            sendAutomatically: (bool) ($data['send_automatically'] ?? false),
            sendCopy: (bool) ($data['send_copy'] ?? false),
            recipientIds: (array) ($data['recipient_ids'] ?? []),
            generationError: isset($data['generation_error']) ? (string) $data['generation_error'] : null,
            generationAttempts: (int) ($data['generation_attempts'] ?? 0),
            nextIssueAt: isset($data['next_issue_at']) ? (string) $data['next_issue_at'] : null,
            template: Invoice::fromArray($client, $data['template'] ?? []),
        );
    }
}
