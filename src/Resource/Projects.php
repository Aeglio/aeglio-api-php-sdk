<?php

declare(strict_types=1);

namespace Aeglio\Resource;

use Aeglio\Collection\PaginatedResult;
use Aeglio\Dto\ProjectData;
use Aeglio\Dto\UpdateProjectData;
use Aeglio\Entity\Project;

final class Projects extends BaseResource
{
    /**
     * @return PaginatedResult<Project>
     */
    public function list(?bool $archived = null, int $perPage = 50, int $page = 1): PaginatedResult
    {
        return $this->paginated(
            path: 'projects',
            query: [
                'archived' => $archived,
                'per_page' => $perPage,
                'page' => $page,
            ],
            mapper: fn (array $item): Project => Project::fromArray($this->client, $item),
        );
    }

    public function find(int $id): Project
    {
        $response = $this->http->json('GET', 'projects/'.$id);

        return Project::fromArray($this->client, $response['data']);
    }

    public function create(ProjectData $data): Project
    {
        $response = $this->http->json('POST', 'projects', json: $data->toArray());

        return Project::fromArray($this->client, $response['data']);
    }

    public function update(int $id, UpdateProjectData $data): Project
    {
        $response = $this->http->json('PATCH', 'projects/'.$id, json: $data->toArray());

        return Project::fromArray($this->client, $response['data']);
    }

    public function delete(int $id): void
    {
        $this->http->json('DELETE', 'projects/'.$id);
    }
}
