@props(['title' => null])
<div class="bg-white border border-line rounded-[10px]">
    @if ($title)
        <div class="flex items-center justify-between px-[18px] py-3.5 border-b border-linesoft">
            <div class="font-serif text-base">{{ $title }}</div>
            @isset($action){{ $action }}@endisset
        </div>
    @endif
    <div class="p-[18px]">{{ $slot }}</div>
</div>
