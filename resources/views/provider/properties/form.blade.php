<x-provider-layout :title="$property->exists ? 'Edit listing' : 'New listing'">
    <x-panel :title="$property->exists ? 'Edit listing' : 'New listing'">
        <form action="{{ $property->exists ? route('provider.properties.update', $property) : route('provider.properties.store') }}" method="POST" class="flex flex-col gap-3.5">
            @csrf
            @if ($property->exists) @method('PUT') @endif

            <div class="grid grid-cols-2 gap-3.5">
                <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">Title</span>
                    <input name="title" value="{{ old('title', $property->title) }}" required class="border border-line rounded-md px-2.5 py-2 text-sm" placeholder="e.g. Modern 3BR apartment in Al Olaya"></label>
                <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">Listing type</span>
                    <select name="listing_type" @if($property->exists) disabled @endif class="border border-line rounded-md px-2.5 py-2 text-sm">
                        <option value="sale" @selected(old('listing_type', $property->listing_type) === 'sale')>For sale</option>
                        <option value="rent" @selected(old('listing_type', $property->listing_type) === 'rent')>For rent</option>
                    </select></label>
            </div>

            @unless ($property->exists)
            <div class="grid grid-cols-3 gap-3.5">
                <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">Category</span>
                    <select name="property_category_id" required class="border border-line rounded-md px-2.5 py-2 text-sm">
                        @foreach ($categories as $cat)<option value="{{ $cat->id }}">{{ $cat->name }}</option>@endforeach
                    </select></label>
                <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">Type</span>
                    <select name="property_type_id" required class="border border-line rounded-md px-2.5 py-2 text-sm">
                        @foreach ($categories->flatMap->types as $type)<option value="{{ $type->id }}">{{ $type->name }}</option>@endforeach
                    </select></label>
                <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">City</span>
                    <select name="city_id" required class="border border-line rounded-md px-2.5 py-2 text-sm">
                        @foreach ($cities as $city)<option value="{{ $city->id }}" @selected(old('city_id', $property->city_id) == $city->id)>{{ $city->name }}</option>@endforeach
                    </select></label>
            </div>
            @else
            <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">City</span>
                <select name="city_id" required class="border border-line rounded-md px-2.5 py-2 text-sm">
                    @foreach ($cities as $city)<option value="{{ $city->id }}" @selected($property->city_id == $city->id)>{{ $city->name }}</option>@endforeach
                </select></label>
            @endunless

            <div class="grid grid-cols-4 gap-3.5">
                <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">Price (SAR)</span><input type="number" name="price" value="{{ old('price', $property->price) }}" required class="border border-line rounded-md px-2.5 py-2 text-sm"></label>
                <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">Area (sqm)</span><input type="number" name="area_sqm" value="{{ old('area_sqm', $property->area_sqm) }}" class="border border-line rounded-md px-2.5 py-2 text-sm"></label>
                <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">Bedrooms</span><input type="number" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" class="border border-line rounded-md px-2.5 py-2 text-sm"></label>
                <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">Bathrooms</span><input type="number" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" class="border border-line rounded-md px-2.5 py-2 text-sm"></label>
            </div>

            <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">Description</span>
                <textarea name="description" rows="4" class="border border-line rounded-md px-2.5 py-2 text-sm">{{ old('description', $property->description) }}</textarea></label>

            <div>
                <span class="text-xs font-semibold text-textmute block mb-2">Features</span>
                <div class="flex flex-wrap gap-2">
                    @php $selected = $property->exists ? $property->features->pluck('id')->toArray() : []; @endphp
                    @foreach ($features as $f)
                        <label class="flex items-center gap-1.5 text-[12.5px] text-textmute border border-line rounded-full px-3 py-1.5">
                            <input type="checkbox" name="features[]" value="{{ $f->id }}" @checked(in_array($f->id, $selected))> {{ $f->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end gap-2 pt-1">
                <a href="{{ route('provider.properties.index') }}" class="border border-line rounded-md px-3.5 py-2 text-xs font-semibold text-textmute">Cancel</a>
                @unless ($property->exists)
                    <button type="submit" name="submit_for_review" value="0" class="border border-line rounded-md px-3.5 py-2 text-xs font-semibold text-textmute">Save as draft</button>
                    <button type="submit" name="submit_for_review" value="1" class="bg-ink text-white rounded-md px-3.5 py-2 text-xs font-semibold">Save and submit for review</button>
                @else
                    <button type="submit" class="bg-ink text-white rounded-md px-3.5 py-2 text-xs font-semibold">Save changes</button>
                @endunless
            </div>
        </form>
    </x-panel>
</x-provider-layout>
