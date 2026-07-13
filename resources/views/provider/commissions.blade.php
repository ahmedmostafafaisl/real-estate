<x-provider-layout title="Commissions">
    <x-panel title="Commissions">
        <table class="w-full text-sm">
            <thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2 px-2">Property</th><th class="pb-2 px-2">Deal type</th><th class="pb-2 px-2 text-right">Deal value</th><th class="pb-2 px-2 text-right">Rate</th><th class="pb-2 px-2 text-right">Commission</th><th class="pb-2 px-2">Status</th></tr></thead>
            <tbody>
            @forelse ($commissions as $c)
                <tr class="border-t border-linesoft">
                    <td class="py-2.5 px-2">{{ $c->property->title }}</td>
                    <td class="py-2.5 px-2"><x-badge :status="ucfirst($c->deal_type)" /></td>
                    <td class="py-2.5 px-2 text-right">SAR {{ number_format($c->deal_value) }}</td>
                    <td class="py-2.5 px-2 text-right">{{ $c->commission_rate }}%</td>
                    <td class="py-2.5 px-2 text-right font-mono">SAR {{ number_format($c->commission_amount) }}</td>
                    <td class="py-2.5 px-2"><x-badge :status="ucfirst($c->status)" /></td>
                </tr>
            @empty
                <tr><td colspan="6" class="py-6 text-center text-textfaint">No commissions recorded yet.</td></tr>
            @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $commissions->links() }}</div>
    </x-panel>
</x-provider-layout>
