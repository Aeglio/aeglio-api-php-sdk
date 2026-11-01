<?php

declare(strict_types=1);

namespace Aeglio\Resource;

final class Tasks extends BaseResource
{
    /** @return \Aeglio\Collection\PaginatedResult<\Aeglio\Entity\Task> */
    public function list(int $perPage = 50, int $page = 1, ?\Aeglio\Dto\TaskFilter $filter = null): \Aeglio\Collection\PaginatedResult
    {
        return $this->paginated("tasks", ['per_page' => $perPage, 'page' => $page] + ($filter?->toArray() ?? []), fn (array $row) => \Aeglio\Entity\Task::fromArray($row));
    }

    public function find(int $id): \Aeglio\Entity\Task
    {
        $response = $this->http->json('GET', "tasks/{$id}");
        return \Aeglio\Entity\Task::fromArray($response['data']);
    }

    public function create(\Aeglio\Dto\TaskData $data): \Aeglio\Entity\Task
    {
        $response = $this->http->json('POST', "tasks", json: $data->toArray());
        return \Aeglio\Entity\Task::fromArray($response['data']);
    }

    public function update(int $id, \Aeglio\Dto\UpdateTaskData $data): \Aeglio\Entity\Task
    {
        $response = $this->http->json('PATCH', "tasks/{$id}", json: $data->toArray());
        return \Aeglio\Entity\Task::fromArray($response['data']);
    }

    public function delete(int $id, int $version): void
    {
        $this->http->json('DELETE', "tasks/{$id}", json: ['version' => $version]);
    }

    /** @return \Aeglio\Collection\PaginatedResult<\Aeglio\Entity\TaskProject> */
    public function projects(int $perPage = 50, int $page = 1): \Aeglio\Collection\PaginatedResult
    {
        return $this->paginated("task-projects", ['per_page' => $perPage, 'page' => $page], fn (array $row) => \Aeglio\Entity\TaskProject::fromArray($row));
    }

    /** @return \Aeglio\Collection\PaginatedResult<\Aeglio\Entity\Person> */
    public function assignees(int $projectId, int $perPage = 50, int $page = 1): \Aeglio\Collection\PaginatedResult
    {
        return $this->paginated("task-projects/{$projectId}/assignees", ['per_page' => $perPage, 'page' => $page], fn (array $row) => \Aeglio\Entity\Person::fromArray($row));
    }

    /** @return \Aeglio\Collection\PaginatedResult<\Aeglio\Entity\TaskCategory> */
    public function categories(int $projectId, int $perPage = 50, int $page = 1): \Aeglio\Collection\PaginatedResult
    {
        return $this->paginated("task-projects/{$projectId}/categories", ['per_page' => $perPage, 'page' => $page], fn (array $row) => \Aeglio\Entity\TaskCategory::fromArray($row));
    }

    /** @return \Aeglio\Collection\PaginatedResult<\Aeglio\Entity\TaskStatus> */
    public function statuses(int $perPage = 50, int $page = 1): \Aeglio\Collection\PaginatedResult
    {
        return $this->paginated("task-statuses", ['per_page' => $perPage, 'page' => $page], fn (array $row) => \Aeglio\Entity\TaskStatus::fromArray($row));
    }

    /** @return \Aeglio\Collection\PaginatedResult<\Aeglio\Entity\TaskLabel> */
    public function labels(int $perPage = 50, int $page = 1): \Aeglio\Collection\PaginatedResult
    {
        return $this->paginated("task-labels", ['per_page' => $perPage, 'page' => $page], fn (array $row) => \Aeglio\Entity\TaskLabel::fromArray($row));
    }

    /** @return \Aeglio\Collection\PaginatedResult<\Aeglio\Entity\Task> */
    public function children(int $id, int $perPage = 50, int $page = 1): \Aeglio\Collection\PaginatedResult
    {
        return $this->paginated("tasks/{$id}/children", ['per_page' => $perPage, 'page' => $page], fn (array $row) => \Aeglio\Entity\Task::fromArray($row));
    }

    /** @return \Aeglio\Collection\PaginatedResult<\Aeglio\Entity\TaskComment> */
    public function comments(int $id, int $perPage = 50, int $page = 1): \Aeglio\Collection\PaginatedResult
    {
        return $this->paginated("tasks/{$id}/comments", ['per_page' => $perPage, 'page' => $page], fn (array $row) => \Aeglio\Entity\TaskComment::fromArray($row));
    }

    /** @return \Aeglio\Collection\PaginatedResult<\Aeglio\Entity\ChecklistGroup> */
    public function checklistGroups(int $id, int $perPage = 50, int $page = 1): \Aeglio\Collection\PaginatedResult
    {
        return $this->paginated("tasks/{$id}/checklist-groups", ['per_page' => $perPage, 'page' => $page], fn (array $row) => \Aeglio\Entity\ChecklistGroup::fromArray($row));
    }

