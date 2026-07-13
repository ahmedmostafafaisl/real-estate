<x-provider-layout :title="__('provider.viewing_appointments')">
    <x-panel :title="__('provider.viewing_appointments')">
        <table class="w-full text-sm">
            <thead><tr class="text-[11px] uppercase text-textfaint text-left">
                <th class="pb-2 px-2">{{ __('provider.customer') }}</th><th class="pb-2 px-2">{{ __('provider.property') }}</th><th class="pb-2 px-2">{{ __('provider.slot') }}</th>
                <th class="pb-2 px-2">{{ __('common.status') }}</th><th class="pb-2 px-2"></th>
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
                            <form action="{{ route('provider.viewings.update', $v) }}" method="POST" class="inline">@csrf @method('PATCH')<input type="hidden" name="status" value="confirmed"><button class="text-ksuccess text-xs font-semibold ms-2">{{ __('provider.confirm') }}</button></form>
                            <form action="{{ route('provider.viewings.update', $v) }}" method="POST" class="inline">@csrf @method('PATCH')<input type="hidden" name="status" value="cancelled"><button class="text-kdanger text-xs font-semibold">{{ __('provider.decline') }}</button></form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="py-6 text-center text-textfaint">{{ __('provider.no_viewing_requests_yet') }}</td></tr>
            @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $viewings->links() }}</div>
    </x-panel>
</x-provider-layout>
