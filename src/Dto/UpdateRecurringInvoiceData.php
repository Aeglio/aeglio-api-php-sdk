<?php

declare(strict_types=1);

namespace Aeglio\Dto;

use Aeglio\Support\Optional;

final readonly class UpdateRecurringInvoiceData
{
    public function __construct(
        public string|Optional $firstIssueAt = new Optional(),
        public UpdateInvoiceData|Optional $template = new Optional(),
        public int|Optional $frequency = new Optional(),
        public string|Optional $frequencyUnit = new Optional(),
        public string|Optional $dateRule = new Optional(),
        public string|Optional $periodUnit = new Optional(),
        public int|Optional $periodOffset = new Optional(),
        public int|null|Optional $numberOfTimes = new Optional(),
        public string|null|Optional $endsAt = new Optional(),
        public int|Optional $dueInDays = new Optional(),
        public bool|Optional $sendAutomatically = new Optional(),
        public bool|Optional $sendCopy = new Optional(),
        public array|Optional $recipientIds = new Optional(),
    ) {
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return array_filter([
            'first_issue_at' => $this->firstIssueAt,
            'template' => $this->template instanceof Optional ? $this->template : $this->template->toArray(),
            'frequency' => $this->frequency,
            'frequency_unit' => $this->frequencyUnit,
            'date_rule' => $this->dateRule,
            'period_unit' => $this->periodUnit,
            'period_offset' => $this->periodOffset,
            'number_of_times' => $this->numberOfTimes,
            'ends_at' => $this->endsAt,
            'due_in_days' => $this->dueInDays,
            'send_automatically' => $this->sendAutomatically,
            'send_copy' => $this->sendCopy,
            'recipient_ids' => $this->recipientIds,
        ], static fn (mixed $value): bool => ! $value instanceof Optional);
    }
}
