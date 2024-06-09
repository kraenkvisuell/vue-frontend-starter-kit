<?php

namespace App\Actions;

use App\Models\Webhook;

class StoreWebhook
{
    public function __invoke($payload, $webhookOrigin = 'stripe', $webhookId = null, $webhookType = null)
    {
        Webhook::create([
            'webhook_origin' => $webhookOrigin,
            'webhook_payload' => $payload,
            'webhook_type' => $webhookType ?: ($payload['type'] ?? null),
            'webhook_id' => $webhookId ?: ($payload['id'] ?? null),
        ]);
    }
}
