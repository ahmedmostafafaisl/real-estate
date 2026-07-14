<?php

namespace App\Services;

use App\Models\NotificationTemplate;
use App\Models\ServiceProvider;
use App\Models\User;

class NotificationService
{
    public function __construct(protected FcmService $fcm) {}

    /**
     * Send a notification for a given event to a user, respecting the global
     * NotificationTemplate defaults and — if the recipient is a service
     * provider — their personal per-event overrides stored on
     * service_providers.notification_preferences.
     *
     * Only the push channel actually sends anything right now (via FCM).
     * Email/SMS/WhatsApp toggles are honored at the data level (the template
     * and preferences both track them) but have no sending channel wired up
     * yet — that's real, additional work, not just a config flip.
     */
    public function notify(User $user, string $eventKey, string $title, string $body, array $data = []): void
    {
        $template = NotificationTemplate::where('event_key', $eventKey)->first();
        if (! $template) {
            return;
        }

        $pushEnabled = $template->push_enabled;

        $provider = $user->serviceProvider ?? null;
        if ($provider instanceof ServiceProvider) {
            $overrides = $provider->notification_preferences[$eventKey] ?? null;
            if ($overrides && array_key_exists('push', $overrides)) {
                $pushEnabled = (bool) $overrides['push'];
            }
        }

        if ($pushEnabled) {
            $this->fcm->sendToUser($user->id, $title, $body, ['event' => $eventKey, ...$data]);
        }
    }
}
