<x-provider-layout :title="__('provider.subscription')">
    <div class="flex flex-col gap-3.5">
        <x-panel :title="__('provider.current_plan')">
            <div class="flex justify-between items-start flex-wrap gap-5">
                <div>
                    <div class="font-serif text-xl">{{ $current->package->name ?? __('provider.no_plan') }} {{ __('provider.plan_word') }}</div>
                    <div class="text-sm text-textmute mt-1">
                        @if ($current) {{ __('common.currency') }} {{ $current->package->price }}{{ __('common.per_month') }} · {{ __('provider.renews') }} {{ $current->ends_at->format('M j, Y') }} @else {{ __('provider.no_active_subscription') }} @endif
                    </div>
                    @if ($current)
                    <div class="mt-3.5 w-[220px]">
                        <div class="flex justify-between text-[11.5px] text-textfaint mb-1"><span>{{ __('provider.days_left', ['count' => $daysLeft]) }}</span><span>{{ min(100, round($daysLeft/30*100)) }}%</span></div>
                        <div class="h-1.5 rounded bg-linesoft"><div class="h-1.5 rounded bg-brass" style="width: {{ min(100, round($daysLeft/30*100)) }}%"></div></div>
                    </div>
                    @endif
                </div>
                @if ($current)
                <div class="text-right">
                    <div class="font-mono text-xl font-semibold">{{ $used }}/{{ $current->package->listing_limit }}</div>
                    <div class="text-xs text-textmute">{{ __('provider.listings_used') }}</div>
                </div>
                @endif
            </div>
        </x-panel>

        <div class="grid grid-cols-3 gap-3.5">
            @foreach ($packages as $p)
                @php $isCurrent = $current && $current->package->id === $p->id; @endphp
                <div class="bg-white border rounded-[10px] p-4.5 {{ $isCurrent ? 'border-brass' : 'border-line' }}">
                    <div class="flex justify-between items-center">
                        <span class="font-serif text-lg">{{ $p->name }}</span>
                        @if ($isCurrent)<x-badge status="Active" />@endif
                    </div>
                    <div class="font-mono text-2xl font-semibold my-2.5">{{ __('common.currency') }} {{ $p->price }}<span class="text-xs text-textfaint font-sans">{{ __('common.per_month') }}</span></div>
                    <div class="text-[12.5px] text-textmute mb-3.5">{{ __('site.listings_limit', ['count' => $p->listing_limit]) }} · {{ __('site.featured_slots', ['count' => $p->featured_listing_limit]) }}</div>
                    @unless ($isCurrent)
                    <form action="{{ route('provider.subscription.subscribe') }}" method="POST">
                        @csrf<input type="hidden" name="subscription_package_id" value="{{ $p->id }}">
                        <button class="bg-ink text-white rounded-md w-full py-2 text-xs font-semibold">{{ __('provider.switch_to', ['plan' => $p->name]) }}</button>
                    </form>
                    @else
                    <button disabled class="border border-line rounded-md w-full py-2 text-xs font-semibold text-textmute opacity-60">{{ __('provider.current_plan') }}</button>
                    @endunless
                </div>
            @endforeach
        </div>
    </div>
</x-provider-layout>
