@props(['href', 'label', 'sub' => null])
<a href="{{ $href }}" class="bg-white border border-line rounded-xl p-4 flex items-center justify-between hover:border-brass transition-colors">
    <div>
        <div class="font-serif text-base">{{ $label }}</div>
        @if ($sub)<div class="text-xs text-textfaint mt-0.5">{{ $sub }}</div>@endif
    </div>
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8A929C" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
</a>
