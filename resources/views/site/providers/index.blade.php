<x-site-layout :title="__('site.verified_providers')">
    <div class="max-w-6xl mx-auto px-6 py-10">
        <h1 class="font-serif text-3xl mb-6">{{ __('site.verified_providers') }}</h1>
        <form action="{{ route('providers.index') }}" method="GET" class="flex gap-2 mb-6">
            <select name="city_id" class="border border-line rounded-md px-3 py-2 text-sm">
                <option value="">{{ __('site.any_city') }}</option>
                @foreach ($cities as $c)<option value="{{ $c->id }}" @selected(request('city_id')==$c->id)>{{ $c->name }}</option>@endforeach
            </select>
            <select name="provider_type" class="border border-line rounded-md px-3 py-2 text-sm">
                <option value="">{{ __('site.any_type') }}</option>
                @foreach (['agency','broker','owner','developer'] as $t)<option value="{{ $t }}" @selected(request('provider_type')==$t)>{{ __('common.'.$t) }}</option>@endforeach
            </select>
            <button class="bg-ink text-white rounded-md px-4 py-2 text-sm font-semibold">{{ __('site.filter_action') }}</button>
        </form>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @forelse ($providers as $p)
                <a href="{{ route('providers.show', $p) }}" class="bg-white border border-line rounded-xl p-5 hover:border-brass">
                    <div class="w-11 h-11 rounded-lg bg-brasssoft flex items-center justify-center font-serif text-brass mb-3">{{ strtoupper(substr($p->office_name,0,1)) }}</div>
                    <div class="font-serif text-lg">{{ $p->office_name }}</div>
                    <div class="text-xs text-textfaint mt-1">{{ __('common.'.$p->provider_type) }} · {{ $p->city->name ?? '' }}</div>
                    <div class="text-xs text-textmute mt-2">{{ $p->properties_count }} {{ __('site.active_listings') }}</div>
                </a>
            @empty
                <p class="text-textfaint col-span-3">{{ __('site.no_verified_providers') }}</p>
            @endforelse
        </div>
        <div class="mt-8">{{ $providers->links() }}</div>
    </div>
</x-site-layout>
