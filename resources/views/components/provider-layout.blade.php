@props(['title' => null, 'subtitle' => null])
@php $provider = auth()->user()->serviceProvider; @endphp
<x-dashboard-layout :nav-groups="\App\Support\DashboardNav::provider()" :title="$title ?? __('dashboard.nav_provider_dashboard')" :subtitle="$subtitle ?? __('dashboard.provider_console_subtitle')"
    :search-action="route('provider.properties.index')" :search-placeholder="__('dashboard.search_my_listings')">
    <x-slot:accountBadge>
        <div class="w-[30px] h-[30px] rounded-lg bg-brasssoft flex items-center justify-center font-serif text-[13px] text-brass font-semibold">
            {{ strtoupper(substr($provider->office_name ?? 'P', 0, 1)) }}
        </div>
        <div>
            <div class="text-[12.5px] text-white font-semibold">{{ $provider->office_name ?? __('dashboard.nav_office') }}</div>
            <div class="text-[10.5px] text-[#7C8695]">
                {{ $provider ? __('common.'.$provider->provider_type) : '' }}
                @if ($provider) · {{ __('status.'.$provider->verification_status) }} @endif
            </div>
        </div>
    </x-slot:accountBadge>
    {{ $slot }}
</x-dashboard-layout>
