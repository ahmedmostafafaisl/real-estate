@props(['status' => 'Draft'])
@php
$map = [
    'Draft' => ['text-kslate', 'bg-slatesoft'], 'Pending' => ['text-kwarning', 'bg-warningsoft'],
    'Published' => ['text-ksuccess', 'bg-successsoft'], 'Sold' => ['text-teal', 'bg-tealsoft'],
    'Rented' => ['text-brass', 'bg-brasssoft'], 'Expired' => ['text-kdanger', 'bg-dangersoft'],
    'Rejected' => ['text-kdanger', 'bg-dangersoft'], 'Active' => ['text-ksuccess', 'bg-successsoft'],
    'Inactive' => ['text-kslate', 'bg-slatesoft'],
    'Cancelled' => ['text-kdanger', 'bg-dangersoft'], 'Paid' => ['text-ksuccess', 'bg-successsoft'],
    'Unpaid' => ['text-kwarning', 'bg-warningsoft'], 'Refunded' => ['text-kslate', 'bg-slatesoft'],
    'Verified' => ['text-ksuccess', 'bg-successsoft'], 'New' => ['text-kwarning', 'bg-warningsoft'],
    'Responded' => ['text-ksuccess', 'bg-successsoft'], 'Requested' => ['text-kwarning', 'bg-warningsoft'],
    'Confirmed' => ['text-teal', 'bg-tealsoft'], 'Completed' => ['text-ksuccess', 'bg-successsoft'],
    'Open' => ['text-kdanger', 'bg-dangersoft'], 'Resolved' => ['text-ksuccess', 'bg-successsoft'],
    'Void' => ['text-kslate', 'bg-slatesoft'], 'Closed' => ['text-kslate', 'bg-slatesoft'],
    'Dismissed' => ['text-kslate', 'bg-slatesoft'], 'Read' => ['text-ksuccess', 'bg-successsoft'],
];
[$textClass, $bgClass] = $map[$status] ?? ['text-kslate', 'bg-slatesoft'];
$statusKey = 'status.' . \Illuminate\Support\Str::lower($status);
$label = \Illuminate\Support\Facades\Lang::has($statusKey) ? __($statusKey) : $status;
@endphp
<span class="{{ $textClass }} {{ $bgClass }} font-semibold text-[11.5px] px-2.5 py-1 rounded-full inline-flex items-center gap-1 whitespace-nowrap">{{ $label }}</span>
