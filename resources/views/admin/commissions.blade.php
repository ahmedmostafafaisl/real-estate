<x-admin-layout :title="__('admin.commissions_title')">
    <x-panel :title="__('admin.commissions_title')">
        <div class="flex gap-1.5 mb-3.5">
            <x-pill-button :href="route('admin.commissions')" :active="!request('status')">{{ __('common.all') }}</x-pill-button>
            @foreach (['pending','paid'] as $s)
                <x-pill-button :href="route('admin.commissions', ['status' => $s])" :active="request('status') === $s">{{ __('status.'.$s) }}</x-pill-button>
            @endforeach
        </div>
        <table class="w-full text-sm">
            <thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2 px-2">{{ __('admin.property_col') }}</th><th class="pb-2 px-2">{{ __('admin.provider_col') }}</th><th class="pb-2 px-2 text-right">{{ __('admin.commission_col') }}</th><th class="pb-2 px-2">{{ __('common.status') }}</th><th class="pb-2 px-2"></th></tr></thead>
            <tbody>
            @forelse ($commissions as $c)
                <tr class="border-t border-linesoft">
                    <td class="py-2.5 px-2">{{ $c->property->title }}</td>
                    <td class="py-2.5 px-2">{{ $c->serviceProvider->office_name }}</td>
                    <td class="py-2.5 px-2 text-right font-mono">{{ __('common.currency') }} {{ number_format($c->commission_amount) }}</td>
                    <td class="py-2.5 px-2"><x-badge :status="ucfirst($c->status)" /></td>
                    <td class="py-2.5 px-2 text-right">
                        @if ($c->status === 'pending')
                        <form action="{{ route('admin.commissions.mark-paid', $c) }}" method="POST">@csrf<button class="text-ksuccess text-xs font-semibold">{{ __('admin.mark_paid') }}</button></form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="py-6 text-center text-textfaint">{{ __('admin.no_commissions_yet') }}</td></tr>
            @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $commissions->links() }}</div>
    </x-panel>
</x-admin-layout>
