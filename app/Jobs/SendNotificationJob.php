<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public function __construct(
        protected int $userId,
        protected string $eventKey,
        protected string $title,
        protected string $body,
        protected array $data = [],
    ) {}

    public function handle(NotificationService $notifications): void
    {
        $user = User::find($this->userId);
        if (! $user) {
            return;
        }

        $notifications->notify($user, $this->eventKey, $this->title, $this->body, $this->data);
    }
}