    /** @return \Aeglio\Collection\PaginatedResult<\Aeglio\Entity\ChecklistItem> */
    public function checklistItems(int $id, int $perPage = 50, int $page = 1): \Aeglio\Collection\PaginatedResult
    {
        return $this->paginated("tasks/{$id}/checklist-items", ['per_page' => $perPage, 'page' => $page], fn (array $row) => \Aeglio\Entity\ChecklistItem::fromArray($row));
    }

    /** @return \Aeglio\Collection\PaginatedResult<\Aeglio\Entity\TaskAttachment> */
    public function attachments(int $id, int $perPage = 50, int $page = 1): \Aeglio\Collection\PaginatedResult
    {
        return $this->paginated("tasks/{$id}/attachments", ['per_page' => $perPage, 'page' => $page], fn (array $row) => \Aeglio\Entity\TaskAttachment::fromArray($row));
    }

    /** @return \Aeglio\Collection\PaginatedResult<\Aeglio\Entity\TaskActivity> */
    public function activity(int $id, int $perPage = 50, int $page = 1): \Aeglio\Collection\PaginatedResult
    {
        return $this->paginated("tasks/{$id}/activity", ['per_page' => $perPage, 'page' => $page], fn (array $row) => \Aeglio\Entity\TaskActivity::fromArray($row));
    }

    /** @return \Aeglio\Collection\PaginatedResult<\Aeglio\Entity\TaskRelation> */
    public function dependencies(int $id, int $perPage = 50, int $page = 1): \Aeglio\Collection\PaginatedResult
    {
        return $this->paginated("tasks/{$id}/dependencies", ['per_page' => $perPage, 'page' => $page], fn (array $row) => \Aeglio\Entity\TaskRelation::fromArray($row));
    }

    /** @return \Aeglio\Collection\PaginatedResult<\Aeglio\Entity\TaskRelation> */
    public function relations(int $id, int $perPage = 50, int $page = 1): \Aeglio\Collection\PaginatedResult
    {
        return $this->paginated("tasks/{$id}/relations", ['per_page' => $perPage, 'page' => $page], fn (array $row) => \Aeglio\Entity\TaskRelation::fromArray($row));
    }

    public function types(): \Aeglio\Entity\TaskTypes
    {
        $response = $this->http->json('GET', "task-types");
        return \Aeglio\Entity\TaskTypes::fromArray($response['data']);
    }

    public function archive(int $id, int $version, bool $archived = true): \Aeglio\Entity\Task
    {
        $response = $this->http->json('POST', "tasks/{$id}/archive", json: ['version' => $version, 'archived' => $archived]);
        return \Aeglio\Entity\Task::fromArray($response['data']);
    }

    public function setLabels(int $id, int $version, array $labelIds): \Aeglio\Entity\Task
    {
        $response = $this->http->json('PUT', "tasks/{$id}/labels", json: ['version' => $version, 'label_ids' => $labelIds]);
        return \Aeglio\Entity\Task::fromArray($response['data']);
    }

    public function setParent(int $id, int $version, ?int $parentId, ?int $parentVersion = null): \Aeglio\Entity\Task
    {
        $response = $this->http->json('PUT', "tasks/{$id}/parent", json: ['version' => $version, 'parent_id' => $parentId, 'parent_version' => $parentVersion]);
        return \Aeglio\Entity\Task::fromArray($response['data']);
    }

    public function order(int $id, int $version, string $statusId, string $placement, ?int $anchorId = null, ?int $anchorVersion = null, array $acknowledgements = []): \Aeglio\Entity\Task
    {
        $response = $this->http->json('POST', "tasks/{$id}/order", json: ['version' => $version, 'status_id' => $statusId, 'placement' => $placement, 'anchor_id' => $anchorId, 'anchor_version' => $anchorVersion, 'acknowledgements' => $acknowledgements]);
        return \Aeglio\Entity\Task::fromArray($response['data']);
    }

    public function addDependency(int $id, int $version, int $taskId, int $taskVersion): \Aeglio\Entity\Task
    {
        $response = $this->http->json('POST', "tasks/{$id}/dependencies", json: ['version' => $version, 'task_id' => $taskId, 'task_version' => $taskVersion]);
        return \Aeglio\Entity\Task::fromArray($response['data']);
    }

    public function removeDependency(int $id, int $taskId, int $version): void
    {
        $this->http->json('DELETE', "tasks/{$id}/dependencies/{$taskId}", json: ['version' => $version]);
    }

