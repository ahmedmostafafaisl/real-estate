<x-provider-layout :title="__('dashboard.nav_commissions')">
    <x-panel :title="__('dashboard.nav_commissions')">
        <table class="w-full text-sm">
            <thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2 px-2">{{ __('provider.property') }}</th><th class="pb-2 px-2">{{ __('provider.deal_type') }}</th><th class="pb-2 px-2 text-right">{{ __('provider.deal_value') }}</th><th class="pb-2 px-2 text-right">{{ __('provider.rate') }}</th><th class="pb-2 px-2 text-right">{{ __('provider.commission') }}</th><th class="pb-2 px-2">{{ __('common.status') }}</th></tr></thead>
            <tbody>
            @forelse ($commissions as $c)
                <tr class="border-t border-linesoft">
                    <td class="py-2.5 px-2">{{ $c->property->title }}</td>
                    <td class="py-2.5 px-2"><x-badge :status="ucfirst($c->deal_type)" /></td>
                    <td class="py-2.5 px-2 text-right">{{ __('common.currency') }} {{ number_format($c->deal_value) }}</td>
                    <td class="py-2.5 px-2 text-right">{{ $c->commission_rate }}%</td>
                    <td class="py-2.5 px-2 text-right font-mono">{{ __('common.currency') }} {{ number_format($c->commission_amount) }}</td>
                    <td class="py-2.5 px-2"><x-badge :status="ucfirst($c->status)" /></td>
                </tr>
            @empty
                <tr><td colspan="6" class="py-6 text-center text-textfaint">{{ __('provider.no_commissions_yet') }}</td></tr>
            @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $commissions->links() }}</div>
    </x-panel>
</x-provider-layout>
