{{-- Small consistent action button used in table rows — replaces bare colored text
     links so every table's actions column looks the same across admin and provider. --}}
@props(['tone' => 'neutral', 'href' => null])
@php
$tones = [
    'neutral' => 'text-textmute bg-canvas hover:bg-linesoft',
    'success' => 'text-ksuccess bg-successsoft hover:bg-successsoft',
    'warning' => 'text-kwarning bg-warningsoft hover:bg-warningsoft',
    'danger' => 'text-kdanger bg-dangersoft hover:bg-dangersoft',
    'info' => 'text-teal bg-tealsoft hover:bg-tealsoft',
];
$classes = 'inline-flex items-center gap-1 text-[11.5px] font-semibold px-2.5 py-1 rounded-full transition-colors ' . ($tones[$tone] ?? $tones['neutral']);
$tag = $href ? 'a' : 'button';
@endphp
<{{ $tag }} @if($href) href="{{ $href }}" @endif {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</{{ $tag }}>
