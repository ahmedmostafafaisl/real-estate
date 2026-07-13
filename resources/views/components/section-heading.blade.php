@props(['eyebrow' => null, 'title'])
<div class="flex items-end justify-between mb-6">
    <div>
        @if ($eyebrow)<div class="text-xs font-semibold uppercase text-brass tracking-wide mb-1.5">{{ $eyebrow }}</div>@endif
        <h2 class="font-serif text-2xl md:text-3xl">{{ $title }}</h2>
    </div>
    @isset($action){{ $action }}@endisset
</div>
