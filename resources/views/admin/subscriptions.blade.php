<x-admin-layout title="Subscriptions">
    <div class="flex flex-col gap-3.5">
        <div class="grid grid-cols-3 gap-3.5">
            @foreach ($packages as $p)
                <div class="bg-white border border-line rounded-[10px] p-4">
                    <div class="font-serif text-lg">{{ $p->name }}</div>
                    <div class="font-mono text-2xl font-semibold my-2">SAR {{ $p->price }}<span class="text-xs font-sans text-textfaint">/mo</span></div>
                    <div class="text-[12.5px] text-textmute">{{ $p->listing_limit }} listings · {{ $p->featured_listing_limit }} featured/mo</div>
                </div>
            @endforeach
        </div>
        <x-panel title="Add package">
            <form action="{{ route('admin.subscriptions.packages.store') }}" method="POST" class="grid grid-cols-5 gap-2">
                @csrf
                <input name="name" placeholder="Name" required class="border border-line rounded-md px-2.5 py-2 text-sm">
                <input name="price" type="number" placeholder="Price" required class="border border-line rounded-md px-2.5 py-2 text-sm">
                <input name="listing_limit" type="number" placeholder="Listing limit" required class="border border-line rounded-md px-2.5 py-2 text-sm">
                <input name="featured_listing_limit" type="number" placeholder="Featured slots" required class="border border-line rounded-md px-2.5 py-2 text-sm">
                <button class="bg-ink text-white rounded-md px-3.5 py-2 text-xs font-semibold">Add package</button>
            </form>
        </x-panel>
        <x-panel title="Active subscriptions">
            <div class="flex gap-1.5 mb-3.5">
                <x-pill-button :href="route('admin.subscriptions')" :active="!request('status')">All</x-pill-button>
                @foreach (['active','expired','cancelled'] as $s)
                    <x-pill-button :href="route('admin.subscriptions', ['status' => $s])" :active="request('status') === $s">{{ ucfirst($s) }}</x-pill-button>
                @endforeach
            </div>
            <table class="w-full text-sm"><thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2">Provider</th><th class="pb-2">Plan</th><th class="pb-2">Renews</th><th class="pb-2">Status</th></tr></thead><tbody>
                @forelse ($subscriptions as $s)
                    <tr class="border-t border-linesoft"><td class="py-2.5">{{ $s->serviceProvider->office_name }}</td><td class="py-2.5">{{ $s->package->name }}</td><td class="py-2.5">{{ $s->ends_at->format('M j, Y') }}</td><td class="py-2.5"><x-badge :status="ucfirst($s->status)" /></td></tr>
                @empty
                    <tr><td colspan="4" class="py-6 text-center text-textfaint">No subscriptions yet.</td></tr>
                @endforelse
            </tbody></table>
            <div class="mt-4">{{ $subscriptions->links() }}</div>
        </x-panel>
    </div>
</x-admin-layout>
