@props(['active' => false, 'href' => null])
@php $tag = $href ? 'a' : 'button'; @endphp
<{{ $tag }} @if($href) href="{{ $href }}" @endif {{ $attributes->merge(['class' => 'text-xs font-semibold rounded-full px-3.5 py-1.5 ' . ($active ? 'bg-ink text-white' : 'bg-canvas text-textmute')]) }}>
    {{ $slot }}
</{{ $tag }}>
