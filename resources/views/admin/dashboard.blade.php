<x-admin-layout :title="__('admin.dashboard_title')">
    <div class="flex flex-col gap-4">
        <div class="grid grid-cols-4 gap-3.5">
            <x-stat-card :label="__('admin.total_customers')" :value="number_format($stats['total_users'])" accent="#1D6F64" icon='<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>' />
            <x-stat-card :label="__('admin.verified_providers')" :value="$stats['total_providers']" :sub="__('admin.pending_approval_suffix', ['count' => $stats['pending_providers']])" accent="#B8862E" icon='<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>' />
            <x-stat-card :label="__('admin.published_properties')" :value="number_format($stats['published_properties'])" accent="#2E8B57" icon='<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="2" width="16" height="20" rx="1"/></svg>' />
            <x-stat-card :label="__('admin.total_revenue')" :value="__('common.currency').' '.number_format($stats['total_revenue'])" accent="#B23A48" icon='<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>' />
        </div>
        <div class="grid grid-cols-5 gap-3.5">
            <x-stat-card :label="__('admin.pending_properties')" :value="$stats['pending_properties']" accent="#C97A2E" icon='<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/></svg>' />
            <x-stat-card :label="__('admin.rejected_properties')" :value="$stats['rejected_properties']" accent="#B23A48" icon='<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/></svg>' />
            <x-stat-card :label="__('admin.active_subscriptions')" :value="$stats['active_subscriptions']" accent="#2E8B57" icon='<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/></svg>' />
            <x-stat-card :label="__('admin.expired_subscriptions')" :value="$stats['expired_subscriptions']" accent="#6B7280" icon='<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/></svg>' />
            <x-stat-card :label="__('admin.total_commissions')" :value="__('common.currency').' '.number_format($stats['total_commissions'])" accent="#B8862E" icon='<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="5" x2="5" y2="19"/></svg>' />
        </div>
        <div class="grid grid-cols-2 gap-3.5">
            <x-panel :title="__('admin.most_active_cities')">
                <table class="w-full text-sm"><thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2">{{ __('common.city') }}</th><th class="pb-2 text-right">{{ __('admin.listings') }}</th></tr></thead><tbody>
                    @foreach ($activeCities as $c)
                        <tr class="border-t border-linesoft"><td class="py-2.5">{{ $c->city->name ?? '—' }}</td><td class="py-2.5 text-right">{{ $c->total }}</td></tr>
                    @endforeach
                </tbody></table>
            </x-panel>
            <x-panel :title="__('admin.approvals_awaiting_review')">
                <x-slot:action><x-badge status="Pending" /></x-slot:action>
                <table class="w-full text-sm"><thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2">{{ __('admin.property_col') }}</th><th class="pb-2">{{ __('admin.provider_col') }}</th></tr></thead><tbody>
                    @forelse ($pendingApprovals as $p)
                        <tr class="border-t border-linesoft"><td class="py-2.5">{{ $p->title }}</td><td class="py-2.5">{{ $p->serviceProvider->office_name }}</td></tr>
                    @empty
                        <tr><td colspan="2" class="py-4 text-textfaint text-center">{{ __('admin.nothing_pending') }}</td></tr>
                    @endforelse
                </tbody></table>
            </x-panel>
        </div>
    </div>
</x-admin-layout>
