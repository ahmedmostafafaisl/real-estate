@props(['title' => 'Dashboard', 'subtitle' => 'Keystone Admin Console'])
<x-dashboard-layout :nav-groups="\App\Support\DashboardNav::admin()" :title="$title" :subtitle="$subtitle"
    :search-action="route('admin.properties.index')" search-placeholder="Search platform…">
    <x-slot:accountBadge>
        <div class="w-[30px] h-[30px] rounded-lg bg-brasssoft flex items-center justify-center font-serif text-[13px] text-brass font-semibold">A</div>
        <div>
            <div class="text-[12.5px] text-white font-semibold">{{ auth()->user()->name }}</div>
            <div class="text-[10.5px] text-[#7C8695]">Administrator</div>
        </div>
    </x-slot:accountBadge>
    {{ $slot }}
</x-dashboard-layout>
