@props(['status' => 'Draft'])
@php
$order = ['Draft', 'Pending', 'Published', 'Sold', 'Rented', 'Expired'];
$colors = ['Draft' => '#6B7280', 'Pending' => '#C97A2E', 'Published' => '#2E8B57', 'Sold' => '#1D6F64', 'Rented' => '#B8862E', 'Expired' => '#B23A48', 'Rejected' => '#B23A48'];
$idx = array_search($status, $order);
$isBroken = in_array($status, ['Expired', 'Rejected']);
@endphp
<svg width="72" height="20" viewBox="0 0 72 20">
    @for ($i = 0; $i < 5; $i++)
        @php $active = $isBroken ? false : ($idx !== false && $i <= $idx); @endphp
        <rect x="{{ 6 + $i * 13 }}" y="{{ $isBroken ? 12 : 4 }}" width="10" height="{{ $isBroken ? 6 : 14 }}" rx="2"
              fill="{{ $active ? ($colors[$status] ?? '#6B7280') : '#E8ECE9' }}" opacity="{{ $isBroken ? 0.5 : 1 }}" />
    @endfor
</svg>
