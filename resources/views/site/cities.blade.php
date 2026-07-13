<x-site-layout :title="__('site.browse_by_city')">
    <div class="max-w-6xl mx-auto px-6 py-10">
        <h1 class="font-serif text-3xl mb-6">{{ __('site.browse_by_city') }}</h1>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($cities as $c)
                <x-tile-link :href="route('properties.index', ['city_id' => $c->id])" :label="$c->name" :sub="($c->region->name ?? '').' · '.__('site.listings_count', ['count' => $c->properties_count])" />
            @endforeach
        </div>
    </div>
</x-site-layout>
