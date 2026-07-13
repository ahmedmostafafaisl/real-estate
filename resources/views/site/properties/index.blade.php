<x-site-layout title="Search properties — Keystone">
    <div class="max-w-6xl mx-auto px-6 py-10">
        <h1 class="font-serif text-3xl mb-6">{{ $properties->total() }} properties found</h1>

        <form action="{{ route('properties.index') }}" method="GET" class="bg-white border border-line rounded-xl p-4 mb-8 grid grid-cols-2 md:grid-cols-6 gap-3">
            <input name="q" value="{{ request('q') }}" placeholder="Search title…" class="col-span-2 border border-line rounded-md px-3 py-2 text-sm">
            <select name="city_id" class="border border-line rounded-md px-3 py-2 text-sm">
                <option value="">Any city</option>
                @foreach ($cities as $c)<option value="{{ $c->id }}" @selected(request('city_id')==$c->id)>{{ $c->name }}</option>@endforeach
            </select>
            <select name="property_type_id" class="border border-line rounded-md px-3 py-2 text-sm">
                <option value="">Any type</option>
                @foreach ($types as $t)<option value="{{ $t->id }}" @selected(request('property_type_id')==$t->id)>{{ $t->name }}</option>@endforeach
            </select>
            <select name="listing_type" class="border border-line rounded-md px-3 py-2 text-sm">
                <option value="">Buy or rent</option>
                <option value="sale" @selected(request('listing_type')=='sale')>For sale</option>
                <option value="rent" @selected(request('listing_type')=='rent')>For rent</option>
            </select>
            <button class="bg-ink text-white rounded-md px-4 py-2 text-sm font-semibold">Search</button>
            <input name="min_price" value="{{ request('min_price') }}" type="number" placeholder="Min price" class="border border-line rounded-md px-3 py-2 text-sm">
            <input name="max_price" value="{{ request('max_price') }}" type="number" placeholder="Max price" class="border border-line rounded-md px-3 py-2 text-sm">
            <input name="bedrooms" value="{{ request('bedrooms') }}" type="number" placeholder="Min bedrooms" class="border border-line rounded-md px-3 py-2 text-sm">
            <select name="sort" class="border border-line rounded-md px-3 py-2 text-sm">
                <option value="">Newest first</option>
                <option value="price_asc" @selected(request('sort')=='price_asc')>Price: low to high</option>
                <option value="price_desc" @selected(request('sort')=='price_desc')>Price: high to low</option>
            </select>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @forelse ($properties as $p)
                <x-property-card :property="$p" />
            @empty
                <p class="text-textfaint col-span-3">No properties match your search.</p>
            @endforelse
        </div>
        <div class="mt-8">{{ $properties->links() }}</div>
    </div>
</x-site-layout>
