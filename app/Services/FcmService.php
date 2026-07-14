<?php

namespace App\Services;

use App\Models\DeviceToken;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FirebaseNotification;

class FcmService
{
    protected ?Messaging $messaging = null;

    public function __construct()
    {
        $credentialsPath = config('services.firebase.credentials');

        // Deliberately soft-fail rather than throw: a missing Firebase project
        // shouldn't break the feature that triggered the notification (e.g. a
        // provider approving a property shouldn't 500 just because push isn't
        // configured yet). send() below logs and returns instead.
        if ($credentialsPath && file_exists($credentialsPath)) {
            $this->messaging = (new Factory)->withServiceAccount($credentialsPath)->createMessaging();
        }
    }

    public function isConfigured(): bool
    {
        return $this->messaging !== null;
    }

    /**
     * Send a push notification to every device registered to a user.
     * Returns the number of tokens successfully sent to.
     */
    public function sendToUser(int $userId, string $title, string $body, array $data = []): int
    {
        if (! $this->isConfigured()) {
            Log::info("FCM not configured — would have sent \"{$title}\" to user #{$userId}.");

            return 0;
        }

        $tokens = DeviceToken::where('user_id', $userId)->pluck('token');
        if ($tokens->isEmpty()) {
            return 0;
        }

        $sent = 0;
        foreach ($tokens as $token) {
            try {
                $message = CloudMessage::withTarget('token', $token)
                    ->withNotification(FirebaseNotification::create($title, $body))
                    ->withData($data);

                $this->messaging->send($message);
                $sent++;
            } catch (\Throwable $e) {
                // A single dead token shouldn't stop the rest of the batch.
                Log::warning('FCM send failed for token ending in ...'.substr($token, -6).': '.$e->getMessage());
            }
        }

        return $sent;
    }
}
