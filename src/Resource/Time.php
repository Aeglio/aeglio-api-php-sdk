<?php

declare(strict_types=1);
namespace Aeglio\Resource;

use Aeglio\Entity\TimeEntry;
use Aeglio\Entity\TimerState;

final class Time extends BaseResource
{
    public function list(int $perPage = 50, int $page = 1, ?string $date = null, ?int $projectId = null): \Aeglio\Collection\PaginatedResult
    {
        return $this->paginated('time-entries', array_filter(['per_page' => $perPage, 'page' => $page, 'date' => $date, 'project_id' => $projectId], static fn ($v) => $v !== null), fn (array $row) => TimeEntry::fromArray($row));
    }
    public function find(string $id): TimeEntry
    {
        return TimeEntry::fromArray($this->http->json('GET', "time-entries/{$id}")['data']);
    }
    public function current(): TimerState
    {
        return TimerState::fromArray($this->http->json('GET', 'timer'));
    }
    public function create(\Aeglio\Dto\TimeEntryData $data): TimerState
    {
        return TimerState::fromArray($this->http->json('POST', "time-entries", json: $data->toArray()));
    }
    public function update(string $id, \Aeglio\Dto\UpdateTimeData $data): TimerState
    {
        return TimerState::fromArray($this->http->json('PATCH', "time-entries/{$id}", json: $data->toArray()));
    }
    public function delete(string $id, \Aeglio\Dto\DeleteTimeData $data): TimerState
    {
        return TimerState::fromArray($this->http->json('DELETE', "time-entries/{$id}", json: $data->toArray()));
    }
    public function start(\Aeglio\Dto\StartTimerData $data): TimerState
    {
        return TimerState::fromArray($this->http->json('POST', "timer/start", json: $data->toArray()));
    }
    public function stop(string $id, \Aeglio\Dto\StopTimerData $data): TimerState
    {
        return TimerState::fromArray($this->http->json('POST', "timer/{$id}/stop", json: $data->toArray()));
    }
    public function switchTimer(string $id, \Aeglio\Dto\SwitchTimerData $data): TimerState
    {
        return TimerState::fromArray($this->http->json('POST', "timer/{$id}/switch", json: $data->toArray()));
    }
    public function projects(int $page = 1, ?string $search = null): \Aeglio\Entity\TimeOptions
    {
        return \Aeglio\Entity\TimeOptions::fromArray($this->http->json('GET', "time-projects", query: array_filter(['page' => $page, 'search' => $search], static fn ($v) => $v !== null)));
    }
    public function categories(int $projectId, int $page = 1, ?string $search = null): \Aeglio\Entity\TimeOptions
    {
        return \Aeglio\Entity\TimeOptions::fromArray($this->http->json('GET', "time-projects/{$projectId}/categories", query: array_filter(['page' => $page, 'search' => $search], static fn ($v) => $v !== null)));
    }
    public function tasks(int $projectId, int $page = 1, ?string $search = null): \Aeglio\Entity\TimeOptions
    {
        return \Aeglio\Entity\TimeOptions::fromArray($this->http->json('GET', "time-projects/{$projectId}/tasks", query: array_filter(['page' => $page, 'search' => $search], static fn ($v) => $v !== null)));
    }
}
