<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Property;

trait HandlesPropertyPhotos
{
    // Shared by every store()/update() that accepts property photos — saves
    // uploaded files to the public disk and creates the matching
    // property_images rows, continuing the sort order and making the very
    // first photo on a brand-new listing the featured one.
    //
    // This was previously copy-pasted identically into both
    // Http\Controllers\Web\Provider\PropertyController and
    // Http\Controllers\Api\PropertyController — a change to one silently
    // wouldn't have applied to the other.
    protected function storeUploadedPhotos(Property $property, array $files): void
    {
        if (empty($files)) {
            return;
        }

        $nextOrder = (int) $property->images()->max('sort_order');
        $hasFeatured = $property->images()->where('is_featured', true)->exists();

        foreach ($files as $i => $file) {
            $path = $file->store("properties/{$property->id}", 'public');

            $property->images()->create([
                'path' => $path,
                'type' => 'image',
                'sort_order' => ++$nextOrder,
                'is_featured' => ! $hasFeatured && $i === 0,
            ]);
        }
    }
}
