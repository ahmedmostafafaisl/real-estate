<x-provider-layout title="Dashboard">
    <div class="flex flex-col gap-4">
        <div class="grid grid-cols-4 gap-3.5">
            <x-stat-card label="Total properties" :value="$stats['total']" :sub="$stats['published'].' published'" accent="#1D6F64"
                icon='<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="2" width="16" height="20" rx="1"/><line x1="9" y1="7" x2="9" y2="7.01"/></svg>' />
            <x-stat-card label="Property views" :value="number_format($stats['views'])" accent="#B8862E"
                icon='<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/><circle cx="12" cy="12" r="3"/></svg>' />
            <x-stat-card label="Customer inquiries" :value="$stats['inquiries']" accent="#C97A2E"
                icon='<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>' />
            <x-stat-card label="Subscription" :value="$daysLeft.' days'" :sub="$subscription ? $subscription->package->name.' plan' : 'No active plan'" accent="#2E8B57"
                icon='<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>' />
        </div>

        <div class="grid grid-cols-5 gap-3.5">
            <x-stat-card label="Pending" :value="$stats['pending']" accent="#C97A2E" icon='<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/></svg>' />
            <x-stat-card label="Rejected" :value="$stats['rejected']" accent="#B23A48" icon='<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/></svg>' />
            <x-stat-card label="Expired" :value="$stats['expired']" accent="#6B7280" icon='<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/></svg>' />
            <x-stat-card label="Viewing requests" :value="$stats['viewing_requests']" accent="#1D6F64" icon='<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/></svg>' />
            <x-stat-card label="Commission summary" :value="'SAR '.number_format($stats['commissions'])" accent="#B8862E" icon='<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="5" x2="5" y2="19"/></svg>' />
        </div>

        <x-stat-card label="Revenue summary" :value="'SAR '.number_format($stats['revenue'])" accent="#2E8B57"
            icon='<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>' />

        <div class="grid grid-cols-2 gap-3.5">
            <x-panel title="Recent inquiries">
                <table class="w-full text-sm">
                    <thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2">Customer</th><th class="pb-2">Property</th><th class="pb-2">Status</th></tr></thead>
                    <tbody>
                    @forelse ($recentInquiries as $i)
                        <tr class="border-t border-linesoft"><td class="py-2.5">{{ $i->user->name }}</td><td class="py-2.5">{{ $i->property->title }}</td><td class="py-2.5"><x-badge :status="ucfirst($i->status)" /></td></tr>
                    @empty
                        <tr><td colspan="3" class="py-4 text-textfaint text-center">No inquiries yet.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </x-panel>
            <x-panel title="Upcoming viewings">
                <table class="w-full text-sm">
                    <thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2">Customer</th><th class="pb-2">Slot</th><th class="pb-2">Status</th></tr></thead>
                    <tbody>
                    @forelse ($upcomingViewings as $v)
                        <tr class="border-t border-linesoft"><td class="py-2.5">{{ $v->user->name }}</td><td class="py-2.5">{{ $v->requested_slot->format('M j, g:ia') }}</td><td class="py-2.5"><x-badge :status="ucfirst($v->status)" /></td></tr>
                    @empty
                        <tr><td colspan="3" class="py-4 text-textfaint text-center">No viewings scheduled.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </x-panel>
        </div>
    </div>
</x-provider-layout>
