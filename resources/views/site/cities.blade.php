<x-site-layout title="Cities — Keystone">
    <div class="max-w-6xl mx-auto px-6 py-10">
        <h1 class="font-serif text-3xl mb-6">Browse by city</h1>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($cities as $c)
                <x-tile-link :href="route('properties.index', ['city_id' => $c->id])" :label="$c->name" :sub="($c->region->name ?? '').' · '.$c->properties_count.' listings'" />
            @endforeach
        </div>
    </div>
</x-site-layout>
