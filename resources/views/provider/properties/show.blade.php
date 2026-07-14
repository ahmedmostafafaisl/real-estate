<x-provider-layout :title="$property->title">
    <div class="flex items-center justify-between mb-4">
        <a href="{{ route('provider.properties.index') }}" class="text-xs font-semibold text-textmute">← {{ __('provider.back_to_listings') }}</a>
        <div class="flex items-center gap-2">
            <x-action-pill :href="route('provider.properties.edit', $property)">{{ __('common.edit') }}</x-action-pill>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-4">
        <div class="col-span-2 flex flex-col gap-4">
            <x-panel>
                <div class="flex items-start justify-between gap-3 mb-3">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <x-badge :status="ucfirst($property->status)" />
                            <span class="font-mono text-xs text-textfaint">PR-{{ $property->id }}</span>
                        </div>
                        <h1 class="font-serif text-2xl">{{ $property->title }}</h1>
                        <div class="text-sm text-textmute mt-1">{{ $property->city->name }}{{ $property->district ? ', '.$property->district->name : '' }} · {{ $property->type->name }}</div>
                    </div>
                    <x-lifecycle-arch :status="ucfirst($property->status)" />
                </div>

                @if ($property->images->isNotEmpty())
                    <div class="grid grid-cols-4 gap-2 mb-4">
                        @foreach ($property->images as $image)
                            <div class="relative h-24 rounded-lg overflow-hidden border border-line">
                                <img src="{{ asset('storage/' . $image->path) }}" alt="" class="w-full h-full object-cover">
                                @if ($image->is_featured)
                                    <span class="absolute top-1 start-1 bg-brass text-white text-[9px] font-semibold px-1.5 py-0.5 rounded-full">{{ __('provider.featured_photo') }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-textfaint mb-4">{{ __('provider.no_photos_yet') }}</p>
                @endif

                <div class="grid grid-cols-4 gap-3 mb-4">
                    <div class="bg-canvas rounded-lg p-3 text-center"><div class="font-mono font-semibold">{{ __('common.currency') }} {{ number_format($property->price) }}</div><div class="text-[11px] text-textfaint mt-0.5">{{ __('common.price') }}</div></div>
                    <div class="bg-canvas rounded-lg p-3 text-center"><div class="font-mono font-semibold">{{ $property->area_sqm ?? '—' }}</div><div class="text-[11px] text-textfaint mt-0.5">{{ __('provider.area_sqm') }}</div></div>
                    <div class="bg-canvas rounded-lg p-3 text-center"><div class="font-mono font-semibold">{{ $property->bedrooms ?? '—' }}</div><div class="text-[11px] text-textfaint mt-0.5">{{ __('provider.bedrooms') }}</div></div>
                    <div class="bg-canvas rounded-lg p-3 text-center"><div class="font-mono font-semibold">{{ $property->bathrooms ?? '—' }}</div><div class="text-[11px] text-textfaint mt-0.5">{{ __('provider.bathrooms') }}</div></div>
                </div>

                <h2 class="font-serif text-lg mb-2">{{ __('common.description') }}</h2>
                <p class="text-sm text-textmute leading-relaxed mb-4">{{ $property->description ?: '—' }}</p>

                @if ($property->features->isNotEmpty())
                    <h2 class="font-serif text-lg mb-2">{{ __('common.features') }}</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($property->features as $f)<span class="text-xs border border-line rounded-full px-3 py-1.5">{{ $f->name }}</span>@endforeach
                    </div>
                @endif
            </x-panel>

            <x-panel :title="__('provider.recent_inquiries')">
                <table class="w-full text-sm">
                    <thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2">{{ __('provider.customer') }}</th><th class="pb-2">{{ __('provider.message') }}</th><th class="pb-2">{{ __('common.status') }}</th></tr></thead>
                    <tbody>
                    @forelse ($recentInquiries as $i)
                        <tr class="border-t border-linesoft"><td class="py-2.5">{{ $i->user->name }}</td><td class="py-2.5 text-textmute">{{ $i->message }}</td><td class="py-2.5"><x-badge :status="ucfirst($i->status)" /></td></tr>
                    @empty
                        <tr><td colspan="3" class="py-4 text-textfaint text-center">{{ __('provider.no_inquiries_yet') }}</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </x-panel>

            <x-panel :title="__('provider.upcoming_viewings')">
                <table class="w-full text-sm">
                    <thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2">{{ __('provider.customer') }}</th><th class="pb-2">{{ __('provider.slot') }}</th><th class="pb-2">{{ __('common.status') }}</th></tr></thead>
                    <tbody>
                    @forelse ($recentViewings as $v)
                        <tr class="border-t border-linesoft"><td class="py-2.5">{{ $v->user->name }}</td><td class="py-2.5">{{ $v->requested_slot->format('M j, g:ia') }}</td><td class="py-2.5"><x-badge :status="ucfirst($v->status)" /></td></tr>
                    @empty
                        <tr><td colspan="3" class="py-4 text-textfaint text-center">{{ __('provider.no_viewings_scheduled') }}</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </x-panel>
        </div>

        <div class="flex flex-col gap-4">
            <div class="grid grid-cols-1 gap-3">
                <x-stat-card :label="__('provider.property_views')" :value="number_format($property->views_count)" accent="#B8862E"
                    icon='<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/><circle cx="12" cy="12" r="3"/></svg>' />
                <x-stat-card :label="__('provider.customer_inquiries')" :value="$stats['inquiries']" accent="#C97A2E"
                    icon='<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>' />
                <x-stat-card :label="__('provider.viewing_requests')" :value="$stats['viewing_requests']" accent="#1D6F64"
                    icon='<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/></svg>' />
                <x-stat-card :label="__('provider.reviews_count')" :value="$stats['reviews']" accent="#2E8B57"
                    icon='<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>' />
            </div>

            <x-panel :title="__('common.actions')">
                <div class="flex flex-col gap-2">
                    @if ($property->status === 'draft')
                        <form action="{{ route('provider.properties.submit', $property) }}" method="POST">@csrf<button class="w-full bg-ink text-white rounded-md py-2 text-xs font-semibold">{{ __('provider.submit') }}</button></form>
                    @elseif ($property->status === 'published')
                        <form action="{{ route('provider.properties.pause', $property) }}" method="POST">@csrf<button class="w-full border border-line rounded-md py-2 text-xs font-semibold text-kwarning">{{ __('provider.pause') }}</button></form>
                        <form action="{{ route('provider.properties.close-deal', $property) }}" method="POST"><input type="hidden" name="deal_type" value="sold">@csrf<button class="w-full border border-line rounded-md py-2 text-xs font-semibold text-teal">{{ __('provider.mark_sold') }}</button></form>
                        <form action="{{ route('provider.properties.close-deal', $property) }}" method="POST"><input type="hidden" name="deal_type" value="rented">@csrf<button class="w-full border border-line rounded-md py-2 text-xs font-semibold text-brass">{{ __('provider.mark_rented') }}</button></form>
                    @endif
                    <form action="{{ route('provider.properties.destroy', $property) }}" method="POST" onsubmit="return confirm('{{ __('provider.confirm_delete_listing') }}')">@csrf @method('DELETE')<button class="w-full border border-line rounded-md py-2 text-xs font-semibold text-kdanger">{{ __('common.delete') }}</button></form>
                </div>
            </x-panel>
        </div>
    </div>
</x-provider-layout>
