<?php

declare(strict_types=1);

namespace Aeglio\Resource;

final class Webhooks extends BaseResource
{
    /** @return \Aeglio\Collection\PaginatedResult<\Aeglio\Entity\Webhook> */
    public function list(int $perPage = 50, int $page = 1): \Aeglio\Collection\PaginatedResult
    {
        return $this->paginated("webhooks", ['per_page' => $perPage, 'page' => $page], fn (array $row) => \Aeglio\Entity\Webhook::fromArray($row));
    }

    public function find(int $id): \Aeglio\Entity\Webhook
    {
        $response = $this->http->json('GET', "webhooks/{$id}");
        return \Aeglio\Entity\Webhook::fromArray($response['data']);
    }

    public function update(int $id, \Aeglio\Dto\UpdateWebhookData $data): \Aeglio\Entity\Webhook
    {
        $response = $this->http->json('PATCH', "webhooks/{$id}", json: $data->toArray());
        return \Aeglio\Entity\Webhook::fromArray($response['data']);
    }

    public function delete(int $id): void
    {
        $this->http->json('DELETE', "webhooks/{$id}");
    }

    public function pause(int $id): \Aeglio\Entity\Webhook
    {
        $response = $this->http->json('POST', "webhooks/{$id}/pause");
        return \Aeglio\Entity\Webhook::fromArray($response['data']);
    }

    public function resume(int $id): \Aeglio\Entity\Webhook
    {
        $response = $this->http->json('POST', "webhooks/{$id}/resume");
        return \Aeglio\Entity\Webhook::fromArray($response['data']);
    }

    /** @return \Aeglio\Collection\PaginatedResult<\Aeglio\Entity\WebhookDelivery> */
    public function deliveries(int $id, int $perPage = 50, int $page = 1): \Aeglio\Collection\PaginatedResult
    {
        return $this->paginated("webhooks/{$id}/deliveries", ['per_page' => $perPage, 'page' => $page], fn (array $row) => \Aeglio\Entity\WebhookDelivery::fromArray($row));
    }

    public function create(\Aeglio\Dto\WebhookData $data): \Aeglio\Entity\WebhookSecret
    {
        $response = $this->http->json('POST', "webhooks", json: $data->toArray());
        return new \Aeglio\Entity\WebhookSecret(\Aeglio\Entity\Webhook::fromArray($response['data']), $response['signing_secret']);
    }

    public function rotateSecret(int $id): \Aeglio\Entity\WebhookSecret
    {
        $response = $this->http->json('POST', "webhooks/{$id}/rotate-secret");
        return new \Aeglio\Entity\WebhookSecret(\Aeglio\Entity\Webhook::fromArray($response['data']), $response['signing_secret']);
    }
}
