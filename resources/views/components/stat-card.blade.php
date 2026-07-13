@props(['label' => '', 'value' => '', 'sub' => null, 'accent' => '#B8862E', 'icon' => null])
<div class="bg-white border border-line rounded-[10px] p-4 flex flex-col gap-2.5">
    <div class="w-[34px] h-[34px] rounded-lg flex items-center justify-center" style="background: {{ $accent }}1A">
        <span style="color: {{ $accent }}">{!! $icon !!}</span>
    </div>
    <div>
        <div class="font-mono text-2xl font-semibold leading-tight">{{ $value }}</div>
        <div class="text-[12.5px] text-textmute mt-1">{{ $label }}</div>
        @if ($sub)
            <div class="text-[11px] text-textfaint mt-0.5">{{ $sub }}</div>
        @endif
    </div>
</div>
