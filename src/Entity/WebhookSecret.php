<?php

declare(strict_types=1);

namespace Aeglio\Entity;

final readonly class WebhookSecret
{
    public function __construct(public Webhook $webhook, public string $signingSecret)
    {
    }
}
