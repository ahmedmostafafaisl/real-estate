@props(['property'])
@php
$image = $property->relationLoaded('images') ? ($property->images->firstWhere('is_featured', true) ?? $property->images->first()) : null;
@endphp
<a href="{{ route('properties.show', $property) }}" class="block bg-white border border-line rounded-xl overflow-hidden group">
    <div class="h-40 bg-gradient-to-br from-brasssoft to-tealsoft flex items-center justify-center relative">
        @if ($image)
            <img src="{{ asset('storage/' . $image->path) }}" alt="" class="absolute inset-0 w-full h-full object-cover">
        @else
            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#B8862E" stroke-width="1.6"><rect x="4" y="2" width="16" height="20" rx="1"/><line x1="9" y1="7" x2="9" y2="7.01"/><line x1="15" y1="7" x2="15" y2="7.01"/></svg>
        @endif
        @if ($property->is_featured)
            <span class="absolute top-2.5 start-2.5 bg-brass text-white text-[10.5px] font-semibold px-2 py-1 rounded-full">{{ __('common.featured') }}</span>
        @endif
        <span class="absolute top-2.5 end-2.5 bg-white/90 text-ktext text-[10.5px] font-semibold px-2 py-1 rounded-full">{{ $property->listing_type === 'sale' ? __('common.for_sale') : __('common.for_rent') }}</span>
    </div>
    <div class="p-4">
        <div class="font-serif text-base leading-snug group-hover:text-brass">{{ $property->title }}</div>
        <div class="text-xs text-textfaint mt-1 flex items-center gap-1">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 1 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            {{ $property->city->name ?? '' }}
        </div>
        <div class="flex items-center justify-between mt-3">
            <span class="font-mono text-sm font-semibold">{{ __('common.currency') }} {{ number_format($property->price) }}</span>
            <span class="text-xs text-textfaint">{{ $property->bedrooms ? $property->bedrooms.' '.__('common.bed_abbr') : '' }} {{ $property->bathrooms ? '· '.$property->bathrooms.' '.__('common.bath_abbr') : '' }}</span>
        </div>
    </div>
</a>
