<?php

namespace Database\Seeders;

use App\Models\Commission;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Property;
use App\Models\ServiceProvider;
use App\Models\Subscription;
use Illuminate\Database\Seeder;

class BillingSeeder extends Seeder
{
    public function run(): void
    {
        ServiceProvider::all()->each(function (ServiceProvider $provider) {
            $subCount = random_int(1, 3);

            $subscriptions = Subscription::factory()
                ->count($subCount)
                ->for($provider, 'serviceProvider')
                ->create();

            // Make the most recent subscription active so the provider dashboards have live data.
            $latest = $subscriptions->sortByDesc('starts_at')->first();
            $latest?->update([
                'status' => 'active',
                'starts_at' => now()->subDays(random_int(1, 25)),
                'ends_at' => now()->addDays(random_int(3, 30)),
            ]);

            foreach ($subscriptions as $subscription) {
                $invoice = Invoice::factory()
                    ->for($provider, 'serviceProvider')
                    ->for($subscription, 'subscription')
                    ->create([
                        'subtotal' => $subscription->package->price ?? 399,
                        'tax_amount' => round(($subscription->package->price ?? 399) * 0.15, 2),
                        'total' => round(($subscription->package->price ?? 399) * 1.15, 2),
                    ]);

                if ($invoice->status !== 'unpaid') {
                    Payment::factory()->for($invoice)->create([
                        'amount' => $invoice->total,
                        'status' => $invoice->status === 'refunded' ? 'refunded' : 'paid',
                    ]);
                }
            }
        });

        // Commissions only for properties actually marked sold/rented — tied to the real property + provider.
        Property::whereIn('status', ['sold', 'rented'])->get()->each(function (Property $property) {
            $rate = $property->serviceProvider->commission_rate ?? 2.0;

            Commission::factory()->create([
                'property_id' => $property->id,
                'service_provider_id' => $property->service_provider_id,
                'deal_type' => $property->status,
                'deal_value' => $property->price,
                'commission_rate' => $rate,
                'commission_amount' => round($property->price * $rate / 100, 2),
            ]);
        });
    }
}
