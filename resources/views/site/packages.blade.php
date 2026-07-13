<x-site-layout title="Subscription packages — Keystone">
    <div class="max-w-6xl mx-auto px-6 py-14">
        <div class="text-center max-w-xl mx-auto mb-10">
            <h1 class="font-serif text-3xl mb-3">List your properties with Keystone</h1>
            <p class="text-textmute">Pick a plan that fits your business — upgrade or switch anytime from your provider dashboard.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($packages as $p)
                <div class="bg-white border {{ $p->name === 'Pro' ? 'border-brass' : 'border-line' }} rounded-xl p-7">
                    @if ($p->name === 'Pro')<div class="text-brass text-xs font-semibold uppercase mb-2">Most popular</div>@endif
                    <div class="font-serif text-2xl">{{ $p->name }}</div>
                    <div class="font-mono text-3xl font-semibold my-3">SAR {{ $p->price }}<span class="text-sm font-sans text-textfaint">/mo</span></div>
                    <ul class="flex flex-col gap-2.5 mb-6 text-sm text-textmute">
                        <li>✓ {{ $p->listing_limit }} active listings</li>
                        <li>✓ {{ $p->featured_listing_limit }} featured slots / month</li>
                        @foreach (($p->perks ?? []) as $perk)<li>✓ {{ $perk }}</li>@endforeach
                    </ul>
                    <a href="{{ route('register.provider') }}" class="block text-center bg-ink text-white rounded-md py-2.5 text-sm font-semibold">Get started</a>
                </div>
            @endforeach
        </div>
    </div>
</x-site-layout>
