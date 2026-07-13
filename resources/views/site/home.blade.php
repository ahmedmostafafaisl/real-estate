<x-site-layout :title="__('site.meta_title_home')">

    <section class="bg-ink text-white">
        <div class="max-w-6xl mx-auto px-6 py-20 md:py-28">
            <div class="max-w-2xl">
                <div class="text-brass text-sm font-semibold uppercase tracking-wide mb-3">{{ __('site.stat_properties_cities', ['properties' => number_format($stats['properties']), 'cities' => $stats['cities']]) }}</div>
                <h1 class="font-serif text-4xl md:text-5xl leading-tight">{{ __('site.hero_title') }}</h1>
                <p class="text-[#C7CDD6] mt-4 text-lg">{{ __('site.hero_subtitle') }}</p>
            </div>

            <form action="{{ route('properties.index') }}" method="GET" class="bg-white rounded-xl p-3 mt-8 flex flex-col md:flex-row gap-2 max-w-3xl">
                <input name="q" placeholder="{{ __('site.search_placeholder') }}" class="flex-1 px-3 py-2.5 text-sm text-ktext outline-none rounded-md">
                <select name="listing_type" class="px-3 py-2.5 text-sm text-ktext rounded-md border-s border-linesoft md:border-s">
                    <option value="">{{ __('site.buy_or_rent') }}</option><option value="sale">{{ __('common.for_sale') }}</option><option value="rent">{{ __('common.for_rent') }}</option>
                </select>
                <button class="bg-ink text-white rounded-md px-6 py-2.5 text-sm font-semibold">{{ __('common.search') }}</button>
            </form>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-6 py-14">
        <x-section-heading :eyebrow="__('site.eyebrow_handpicked')" :title="__('site.featured_properties')">
            <x-slot:action><a href="{{ route('properties.index', ['featured_only' => 1]) }}" class="text-sm font-semibold text-brass">{{ __('common.view_all') }} →</a></x-slot:action>
        </x-section-heading>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @forelse ($featured as $p)
                <x-property-card :property="$p" />
            @empty
                <p class="text-textfaint col-span-3">{{ __('site.no_published_yet') }}</p>
            @endforelse
        </div>
    </section>

    <section class="bg-white border-y border-line py-14">
        <div class="max-w-6xl mx-auto px-6">
            <x-section-heading :eyebrow="__('site.eyebrow_browse')" :title="__('site.property_categories')" />
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($categories as $c)
                    <x-tile-link :href="route('categories.index')" :label="$c->name" :sub="__('site.listings_count', ['count' => $c->properties_count])" />
                @endforeach
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-6 py-14">
        <x-section-heading :eyebrow="__('site.eyebrow_explore')" :title="__('site.popular_cities')" />
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($cities as $c)
                <x-tile-link :href="route('properties.index', ['city_id' => $c->id])" :label="$c->name" :sub="__('site.listings_count', ['count' => $c->properties_count])" />
            @endforeach
        </div>
    </section>

    <section class="bg-white border-y border-line py-14">
        <div class="max-w-6xl mx-auto px-6">
            <x-section-heading :eyebrow="__('site.eyebrow_trusted')" :title="__('site.verified_providers')">
                <x-slot:action><a href="{{ route('providers.index') }}" class="text-sm font-semibold text-brass">{{ __('common.view_all') }} →</a></x-slot:action>
            </x-section-heading>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($providers as $p)
                    <a href="{{ route('providers.show', $p) }}" class="bg-paper border border-line rounded-xl p-4 text-center hover:border-brass">
                        <div class="w-11 h-11 rounded-full bg-brasssoft flex items-center justify-center mx-auto mb-2 font-serif text-brass">{{ strtoupper(substr($p->office_name,0,1)) }}</div>
                        <div class="font-semibold text-sm">{{ $p->office_name }}</div>
                        <div class="text-xs text-textfaint mt-0.5">{{ __('site.listings_count', ['count' => $p->properties_count]) }}</div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-6 py-16">
        <x-section-heading :eyebrow="__('site.eyebrow_for_providers')" :title="__('site.list_with_keystone')" />
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @foreach ($packages as $p)
                <div class="bg-white border border-line rounded-xl p-6">
                    <div class="font-serif text-xl">{{ $p->name }}</div>
                    <div class="font-mono text-2xl font-semibold my-2">{{ __('common.currency') }} {{ $p->price }}<span class="text-xs font-sans text-textfaint">{{ __('common.per_month') }}</span></div>
                    <div class="text-sm text-textmute mb-4">{{ __('site.listings_limit', ['count' => $p->listing_limit]) }} · {{ __('site.featured_slots', ['count' => $p->featured_listing_limit]) }}</div>
                    <a href="{{ route('register.provider') }}" class="block text-center bg-ink text-white rounded-md py-2.5 text-sm font-semibold">{{ __('common.get_started') }}</a>
                </div>
            @endforeach
        </div>
    </section>
</x-site-layout>
