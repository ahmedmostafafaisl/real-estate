<x-provider-layout :title="__('provider.customer_requests')">
    <x-panel :title="__('provider.customer_requests')">
        <table class="w-full text-sm">
            <thead><tr class="text-[11px] uppercase text-textfaint text-left">
                <th class="pb-2 px-2">{{ __('provider.customer') }}</th><th class="pb-2 px-2">{{ __('provider.property') }}</th><th class="pb-2 px-2">{{ __('provider.message') }}</th>
                <th class="pb-2 px-2">{{ __('provider.date') }}</th><th class="pb-2 px-2">{{ __('common.status') }}</th><th class="pb-2 px-2"></th>
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
                            <form action="{{ route('provider.inquiries.respond', $i) }}" method="POST">@csrf<button class="border border-line rounded-md px-2.5 py-1 text-xs font-semibold">{{ __('provider.respond') }}</button></form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="py-6 text-center text-textfaint">{{ __('provider.no_requests_yet') }}</td></tr>
            @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $inquiries->links() }}</div>
    </x-panel>
</x-provider-layout>
