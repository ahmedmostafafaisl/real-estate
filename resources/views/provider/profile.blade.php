<x-provider-layout title="Office profile">
    <x-panel title="Office profile">
        <form action="{{ route('provider.profile.update') }}" method="POST" class="flex gap-6">
            @csrf @method('PATCH')
            <div class="w-[84px] h-[84px] rounded-xl bg-brasssoft flex items-center justify-center flex-shrink-0">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#B8862E" stroke-width="2"><rect x="4" y="2" width="16" height="20" rx="1"/></svg>
            </div>
            <div class="flex-1 flex flex-col gap-3.5">
                <div class="grid grid-cols-2 gap-3.5">
                    <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">Office name</span><input name="office_name" value="{{ $provider->office_name }}" class="border border-line rounded-md px-2.5 py-2 text-sm"></label>
                    <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">Provider type</span>
                        <select name="provider_type" class="border border-line rounded-md px-2.5 py-2 text-sm">
                            @foreach (['agency','broker','owner','developer'] as $t)<option value="{{ $t }}" @selected($provider->provider_type === $t)>{{ ucfirst($t) }}</option>@endforeach
                        </select></label>
                </div>
                <div class="grid grid-cols-2 gap-3.5">
                    <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">City</span>
                        <select name="city_id" class="border border-line rounded-md px-2.5 py-2 text-sm">
                            @foreach ($cities as $city)<option value="{{ $city->id }}" @selected($provider->city_id == $city->id)>{{ $city->name }}</option>@endforeach
                        </select></label>
                    <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">Address</span><input name="address" value="{{ $provider->address }}" class="border border-line rounded-md px-2.5 py-2 text-sm"></label>
                </div>
                <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">Bio</span><textarea name="bio" rows="3" class="border border-line rounded-md px-2.5 py-2 text-sm">{{ $provider->bio }}</textarea></label>
                <div class="flex justify-end"><button class="bg-ink text-white rounded-md px-3.5 py-2 text-xs font-semibold">Save changes</button></div>
            </div>
        </form>
    </x-panel>
</x-provider-layout>
