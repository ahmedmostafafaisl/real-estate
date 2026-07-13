<x-provider-layout title="Viewing appointments">
    <x-panel title="Viewing appointments">
        <table class="w-full text-sm">
            <thead><tr class="text-[11px] uppercase text-textfaint text-left">
                <th class="pb-2 px-2">Customer</th><th class="pb-2 px-2">Property</th><th class="pb-2 px-2">Slot</th>
                <th class="pb-2 px-2">Status</th><th class="pb-2 px-2"></th>
            </tr></thead>
            <tbody>
            @forelse ($viewings as $v)
                <tr class="border-t border-linesoft">
                    <td class="py-2.5 px-2">{{ $v->user->name }}</td>
                    <td class="py-2.5 px-2">{{ $v->property->title }}</td>
                    <td class="py-2.5 px-2">{{ $v->requested_slot->format('M j, g:ia') }}</td>
                    <td class="py-2.5 px-2"><x-badge :status="ucfirst($v->status)" /></td>
                    <td class="py-2.5 px-2 text-right whitespace-nowrap">
                        @if ($v->status === 'requested')
                            <form action="{{ route('provider.viewings.update', $v) }}" method="POST" class="inline">@csrf @method('PATCH')<input type="hidden" name="status" value="confirmed"><button class="text-ksuccess text-xs font-semibold mr-2">Confirm</button></form>
                            <form action="{{ route('provider.viewings.update', $v) }}" method="POST" class="inline">@csrf @method('PATCH')<input type="hidden" name="status" value="cancelled"><button class="text-kdanger text-xs font-semibold">Decline</button></form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="py-6 text-center text-textfaint">No viewing requests yet.</td></tr>
            @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $viewings->links() }}</div>
    </x-panel>
</x-provider-layout>
