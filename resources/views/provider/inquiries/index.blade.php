<x-provider-layout title="Customer requests">
    <x-panel title="Customer requests">
        <table class="w-full text-sm">
            <thead><tr class="text-[11px] uppercase text-textfaint text-left">
                <th class="pb-2 px-2">Customer</th><th class="pb-2 px-2">Property</th><th class="pb-2 px-2">Message</th>
                <th class="pb-2 px-2">Date</th><th class="pb-2 px-2">Status</th><th class="pb-2 px-2"></th>
            </tr></thead>
            <tbody>
            @forelse ($inquiries as $i)
                <tr class="border-t border-linesoft">
                    <td class="py-2.5 px-2">{{ $i->user->name }}</td>
                    <td class="py-2.5 px-2">{{ $i->property->title }}</td>
                    <td class="py-2.5 px-2 text-textmute">{{ $i->message }}</td>
                    <td class="py-2.5 px-2">{{ $i->created_at->format('M j') }}</td>
                    <td class="py-2.5 px-2"><x-badge :status="ucfirst($i->status)" /></td>
                    <td class="py-2.5 px-2 text-right">
                        @if ($i->status === 'new')
                            <form action="{{ route('provider.inquiries.respond', $i) }}" method="POST">@csrf<button class="border border-line rounded-md px-2.5 py-1 text-xs font-semibold">Respond</button></form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="py-6 text-center text-textfaint">No customer requests yet.</td></tr>
            @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $inquiries->links() }}</div>
    </x-panel>
</x-provider-layout>
