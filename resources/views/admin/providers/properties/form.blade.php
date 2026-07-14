<x-provider-layout :title="$property->exists ? __('provider.edit_listing') : __('provider.new_listing')">
    <x-panel :title="$property->exists ? __('provider.edit_listing') : __('provider.new_listing')">
        <form action="{{ $property->exists ? route('provider.properties.update', $property) : route('provider.properties.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-3.5">
            @csrf
            @if ($property->exists) @method('PUT') @endif

            <div class="grid grid-cols-2 gap-3.5">
                <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">{{ __('provider.title_label') }}</span>
                    <input name="title" value="{{ old('title', $property->title) }}" required class="border border-line rounded-md px-2.5 py-2 text-sm" placeholder="{{ __('provider.title_placeholder') }}"></label>
                <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">{{ __('provider.listing_type') }}</span>
                    <select name="listing_type" @if($property->exists) disabled @endif class="border border-line rounded-md px-2.5 py-2 text-sm">
                        <option value="sale" @selected(old('listing_type', $property->listing_type) === 'sale')>{{ __('common.for_sale') }}</option>
                        <option value="rent" @selected(old('listing_type', $property->listing_type) === 'rent')>{{ __('common.for_rent') }}</option>
                    </select></label>
            </div>

            @unless ($property->exists)
            <div class="grid grid-cols-3 gap-3.5">
                <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">{{ __('common.category') }}</span>
                    <select name="property_category_id" required class="border border-line rounded-md px-2.5 py-2 text-sm">
                        @foreach ($categories as $cat)<option value="{{ $cat->id }}">{{ $cat->name }}</option>@endforeach
                    </select></label>
                <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">{{ __('common.type') }}</span>
                    <select name="property_type_id" required class="border border-line rounded-md px-2.5 py-2 text-sm">
                        @foreach ($categories->flatMap->types as $type)<option value="{{ $type->id }}">{{ $type->name }}</option>@endforeach
                    </select></label>
                <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">{{ __('common.city') }}</span>
                    <select name="city_id" required class="border border-line rounded-md px-2.5 py-2 text-sm">
                        @foreach ($cities as $city)<option value="{{ $city->id }}" @selected(old('city_id', $property->city_id) == $city->id)>{{ $city->name }}</option>@endforeach
                    </select></label>
            </div>
            @else
            <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">{{ __('common.city') }}</span>
                <select name="city_id" required class="border border-line rounded-md px-2.5 py-2 text-sm">
                    @foreach ($cities as $city)<option value="{{ $city->id }}" @selected($property->city_id == $city->id)>{{ $city->name }}</option>@endforeach
                </select></label>
            @endunless

            <div class="grid grid-cols-4 gap-3.5">
                <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">{{ __('common.price') }} ({{ __('common.currency') }})</span><input type="number" name="price" value="{{ old('price', $property->price) }}" required class="border border-line rounded-md px-2.5 py-2 text-sm"></label>
                <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">{{ __('provider.area_sqm') }}</span><input type="number" name="area_sqm" value="{{ old('area_sqm', $property->area_sqm) }}" class="border border-line rounded-md px-2.5 py-2 text-sm"></label>
                <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">{{ __('provider.bedrooms') }}</span><input type="number" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" class="border border-line rounded-md px-2.5 py-2 text-sm"></label>
                <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">{{ __('provider.bathrooms') }}</span><input type="number" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" class="border border-line rounded-md px-2.5 py-2 text-sm"></label>
            </div>

            <div class="grid grid-cols-2 gap-3.5">
                <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">{{ __('provider.latitude') }}</span><input type="number" step="any" name="latitude" value="{{ old('latitude', $property->latitude) }}" placeholder="24.7136" class="border border-line rounded-md px-2.5 py-2 text-sm"></label>
                <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">{{ __('provider.longitude') }}</span><input type="number" step="any" name="longitude" value="{{ old('longitude', $property->longitude) }}" placeholder="46.6753" class="border border-line rounded-md px-2.5 py-2 text-sm"></label>
            </div>
            <p class="text-[11px] text-textfaint -mt-2">{{ __('provider.location_hint') }} <a href="https://www.google.com/maps" target="_blank" rel="noopener" class="text-brass font-semibold">{{ __('provider.open_maps_link') }}</a></p>

            <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">{{ __('common.description') }}</span>
                <textarea name="description" rows="4" class="border border-line rounded-md px-2.5 py-2 text-sm">{{ old('description', $property->description) }}</textarea></label>

            <div>
                <span class="text-xs font-semibold text-textmute block mb-2">{{ __('provider.photos') }}</span>

                @if ($property->exists && $property->images->count())
                    <div class="mb-2 text-[11px] font-semibold text-textfaint uppercase">{{ __('provider.existing_photos') }}</div>
                    <div class="grid grid-cols-4 gap-3 mb-3.5">
                        @foreach ($property->images as $image)
                            <div class="relative border border-line rounded-lg overflow-hidden">
                                <img src="{{ asset('storage/' . $image->path) }}" alt="" class="w-full h-24 object-cover">
                                @if ($image->is_featured)
                                    <span class="absolute top-1.5 start-1.5 bg-brass text-white text-[10px] font-semibold px-2 py-0.5 rounded-full">{{ __('provider.featured_photo') }}</span>
                                @endif
                                <div class="absolute inset-x-0 bottom-0 bg-black/55 p-1.5 flex items-center justify-between gap-1">
                                    @unless ($image->is_featured)
                                        <label class="text-[10px] text-white font-semibold flex items-center gap-1 cursor-pointer">
                                            <input type="radio" name="featured_image_id" value="{{ $image->id }}" class="scale-90">
                                            {{ __('provider.make_featured') }}
                                        </label>
                                    @else
                                        <span></span>
                                    @endif
                                    <label class="text-[10px] text-white font-semibold flex items-center gap-1 cursor-pointer">
                                        <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" class="scale-90 accent-kdanger">
                                        {{ __('provider.remove_photo') }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @elseif ($property->exists)
                    <p class="text-xs text-textfaint mb-3">{{ __('provider.no_photos_yet') }}</p>
                @endif

                <label class="flex flex-col gap-1.5">
                    <span class="text-[11px] font-semibold text-textfaint uppercase">{{ __('provider.add_photos') }}</span>
                    <input type="file" name="photos[]" multiple accept="image/*" class="border border-line rounded-md px-2.5 py-2 text-sm file:me-3 file:py-1 file:px-3 file:rounded-full file:border-0 file:bg-canvas file:text-xs file:font-semibold">
                    <span class="text-[11px] text-textfaint">{{ __('provider.add_photos_hint') }}</span>
                </label>
            </div>

            <div>
                <span class="text-xs font-semibold text-textmute block mb-2">{{ __('common.features') }}</span>
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
                <a href="{{ route('provider.properties.index') }}" class="border border-line rounded-md px-3.5 py-2 text-xs font-semibold text-textmute">{{ __('common.cancel') }}</a>
                @unless ($property->exists)
                    <button type="submit" name="submit_for_review" value="0" class="border border-line rounded-md px-3.5 py-2 text-xs font-semibold text-textmute">{{ __('provider.save_as_draft') }}</button>
                    <button type="submit" name="submit_for_review" value="1" class="bg-ink text-white rounded-md px-3.5 py-2 text-xs font-semibold">{{ __('provider.save_and_submit') }}</button>
                @else
                    <button type="submit" class="bg-ink text-white rounded-md px-3.5 py-2 text-xs font-semibold">{{ __('common.save_changes') }}</button>
                @endunless
            </div>
        </form>
    </x-panel>
</x-provider-layout>
