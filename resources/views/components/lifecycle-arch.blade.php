@props(['status' => 'Draft'])
@php
$order = ['Draft', 'Pending', 'Published', 'Sold', 'Rented', 'Expired'];
$colors = ['Draft' => '#6B7280', 'Pending' => '#C97A2E', 'Published' => '#2E8B57', 'Sold' => '#1D6F64', 'Rented' => '#B8862E', 'Expired' => '#B23A48'];
$idx = array_search($status, $order);
$isExpired = $status === 'Expired';
@endphp
<svg width="72" height="20" viewBox="0 0 72 20">
    @for ($i = 0; $i < 5; $i++)
        @php $active = $isExpired ? false : $i <= $idx; @endphp
        <rect x="{{ 6 + $i * 13 }}" y="{{ $isExpired ? 12 : 4 }}" width="10" height="{{ $isExpired ? 6 : 14 }}" rx="2"
              fill="{{ $active ? $colors[$status] : '#E8ECE9' }}" opacity="{{ $isExpired ? 0.5 : 1 }}" />
    @endfor
</svg>
