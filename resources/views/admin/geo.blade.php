<x-admin-layout :title="__('admin.cities_districts_title')">
    <div class="flex flex-col gap-3.5">
        <x-panel :title="__('admin.cities')">
            <x-slot:action>
                <form action="{{ route('admin.geo.cities.store') }}" method="POST" class="flex gap-1.5">@csrf
                    <select name="region_id" class="border border-line rounded-md px-2 py-1.5 text-xs">
                        @foreach ($regions as $r)<option value="{{ $r->id }}">{{ $r->name }}</option>@endforeach
                    </select>
                    <input name="name" placeholder="{{ __('admin.new_city') }}" required class="border border-line rounded-md px-2.5 py-1.5 text-xs">
                    <button class="bg-ink text-white rounded-md px-3 py-1.5 text-xs font-semibold">{{ __('admin.add') }}</button>
                </form>
            </x-slot:action>
            <table class="w-full text-sm"><thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2">{{ __('admin.region_col') }}</th><th class="pb-2">{{ __('admin.city_col') }}</th><th class="pb-2 text-right">{{ __('admin.districts_col') }}</th><th class="pb-2 text-right">{{ __('admin.listings') }}</th></tr></thead><tbody>
                @foreach ($cities as $c)
                    <tr class="border-t border-linesoft"><td class="py-2.5">{{ $c->region->name }}</td><td class="py-2.5">{{ $c->name }}</td><td class="py-2.5 text-right">{{ $c->districts_count }}</td><td class="py-2.5 text-right">{{ $c->properties_count }}</td></tr>
                @endforeach
            </tbody></table>
        </x-panel>
        <x-panel :title="__('admin.add_district')">
            <form action="{{ route('admin.geo.districts.store') }}" method="POST" class="flex gap-1.5">@csrf
                <select name="city_id" class="border border-line rounded-md px-2 py-1.5 text-xs">
                    @foreach ($cities as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
                </select>
                <input name="name" placeholder="{{ __('admin.district_name') }}" required class="border border-line rounded-md px-2.5 py-1.5 text-xs">
                <button class="bg-ink text-white rounded-md px-3 py-1.5 text-xs font-semibold">{{ __('admin.add_district') }}</button>
            </form>
        </x-panel>
    </div>
</x-admin-layout>