    public function addRelation(int $id, int $version, int $taskId, int $taskVersion): \Aeglio\Entity\Task
    {
        $response = $this->http->json('POST', "tasks/{$id}/relations", json: ['version' => $version, 'task_id' => $taskId, 'task_version' => $taskVersion]);
        return \Aeglio\Entity\Task::fromArray($response['data']);
    }

    public function removeRelation(int $id, int $taskId, int $version): void
    {
        $this->http->json('DELETE', "tasks/{$id}/relations/{$taskId}", json: ['version' => $version]);
    }

    public function createComment(int $id, \Aeglio\Dto\CommentData $data): \Aeglio\Entity\TaskComment
    {
        $response = $this->http->json('POST', "tasks/{$id}/comments", json: $data->toArray());
        return \Aeglio\Entity\TaskComment::fromArray($response['data']);
    }

    public function updateComment(int $id, string $commentId, \Aeglio\Dto\UpdateCommentData $data): \Aeglio\Entity\TaskComment
    {
        $response = $this->http->json('PATCH', "tasks/{$id}/comments/{$commentId}", json: $data->toArray());
        return \Aeglio\Entity\TaskComment::fromArray($response['data']);
    }

    public function deleteComment(int $id, string $commentId, int $version): void
    {
        $this->http->json('DELETE', "tasks/{$id}/comments/{$commentId}", json: ['version' => $version]);
    }

    public function createChecklistGroup(int $id, string $operationId): \Aeglio\Entity\ChecklistGroup
    {
        $response = $this->http->json('POST', "tasks/{$id}/checklist-groups", json: ['operation_id' => $operationId]);
        return \Aeglio\Entity\ChecklistGroup::fromArray($response['data']);
    }

    public function updateChecklistGroup(int $id, string $groupId, int $version, string $title): \Aeglio\Entity\ChecklistGroup
    {
        $response = $this->http->json('PATCH', "tasks/{$id}/checklist-groups/{$groupId}", json: ['version' => $version, 'title' => $title]);
        return \Aeglio\Entity\ChecklistGroup::fromArray($response['data']);
    }

    public function deleteChecklistGroup(int $id, string $groupId, int $version): void
    {
        $this->http->json('DELETE', "tasks/{$id}/checklist-groups/{$groupId}", json: ['version' => $version]);
    }

    public function createChecklistItem(int $id, string $groupId, string $text, string $operationId): \Aeglio\Entity\ChecklistItem
    {
        $response = $this->http->json('POST', "tasks/{$id}/checklist-items", json: ['group_id' => $groupId, 'text' => $text, 'operation_id' => $operationId]);
        return \Aeglio\Entity\ChecklistItem::fromArray($response['data']);
    }

    public function updateChecklistItem(int $id, string $itemId, \Aeglio\Dto\UpdateChecklistItemData $data): \Aeglio\Entity\ChecklistItem
    {
        $response = $this->http->json('PATCH', "tasks/{$id}/checklist-items/{$itemId}", json: $data->toArray());
        return \Aeglio\Entity\ChecklistItem::fromArray($response['data']);
    }

    public function deleteChecklistItem(int $id, string $itemId, int $version): void
    {
        $this->http->json('DELETE', "tasks/{$id}/checklist-items/{$itemId}", json: ['version' => $version]);
    }

    public function convertChecklistItem(int $id, string $itemId, int $version, string $kind): \Aeglio\Entity\Task
    {
        $response = $this->http->json('POST', "tasks/{$id}/checklist-items/{$itemId}/convert", json: ['version' => $version, 'kind' => $kind]);
        return \Aeglio\Entity\Task::fromArray($response['data']);
    }

    public function downloadAttachment(int $id, string $attachmentId): string
    {
        return $this->http->raw('GET', "tasks/{$id}/attachments/{$attachmentId}");
    }

    public function uploadAttachment(int $id, string $path, string $operationId): \Aeglio\Entity\TaskAttachment
    {
        $response = $this->http->multipart('POST', "tasks/{$id}/attachments", fields: ['operation_id' => $operationId], files: ['file' => $path]);
        return \Aeglio\Entity\TaskAttachment::fromArray($response['data']);
    }

    /** True when removed; false means storage cleanup is pending (HTTP 202). */
    public function deleteAttachment(int $id, string $attachmentId): bool
    {
        return $this->http->json('DELETE', "tasks/{$id}/attachments/{$attachmentId}") === [];
    }
    public function orderChecklistItem(int $id, string $itemId, int $version, ?string $anchorId = null, ?int $anchorVersion = null, string $placement = 'before'): \Aeglio\Entity\ChecklistItem
    {
        $response = $this->http->json('POST', "tasks/{$id}/checklist-items/{$itemId}/order", json: ['version' => $version, 'anchor_id' => $anchorId, 'anchor_version' => $anchorVersion, 'placement' => $placement]);
        return \Aeglio\Entity\ChecklistItem::fromArray($response['data']);
    }
}
