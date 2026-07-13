<x-site-layout title="Service providers — Keystone">
    <div class="max-w-6xl mx-auto px-6 py-10">
        <h1 class="font-serif text-3xl mb-6">Verified service providers</h1>
        <form action="{{ route('providers.index') }}" method="GET" class="flex gap-2 mb-6">
            <select name="city_id" class="border border-line rounded-md px-3 py-2 text-sm">
                <option value="">Any city</option>
                @foreach ($cities as $c)<option value="{{ $c->id }}" @selected(request('city_id')==$c->id)>{{ $c->name }}</option>@endforeach
            </select>
            <select name="provider_type" class="border border-line rounded-md px-3 py-2 text-sm">
                <option value="">Any type</option>
                @foreach (['agency','broker','owner','developer'] as $t)<option value="{{ $t }}" @selected(request('provider_type')==$t)>{{ ucfirst($t) }}</option>@endforeach
            </select>
            <button class="bg-ink text-white rounded-md px-4 py-2 text-sm font-semibold">Filter</button>
        </form>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @forelse ($providers as $p)
                <a href="{{ route('providers.show', $p) }}" class="bg-white border border-line rounded-xl p-5 hover:border-brass">
                    <div class="w-11 h-11 rounded-lg bg-brasssoft flex items-center justify-center font-serif text-brass mb-3">{{ strtoupper(substr($p->office_name,0,1)) }}</div>
                    <div class="font-serif text-lg">{{ $p->office_name }}</div>
                    <div class="text-xs text-textfaint mt-1">{{ ucfirst($p->provider_type) }} · {{ $p->city->name ?? '' }}</div>
                    <div class="text-xs text-textmute mt-2">{{ $p->properties_count }} active listings</div>
                </a>
            @empty
                <p class="text-textfaint col-span-3">No verified providers yet.</p>
            @endforelse
        </div>
        <div class="mt-8">{{ $providers->links() }}</div>
    </div>
</x-site-layout>
