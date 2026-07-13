@props(['title' => 'Dashboard', 'subtitle' => 'Keystone Provider Console'])
@php $provider = auth()->user()->serviceProvider; @endphp
<x-dashboard-layout :nav-groups="\App\Support\DashboardNav::provider()" :title="$title" :subtitle="$subtitle"
    :search-action="route('provider.properties.index')" search-placeholder="Search my listings…">
    <x-slot:accountBadge>
        <div class="w-[30px] h-[30px] rounded-lg bg-brasssoft flex items-center justify-center font-serif text-[13px] text-brass font-semibold">
            {{ strtoupper(substr($provider->office_name ?? 'P', 0, 1)) }}
        </div>
        <div>
            <div class="text-[12.5px] text-white font-semibold">{{ $provider->office_name ?? 'Provider' }}</div>
            <div class="text-[10.5px] text-[#7C8695]">{{ ucfirst($provider->provider_type ?? '') }} · {{ ucfirst($provider->verification_status ?? '') }}</div>
        </div>
    </x-slot:accountBadge>
    {{ $slot }}
</x-dashboard-layout>
