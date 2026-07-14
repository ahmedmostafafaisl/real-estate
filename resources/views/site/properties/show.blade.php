<x-site-layout :title="$property->title">
    <div class="max-w-6xl mx-auto px-6 py-10">
        @if ($property->images->isNotEmpty())
            <div class="grid grid-cols-4 gap-2 mb-6">
                <div class="col-span-3 h-72 rounded-xl overflow-hidden">
                    <img src="{{ asset('storage/' . ($property->images->firstWhere('is_featured', true) ?? $property->images->first())->path) }}" alt="" class="w-full h-full object-cover">
                </div>
                <div class="flex flex-col gap-2">
                    @foreach ($property->images->reject(fn ($i) => $i->is_featured)->take(3) as $thumb)
                        <div class="h-[88px] rounded-lg overflow-hidden"><img src="{{ asset('storage/' . $thumb->path) }}" alt="" class="w-full h-full object-cover"></div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="h-72 bg-gradient-to-br from-brasssoft to-tealsoft rounded-xl flex items-center justify-center mb-6">
                <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#B8862E" stroke-width="1.4"><rect x="4" y="2" width="16" height="20" rx="1"/><line x1="9" y1="7" x2="9" y2="7.01"/><line x1="15" y1="7" x2="15" y2="7.01"/></svg>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2">
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $property->listing_type === 'sale' ? 'bg-tealsoft text-teal' : 'bg-brasssoft text-brass' }}">{{ $property->listing_type === 'sale' ? __('common.for_sale') : __('common.for_rent') }}</span>
                    <span class="text-xs text-textfaint">{{ $property->type->name }} · {{ $property->category->name }}</span>
                </div>
                <h1 class="font-serif text-3xl mb-2">{{ $property->title }}</h1>
                <div class="text-textmute flex items-center gap-1.5 mb-4">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 1 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    {{ $property->city->name }}{{ $property->district ? ', '.$property->district->name : '' }}
                </div>

                <div class="grid grid-cols-4 gap-3 mb-6">
                    <div class="bg-white border border-line rounded-lg p-3 text-center"><div class="font-mono font-semibold">{{ $property->area_sqm ?? '—' }}</div><div class="text-[11px] text-textfaint mt-0.5">{{ __('site.sqm') }}</div></div>
                    <div class="bg-white border border-line rounded-lg p-3 text-center"><div class="font-mono font-semibold">{{ $property->bedrooms ?? '—' }}</div><div class="text-[11px] text-textfaint mt-0.5">{{ __('site.bedrooms') }}</div></div>
                    <div class="bg-white border border-line rounded-lg p-3 text-center"><div class="font-mono font-semibold">{{ $property->bathrooms ?? '—' }}</div><div class="text-[11px] text-textfaint mt-0.5">{{ __('site.bathrooms') }}</div></div>
                    <div class="bg-white border border-line rounded-lg p-3 text-center"><div class="font-mono font-semibold">{{ $property->views_count }}</div><div class="text-[11px] text-textfaint mt-0.5">{{ __('site.views') }}</div></div>
                </div>

                <h2 class="font-serif text-xl mb-2">{{ __('common.description') }}</h2>
                <p class="text-textmute leading-relaxed mb-6">{{ $property->description ?: __('site.no_description_yet') }}</p>

                @if ($property->features->count())
                <h2 class="font-serif text-xl mb-3">{{ __('common.features') }}</h2>
                <div class="flex flex-wrap gap-2 mb-6">
                    @foreach ($property->features as $f)<span class="text-xs border border-line rounded-full px-3 py-1.5">{{ $f->name }}</span>@endforeach
                </div>
                @endif
            </div>

            <div>
                <div class="bg-white border border-line rounded-xl p-5 sticky top-24">
                    <div class="font-mono text-2xl font-semibold mb-4">{{ __('common.currency') }} {{ number_format($property->price) }}</div>

                    <a href="{{ route('providers.show', $property->serviceProvider) }}" class="flex items-center gap-2.5 mb-4">
                        <div class="w-9 h-9 rounded-lg bg-brasssoft flex items-center justify-center font-serif text-brass">{{ strtoupper(substr($property->serviceProvider->office_name,0,1)) }}</div>
                        <div><div class="text-sm font-semibold">{{ $property->serviceProvider->office_name }}</div><div class="text-[11px] text-textfaint">{{ __('common.'.$property->serviceProvider->provider_type) }}</div></div>
                    </a>

                    @auth
                        <form action="{{ route('properties.viewing-requests.store', $property) }}" method="POST" class="mb-2.5">
                            @csrf
                            <input type="datetime-local" name="requested_slot" required class="w-full border border-line rounded-md px-3 py-2 text-sm mb-2">
                            <button class="w-full bg-ink text-white rounded-md py-2.5 text-sm font-semibold">{{ __('site.request_viewing') }}</button>
                        </form>
                        <form action="{{ route('properties.inquiries.store', $property) }}" method="POST">
                            @csrf
                            <textarea name="message" required placeholder="{{ __('site.ask_question_placeholder') }}" rows="2" class="w-full border border-line rounded-md px-3 py-2 text-sm mb-2"></textarea>
                            <button class="w-full border border-line rounded-md py-2.5 text-sm font-semibold">{{ __('site.send_inquiry') }}</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block text-center bg-ink text-white rounded-md py-2.5 text-sm font-semibold">{{ __('site.login_to_contact') }}</a>
                    @endauth
                </div>
            </div>
        </div>

        @if ($similar->count())
        <div class="mt-14">
            <x-section-heading :title="__('site.similar_nearby')" />
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                @foreach ($similar as $s)<x-property-card :property="$s" />@endforeach
            </div>
        </div>
        @endif
    </div>
</x-site-layout>
