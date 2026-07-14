<x-admin-layout :title="$property->title">
    <div class="flex items-center justify-between mb-4">
        <a href="{{ route('admin.properties.index') }}" class="text-xs font-semibold text-textmute">← {{ __('admin.back_to_properties') }}</a>
        <x-action-pill :href="route('admin.properties.photos', $property)">{{ __('admin.manage_photos') }}</x-action-pill>
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

            <x-panel :title="__('admin.customer_reviews')">
                <table class="w-full text-sm">
                    <thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2">{{ __('admin.customer_col') }}</th><th class="pb-2">{{ __('admin.rating_col') }}</th><th class="pb-2">{{ __('admin.comment_col') }}</th><th class="pb-2">{{ __('common.status') }}</th></tr></thead>
                    <tbody>
                    @forelse ($reviews as $r)
                        <tr class="border-t border-linesoft">
                            <td class="py-2.5">{{ $r->user->name }}</td>
                            <td class="py-2.5">{{ str_repeat('★', $r->rating) }}{{ str_repeat('☆', 5 - $r->rating) }}</td>
                            <td class="py-2.5 text-textmute">{{ $r->comment }}</td>
                            <td class="py-2.5"><x-badge :status="ucfirst($r->status)" /></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="py-4 text-textfaint text-center">{{ __('admin.no_reviews_yet') }}</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </x-panel>

            <x-panel :title="__('admin.reported_listings')">
                <table class="w-full text-sm">
                    <thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2">{{ __('admin.reason_col') }}</th><th class="pb-2">{{ __('admin.reported_by_col') }}</th><th class="pb-2">{{ __('common.status') }}</th></tr></thead>
                    <tbody>
                    @forelse ($reports as $r)
                        <tr class="border-t border-linesoft"><td class="py-2.5">{{ $r->reason }}</td><td class="py-2.5">{{ $r->user->name }}</td><td class="py-2.5"><x-badge :status="ucfirst($r->status)" /></td></tr>
                    @empty
                        <tr><td colspan="3" class="py-4 text-textfaint text-center">{{ __('admin.no_reports_yet') }}</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </x-panel>
        </div>

        <div class="flex flex-col gap-4">
            <x-panel :title="__('admin.provider_col')">
                <a href="{{ route('admin.providers.index') }}" class="flex items-center gap-2.5 mb-1">
                    <div class="w-9 h-9 rounded-lg bg-brasssoft flex items-center justify-center font-serif text-brass">{{ strtoupper(substr($property->serviceProvider->office_name, 0, 1)) }}</div>
                    <div>
                        <div class="text-sm font-semibold">{{ $property->serviceProvider->office_name }}</div>
                        <div class="text-[11px] text-textfaint">{{ __('common.'.$property->serviceProvider->provider_type) }} · {{ $property->serviceProvider->city->name ?? '' }}</div>
                    </div>
                </a>
            </x-panel>

            <div class="grid grid-cols-1 gap-3">
                <x-stat-card :label="__('provider.property_views')" :value="number_format($property->views_count)" accent="#B8862E"
                    icon='<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/><circle cx="12" cy="12" r="3"/></svg>' />
                <x-stat-card :label="__('admin.inquiries_count')" :value="$stats['inquiries']" accent="#C97A2E"
                    icon='<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>' />
                <x-stat-card :label="__('admin.viewing_requests_count')" :value="$stats['viewing_requests']" accent="#1D6F64"
                    icon='<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/></svg>' />
            </div>

            @if ($property->status === 'pending')
            <x-panel :title="__('common.actions')">
                <div class="flex flex-col gap-2">
                    <form action="{{ route('admin.properties.approve', $property) }}" method="POST">@csrf<button class="w-full bg-ink text-white rounded-md py-2 text-xs font-semibold">{{ __('admin.approve') }}</button></form>
                    <form action="{{ route('admin.properties.reject', $property) }}" method="POST" onsubmit="return promptReject(this)">
                        @csrf<input type="hidden" name="reason" value="">
                        <button class="w-full border border-line rounded-md py-2 text-xs font-semibold text-kdanger">{{ __('admin.reject') }}</button>
                    </form>
                </div>
            </x-panel>
            <script>
                function promptReject(form) {
                    const reason = prompt('{{ __('admin.reason_for_rejection') }}');
                    if (!reason) return false;
                    form.querySelector('[name=reason]').value = reason;
                    return true;
                }
            </script>
            @endif
        </div>
    </div>
</x-admin-layout>
