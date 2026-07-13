<x-site-layout :title="$serviceProvider->office_name">
    <div class="max-w-6xl mx-auto px-6 py-10">
        <div class="flex items-center gap-4 mb-8">
            <div class="w-16 h-16 rounded-xl bg-brasssoft flex items-center justify-center font-serif text-2xl text-brass">{{ strtoupper(substr($serviceProvider->office_name,0,1)) }}</div>
            <div>
                <h1 class="font-serif text-2xl">{{ $serviceProvider->office_name }}</h1>
                <div class="text-sm text-textmute mt-1">{{ __('common.'.$serviceProvider->provider_type) }} · {{ $serviceProvider->city->name ?? '' }} · {{ __('common.verified') }}</div>
            </div>
        </div>
        @if ($serviceProvider->bio)<p class="text-textmute leading-relaxed mb-8 max-w-2xl">{{ $serviceProvider->bio }}</p>@endif

        <h2 class="font-serif text-xl mb-4">{{ ucfirst(__('site.active_listings')) }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @forelse ($properties as $p)
                <x-property-card :property="$p" />
            @empty
                <p class="text-textfaint col-span-3">{{ __('site.no_active_listings') }}</p>
            @endforelse
        </div>
        <div class="mt-8">{{ $properties->links() }}</div>
    </div>
</x-site-layout>
