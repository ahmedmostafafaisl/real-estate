<x-admin-layout :title="__('admin.subscriptions_title')">
    <div class="flex flex-col gap-3.5">
        <div class="grid grid-cols-3 gap-3.5">
            @foreach ($packages as $p)
                <div class="bg-white border border-line rounded-[10px] p-4">
                    <div class="font-serif text-lg">{{ $p->name }}</div>
                    <div class="font-mono text-2xl font-semibold my-2">{{ __('common.currency') }} {{ $p->price }}<span class="text-xs font-sans text-textfaint">{{ __('common.per_month') }}</span></div>
                    <div class="text-[12.5px] text-textmute">{{ __('site.listings_limit', ['count' => $p->listing_limit]) }} · {{ __('site.featured_slots', ['count' => $p->featured_listing_limit]) }}</div>
                </div>
            @endforeach
        </div>
        <x-panel :title="__('admin.add_package')">
            <form action="{{ route('admin.subscriptions.packages.store') }}" method="POST" class="grid grid-cols-5 gap-2">
                @csrf
                <input name="name" placeholder="{{ __('admin.package_name') }}" required class="border border-line rounded-md px-2.5 py-2 text-sm">
                <input name="price" type="number" placeholder="{{ __('admin.package_price') }}" required class="border border-line rounded-md px-2.5 py-2 text-sm">
                <input name="listing_limit" type="number" placeholder="{{ __('admin.listing_limit') }}" required class="border border-line rounded-md px-2.5 py-2 text-sm">
                <input name="featured_listing_limit" type="number" placeholder="{{ __('admin.featured_slots_field') }}" required class="border border-line rounded-md px-2.5 py-2 text-sm">
                <button class="bg-ink text-white rounded-md px-3.5 py-2 text-xs font-semibold">{{ __('admin.add_package') }}</button>
            </form>
        </x-panel>
        <x-panel :title="__('admin.active_subscriptions_panel')">
            <div class="flex gap-1.5 mb-3.5">
                <x-pill-button :href="route('admin.subscriptions')" :active="!request('status')">{{ __('common.all') }}</x-pill-button>
                @foreach (['active','expired','cancelled'] as $s)
                    <x-pill-button :href="route('admin.subscriptions', ['status' => $s])" :active="request('status') === $s">{{ __('status.'.$s) }}</x-pill-button>
                @endforeach
            </div>
            <table class="w-full text-sm"><thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2">{{ __('admin.provider_col') }}</th><th class="pb-2">{{ __('admin.plan_col') }}</th><th class="pb-2">{{ __('admin.renews_col') }}</th><th class="pb-2">{{ __('common.status') }}</th></tr></thead><tbody>
                @forelse ($subscriptions as $s)
                    <tr class="border-t border-linesoft"><td class="py-2.5">{{ $s->serviceProvider->office_name }}</td><td class="py-2.5">{{ $s->package->name }}</td><td class="py-2.5">{{ $s->ends_at->format('M j, Y') }}</td><td class="py-2.5"><x-badge :status="ucfirst($s->status)" /></td></tr>
                @empty
                    <tr><td colspan="4" class="py-6 text-center text-textfaint">{{ __('admin.no_subscriptions_yet') }}</td></tr>
                @endforelse
            </tbody></table>
            <div class="mt-4">{{ $subscriptions->links() }}</div>
        </x-panel>
    </div>
</x-admin-layout>
