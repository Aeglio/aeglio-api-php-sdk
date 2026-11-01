<?php

declare(strict_types=1);

namespace Aeglio\Resource;

final class Milestones extends BaseResource
{
    /** @return \Aeglio\Collection\PaginatedResult<\Aeglio\Entity\Milestone> */
    public function list(int $perPage = 50, int $page = 1): \Aeglio\Collection\PaginatedResult
    {
        return $this->paginated("milestones", ['per_page' => $perPage, 'page' => $page], fn (array $row) => \Aeglio\Entity\Milestone::fromArray($row));
    }

    public function find(string $id): \Aeglio\Entity\Milestone
    {
        $response = $this->http->json('GET', "milestones/{$id}");
        return \Aeglio\Entity\Milestone::fromArray($response['data']);
    }

    public function create(\Aeglio\Dto\MilestoneData $data): \Aeglio\Entity\Milestone
    {
        $response = $this->http->json('POST', "milestones", json: $data->toArray());
        return \Aeglio\Entity\Milestone::fromArray($response['data']);
    }

    public function update(string $id, \Aeglio\Dto\UpdateMilestoneData $data): \Aeglio\Entity\Milestone
    {
        $response = $this->http->json('PATCH', "milestones/{$id}", json: $data->toArray());
        return \Aeglio\Entity\Milestone::fromArray($response['data']);
    }

    /** @return \Aeglio\Collection\PaginatedResult<\Aeglio\Entity\Task> */
    public function tasks(string $id, int $perPage = 50, int $page = 1): \Aeglio\Collection\PaginatedResult
    {
        return $this->paginated("milestones/{$id}/tasks", ['per_page' => $perPage, 'page' => $page], fn (array $row) => \Aeglio\Entity\Task::fromArray($row));
    }

    public function setTasks(string $id, int $version, array $taskIds): \Aeglio\Entity\Milestone
    {
        $response = $this->http->json('PUT', "milestones/{$id}/tasks", json: ['version' => $version, 'task_ids' => $taskIds]);
        return \Aeglio\Entity\Milestone::fromArray($response['data']);
    }

    public function transition(string $id, int $version, string $state, ?string $reason = null): \Aeglio\Entity\Milestone
    {
        $response = $this->http->json('POST', "milestones/{$id}/transition", json: ['version' => $version, 'state' => $state, 'reason' => $reason]);
        return \Aeglio\Entity\Milestone::fromArray($response['data']);
    }
}
