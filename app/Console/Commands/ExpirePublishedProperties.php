<?php

namespace App\Console\Commands;

use App\Jobs\SendNotificationJob;
use App\Models\Property;
use Illuminate\Console\Command;

class ExpirePublishedProperties extends Command
{
    protected $signature = 'properties:expire';

    protected $description = 'Mark published properties past their expiry date as expired, and notify the owning provider.';

    public function handle(): int
    {
        $properties = Property::where('status', 'published')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', now())
            ->with('serviceProvider.user')
            ->get();

        foreach ($properties as $property) {
            $property->update(['status' => 'expired']);

            $ownerUser = $property->serviceProvider->user ?? null;
            if ($ownerUser) {
                SendNotificationJob::dispatch(
                    $ownerUser->id,
                    'property.expired',
                    'Listing expired',
                    "\"{$property->title}\" has expired and is no longer visible in search results.",
                    ['property_id' => $property->id],
                );
            }
        }

        $this->info("Expired {$properties->count()} propert".($properties->count() === 1 ? 'y' : 'ies').'.');

        return self::SUCCESS;
    }
}
