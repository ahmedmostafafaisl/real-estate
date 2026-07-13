<x-admin-layout title="Commissions">
    <x-panel title="Commissions">
        <div class="flex gap-1.5 mb-3.5">
            <x-pill-button :href="route('admin.commissions')" :active="!request('status')">All</x-pill-button>
            @foreach (['pending','paid'] as $s)
                <x-pill-button :href="route('admin.commissions', ['status' => $s])" :active="request('status') === $s">{{ ucfirst($s) }}</x-pill-button>
            @endforeach
        </div>
        <table class="w-full text-sm">
            <thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2 px-2">Property</th><th class="pb-2 px-2">Provider</th><th class="pb-2 px-2 text-right">Commission</th><th class="pb-2 px-2">Status</th><th class="pb-2 px-2"></th></tr></thead>
            <tbody>
            @forelse ($commissions as $c)
                <tr class="border-t border-linesoft">
                    <td class="py-2.5 px-2">{{ $c->property->title }}</td>
                    <td class="py-2.5 px-2">{{ $c->serviceProvider->office_name }}</td>
                    <td class="py-2.5 px-2 text-right font-mono">SAR {{ number_format($c->commission_amount) }}</td>
                    <td class="py-2.5 px-2"><x-badge :status="ucfirst($c->status)" /></td>
                    <td class="py-2.5 px-2 text-right">
                        @if ($c->status === 'pending')
                        <form action="{{ route('admin.commissions.mark-paid', $c) }}" method="POST">@csrf<button class="text-ksuccess text-xs font-semibold">Mark paid</button></form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="py-6 text-center text-textfaint">No commissions recorded yet.</td></tr>
            @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $commissions->links() }}</div>
    </x-panel>
</x-admin-layout>
