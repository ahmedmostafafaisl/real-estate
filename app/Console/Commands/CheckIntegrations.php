<?php

namespace App\Console\Commands;

use App\Services\FcmService;
use Illuminate\Console\Command;
use Stripe\StripeClient;

class CheckIntegrations extends Command
{
    protected $signature = 'integrations:check';

    protected $description = 'Verify Firebase and Stripe credentials are present and actually reachable, not just configured.';

    public function handle(FcmService $fcm): int
    {
        $ok = true;

        $this->line('');
        $this->components->info('Firebase (push notifications)');
        if (! $fcm->isConfigured()) {
            $this->components->warn('Not configured — FIREBASE_CREDENTIALS is empty or the file doesn\'t exist.');
            $this->line('  See INTEGRATIONS.md section 3.');
            $ok = false;
        } else {
            $this->components->info('  Credentials file found and Firebase\'s SDK accepted it (no exception on init).');
            $this->line('  This confirms the JSON is valid and well-formed — it does not send a real push.');
            $this->line('  To fully verify, register a device token via POST /api/device-tokens from a real');
            $this->line('  device, then trigger any notification event (e.g. approve a pending property) and');
            $this->line('  check the device actually receives it.');
        }

        $this->line('');
        $this->components->info('Stripe (payments)');
        $secret = config('services.stripe.secret');
        if (! $secret) {
            $this->components->warn('Not configured — STRIPE_KEY/STRIPE_SECRET are empty.');
            $this->line('  See INTEGRATIONS.md section 4.');
            $ok = false;
        } else {
            try {
                // A real, live API call — confirms the secret key is valid and
                // Stripe is reachable, not just that an env variable is set.
                $client = new StripeClient($secret);
                $balance = $client->balance->retrieve();
                $mode = str_starts_with($secret, 'sk_live_') ? 'LIVE' : 'TEST';
                $this->components->info("  Key is valid — Stripe responded successfully. Mode: {$mode}.");
                $available = collect($balance->available)->map(fn ($b) => "{$b->amount} {$b->currency}")->implode(', ');
                $this->line("  Account balance: {$available}");

                if (! config('services.stripe.webhook_secret')) {
                    $this->components->warn('  STRIPE_WEBHOOK_SECRET is empty — checkout will redirect, but invoices');
                    $this->line('  will never actually be marked paid, since that only happens via the webhook.');
                    $ok = false;
                }
            } catch (\Throwable $e) {
                $this->components->error("  Stripe rejected the request: {$e->getMessage()}");
                $ok = false;
            }
        }

        $this->line('');

        return $ok ? self::SUCCESS : self::FAILURE;
    }
}
