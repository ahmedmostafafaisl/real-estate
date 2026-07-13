<x-admin-layout title="Reviews & reports">
    <div class="flex flex-col gap-3.5">
        <x-panel title="Customer reviews">
            <table class="w-full text-sm"><thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2">Property</th><th class="pb-2">Customer</th><th class="pb-2">Rating</th><th class="pb-2">Comment</th><th class="pb-2">Status</th><th class="pb-2"></th></tr></thead><tbody>
                @forelse ($reviews as $r)
                    <tr class="border-t border-linesoft">
                        <td class="py-2.5">{{ $r->property->title }}</td><td class="py-2.5">{{ $r->user->name }}</td>
                        <td class="py-2.5">{{ str_repeat('★', $r->rating) }}{{ str_repeat('☆', 5 - $r->rating) }}</td>
                        <td class="py-2.5 text-textmute">{{ $r->comment }}</td><td class="py-2.5"><x-badge :status="ucfirst($r->status)" /></td>
                        <td class="py-2.5 text-right whitespace-nowrap">
                            @if ($r->status === 'pending')
                            <form action="{{ route('admin.reviews.moderate', $r) }}" method="POST" class="inline">@csrf<input type="hidden" name="status" value="published"><button class="text-ksuccess text-xs font-semibold mr-2">Publish</button></form>
                            <form action="{{ route('admin.reviews.moderate', $r) }}" method="POST" class="inline">@csrf<input type="hidden" name="status" value="rejected"><button class="text-kdanger text-xs font-semibold">Reject</button></form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="py-6 text-center text-textfaint">No reviews yet.</td></tr>
                @endforelse
            </tbody></table>
        </x-panel>
        <x-panel title="Reported listings">
            <x-slot:action><x-badge status="Pending" /></x-slot:action>
            <table class="w-full text-sm"><thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2">Property</th><th class="pb-2">Reason</th><th class="pb-2">Reported by</th><th class="pb-2">Status</th><th class="pb-2"></th></tr></thead><tbody>
                @forelse ($reports as $r)
                    <tr class="border-t border-linesoft">
                        <td class="py-2.5">{{ $r->property->title }}</td><td class="py-2.5">{{ $r->reason }}</td><td class="py-2.5">{{ $r->user->name }}</td>
                        <td class="py-2.5"><x-badge :status="ucfirst($r->status)" /></td>
                        <td class="py-2.5 text-right">
                            @if ($r->status === 'open')
                            <form action="{{ route('admin.reports.resolve', $r) }}" method="POST">@csrf<button class="text-ksuccess text-xs font-semibold">Resolve</button></form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-6 text-center text-textfaint">No reports yet.</td></tr>
                @endforelse
            </tbody></table>
        </x-panel>
    </div>
</x-admin-layout>
