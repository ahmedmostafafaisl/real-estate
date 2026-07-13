<x-provider-layout :title="__('provider.payments_and_invoices')">
    <x-panel :title="__('provider.payments_and_invoices')">
        <table class="w-full text-sm">
            <thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2 px-2">{{ __('provider.invoice') }}</th><th class="pb-2 px-2 text-right">{{ __('provider.amount') }}</th><th class="pb-2 px-2">{{ __('provider.due') }}</th><th class="pb-2 px-2">{{ __('common.status') }}</th><th class="pb-2 px-2"></th></tr></thead>
            <tbody>
            @forelse ($invoices as $inv)
                <tr class="border-t border-linesoft">
                    <td class="py-2.5 px-2 font-mono text-xs">{{ $inv->invoice_number }}</td>
                    <td class="py-2.5 px-2 text-right">{{ __('common.currency') }} {{ number_format($inv->total, 2) }}</td>
                    <td class="py-2.5 px-2">{{ $inv->due_at?->format('M j, Y') }}</td>
                    <td class="py-2.5 px-2"><x-badge :status="ucfirst($inv->status)" /></td>
                    <td class="py-2.5 px-2 text-right">
                        @if ($inv->status === 'unpaid')
                        <form action="{{ route('provider.invoices.pay', $inv) }}" method="POST" class="inline-flex gap-1.5">
                            @csrf
                            <select name="method" class="border border-line rounded-md text-xs px-1.5 py-1">
                                <option value="visa">Visa</option><option value="mastercard">Mastercard</option>
                                <option value="mada">Mada</option><option value="apple_pay">Apple Pay</option><option value="bank_transfer">{{ app()->getLocale() === 'ar' ? 'حوالة بنكية' : 'Bank transfer' }}</option>
                            </select>
                            <button class="bg-ink text-white rounded-md px-2.5 py-1 text-xs font-semibold">{{ __('provider.pay_now') }}</button>
                        </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="py-6 text-center text-textfaint">{{ __('provider.no_invoices_yet') }}</td></tr>
            @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $invoices->links() }}</div>
    </x-panel>
</x-provider-layout>
