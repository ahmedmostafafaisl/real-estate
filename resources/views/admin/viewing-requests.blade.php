<x-admin-layout :title="__('admin.viewing_requests_title')">
    <x-panel :title="__('admin.viewing_requests_title')">
        <table class="w-full text-sm">
            <thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2 px-2">{{ __('admin.property_col') }}</th><th class="pb-2 px-2">{{ __('admin.customer_col') }}</th><th class="pb-2 px-2">{{ __('admin.provider_col') }}</th><th class="pb-2 px-2">{{ __('admin.slot_col') }}</th><th class="pb-2 px-2">{{ __('common.status') }}</th></tr></thead>
            <tbody>
            @forelse ($viewings as $v)
                <tr class="border-t border-linesoft">
                    <td class="py-2.5 px-2">{{ $v->property->title }}</td>
                    <td class="py-2.5 px-2">{{ $v->user->name }}</td>
                    <td class="py-2.5 px-2">{{ $v->serviceProvider->office_name }}</td>
                    <td class="py-2.5 px-2">{{ $v->requested_slot->format('M j, g:ia') }}</td>
                    <td class="py-2.5 px-2"><x-badge :status="ucfirst($v->status)" /></td>
                </tr>
            @empty
                <tr><td colspan="5" class="py-6 text-center text-textfaint">{{ __('admin.no_viewing_requests_yet') }}</td></tr>
            @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $viewings->links() }}</div>
    </x-panel>
</x-admin-layout>
