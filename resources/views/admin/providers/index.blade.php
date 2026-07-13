<x-admin-layout title="Service providers">
    <x-panel title="Service providers">
        <div class="flex gap-1.5 mb-3.5">
            <x-pill-button :href="route('admin.providers.index')" :active="!request('status')">All</x-pill-button>
            @foreach (['pending','verified','rejected'] as $s)
                <x-pill-button :href="route('admin.providers.index', ['status' => $s])" :active="request('status') === $s">{{ ucfirst($s) }}</x-pill-button>
            @endforeach
        </div>
        <table class="w-full text-sm">
            <thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2 px-2">Office</th><th class="pb-2 px-2">Type</th><th class="pb-2 px-2">City</th><th class="pb-2 px-2 text-right">Listings</th><th class="pb-2 px-2">Verification</th><th class="pb-2 px-2"></th></tr></thead>
            <tbody>
            @forelse ($providers as $p)
                <tr class="border-t border-linesoft">
                    <td class="py-2.5 px-2">{{ $p->office_name }}</td>
                    <td class="py-2.5 px-2">{{ ucfirst($p->provider_type) }}</td>
                    <td class="py-2.5 px-2">{{ $p->city->name ?? '—' }}</td>
                    <td class="py-2.5 px-2 text-right">{{ $p->properties_count }}</td>
                    <td class="py-2.5 px-2"><x-badge :status="ucfirst($p->verification_status)" /></td>
                    <td class="py-2.5 px-2 text-right whitespace-nowrap">
                        @if ($p->verification_status === 'pending')
                        <form action="{{ route('admin.providers.verify', $p) }}" method="POST" class="inline">@csrf<button class="text-ksuccess text-xs font-semibold mr-2">Verify</button></form>
                        <form action="{{ route('admin.providers.reject', $p) }}" method="POST" class="inline">@csrf<button class="text-kdanger text-xs font-semibold">Reject</button></form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="py-6 text-center text-textfaint">No providers yet.</td></tr>
            @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $providers->links() }}</div>
    </x-panel>
</x-admin-layout>
