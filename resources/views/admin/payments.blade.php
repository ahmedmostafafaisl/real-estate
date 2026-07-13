<x-admin-layout title="Payments & invoices">
    <x-panel title="Invoices">
        <div class="flex gap-1.5 mb-3.5">
            <x-pill-button :href="route('admin.payments')" :active="!request('status')">All</x-pill-button>
            @foreach (['unpaid','paid','void','refunded'] as $s)
                <x-pill-button :href="route('admin.payments', ['status' => $s])" :active="request('status') === $s">{{ ucfirst($s) }}</x-pill-button>
            @endforeach
        </div>
        <table class="w-full text-sm">
            <thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2 px-2">Invoice</th><th class="pb-2 px-2">Provider</th><th class="pb-2 px-2 text-right">Total</th><th class="pb-2 px-2">Status</th><th class="pb-2 px-2"></th></tr></thead>
            <tbody>
            @forelse ($invoices as $inv)
                <tr class="border-t border-linesoft">
                    <td class="py-2.5 px-2 font-mono text-xs">{{ $inv->invoice_number }}</td>
                    <td class="py-2.5 px-2">{{ $inv->serviceProvider->office_name }}</td>
                    <td class="py-2.5 px-2 text-right">SAR {{ number_format($inv->total, 2) }}</td>
                    <td class="py-2.5 px-2"><x-badge :status="ucfirst($inv->status)" /></td>
                    <td class="py-2.5 px-2 text-right">
                        @foreach ($inv->payments as $pay)
                            @if ($pay->status === 'paid')
                            <form action="{{ route('admin.payments.refund', $pay) }}" method="POST" onsubmit="return confirm('Refund this payment?')">@csrf<button class="text-kdanger text-xs font-semibold">Refund</button></form>
                            @endif
                        @endforeach
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="py-6 text-center text-textfaint">No invoices yet.</td></tr>
            @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $invoices->links() }}</div>
    </x-panel>
</x-admin-layout>
