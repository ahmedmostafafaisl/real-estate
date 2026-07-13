<x-admin-layout title="Cities & districts">
    <div class="flex flex-col gap-3.5">
        <x-panel title="Cities">
            <x-slot:action>
                <form action="{{ route('admin.geo.cities.store') }}" method="POST" class="flex gap-1.5">@csrf
                    <select name="region_id" class="border border-line rounded-md px-2 py-1.5 text-xs">
                        @foreach ($regions as $r)<option value="{{ $r->id }}">{{ $r->name }}</option>@endforeach
                    </select>
                    <input name="name" placeholder="New city" required class="border border-line rounded-md px-2.5 py-1.5 text-xs">
                    <button class="bg-ink text-white rounded-md px-3 py-1.5 text-xs font-semibold">Add</button>
                </form>
            </x-slot:action>
            <table class="w-full text-sm"><thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2">Region</th><th class="pb-2">City</th><th class="pb-2 text-right">Districts</th><th class="pb-2 text-right">Listings</th></tr></thead><tbody>
                @foreach ($cities as $c)
                    <tr class="border-t border-linesoft"><td class="py-2.5">{{ $c->region->name }}</td><td class="py-2.5">{{ $c->name }}</td><td class="py-2.5 text-right">{{ $c->districts_count }}</td><td class="py-2.5 text-right">{{ $c->properties_count }}</td></tr>
                @endforeach
            </tbody></table>
        </x-panel>
        <x-panel title="Add district">
            <form action="{{ route('admin.geo.districts.store') }}" method="POST" class="flex gap-1.5">@csrf
                <select name="city_id" class="border border-line rounded-md px-2 py-1.5 text-xs">
                    @foreach ($cities as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
                </select>
                <input name="name" placeholder="District name" required class="border border-line rounded-md px-2.5 py-1.5 text-xs">
                <button class="bg-ink text-white rounded-md px-3 py-1.5 text-xs font-semibold">Add district</button>
            </form>
        </x-panel>
    </div>
</x-admin-layout>
