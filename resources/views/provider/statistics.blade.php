<x-provider-layout :title="__('provider.statistics')">
    <div class="flex flex-col gap-3.5">
        <x-panel :title="__('provider.views_by_property')">
            <div class="flex flex-col gap-2">
                @foreach ($topProperties as $p)
                    @php $max = $topProperties->max('views_count') ?: 1; @endphp
                    <div class="flex items-center gap-3">
                        <div class="w-[110px] text-xs text-textmute truncate">{{ $p->title }}</div>
                        <div class="flex-1 h-3 bg-canvas rounded"><div class="h-3 rounded bg-brass" style="width: {{ max(4, round($p->views_count / $max * 100)) }}%"></div></div>
                        <div class="w-[50px] text-xs text-right font-mono">{{ $p->views_count }}</div>
                    </div>
                @endforeach
            </div>
        </x-panel>
        <div class="grid grid-cols-2 gap-3.5">
            <x-stat-card :label="__('provider.average_views')" :value="$avgViews" accent="#1D6F64" icon='<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>' />
            <x-stat-card :label="__('provider.inquiry_conversion')" :value="$conversion.'%'" :sub="__('provider.inquiries_per_100_views')" accent="#B8862E" icon='<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>' />
        </div>
    </div>
</x-provider-layout>
