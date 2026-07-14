<?php

namespace App\Console\Commands;

use App\Jobs\SendNotificationJob;
use App\Models\Subscription;
use Illuminate\Console\Command;

class CheckExpiringSubscriptions extends Command
{
    protected $signature = 'subscriptions:check';

    protected $description = 'Notify providers whose subscription ends within 3 days, and expire the ones already past due.';

    public function handle(): int
    {
        // Already past due — flip to expired.
        $expired = Subscription::where('status', 'active')
            ->where('ends_at', '<=', now())
            ->with('serviceProvider.user')
            ->get();

        foreach ($expired as $subscription) {
            $subscription->update(['status' => 'expired']);
            $this->notifyOwner($subscription, 'subscription.expiring',
                'Subscription expired',
                'Your subscription has expired — renew to keep your listings visible.');
        }

        // Ending within the next 3 days — reminder only, still active.
        $ending = Subscription::where('status', 'active')
            ->whereBetween('ends_at', [now(), now()->addDays(3)])
            ->with('serviceProvider.user')
            ->get();

        foreach ($ending as $subscription) {
            $daysLeft = now()->diffInDays($subscription->ends_at, false);
            $this->notifyOwner($subscription, 'subscription.expiring',
                'Subscription expiring soon',
                "Your subscription ends in {$daysLeft} day(s) — renew to avoid interruption.");
        }

        $this->info("Expired {$expired->count()}, reminded {$ending->count()}.");

        return self::SUCCESS;
    }

    protected function notifyOwner(Subscription $subscription, string $eventKey, string $title, string $body): void
    {
        $user = $subscription->serviceProvider->user ?? null;
        if (! $user) {
            return;
        }

        SendNotificationJob::dispatch($user->id, $eventKey, $title, $body, ['subscription_id' => $subscription->id]);
    }
}
