<x-site-layout :title="__('site.pricing_title')">
    <div class="max-w-6xl mx-auto px-6 py-14">
        <div class="text-center max-w-xl mx-auto mb-10">
            <h1 class="font-serif text-3xl mb-3">{{ __('site.pricing_title') }}</h1>
            <p class="text-textmute">{{ __('site.pricing_subtitle') }}</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($packages as $p)
                <div class="bg-white border {{ $p->slug === 'pro' ? 'border-brass' : 'border-line' }} rounded-xl p-7">
                    @if ($p->slug === 'pro')<div class="text-brass text-xs font-semibold uppercase mb-2">{{ __('site.most_popular') }}</div>@endif
                    <div class="font-serif text-2xl">{{ $p->name }}</div>
                    <div class="font-mono text-3xl font-semibold my-3">{{ __('common.currency') }} {{ $p->price }}<span class="text-sm font-sans text-textfaint">{{ __('common.per_month') }}</span></div>
                    <ul class="flex flex-col gap-2.5 mb-6 text-sm text-textmute">
                        <li>✓ {{ __('site.listings_limit', ['count' => $p->listing_limit]) }}</li>
                        <li>✓ {{ __('site.featured_slots', ['count' => $p->featured_listing_limit]) }}</li>
                        @foreach (($p->perks ?? []) as $perk)<li>✓ {{ $perk }}</li>@endforeach
                    </ul>
                    <a href="{{ route('register.provider') }}" class="block text-center bg-ink text-white rounded-md py-2.5 text-sm font-semibold">{{ __('common.get_started') }}</a>
                </div>
            @endforeach
        </div>
    </div>
</x-site-layout>
