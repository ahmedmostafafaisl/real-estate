<x-admin-layout :title="__('admin.customers_title')">
    <x-panel :title="__('admin.customers_title')">
        <table class="w-full text-sm">
            <thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2 px-2">{{ __('admin.name_col') }}</th><th class="pb-2 px-2">{{ __('admin.email_col') }}</th><th class="pb-2 px-2 text-right">{{ __('admin.favorites_col') }}</th><th class="pb-2 px-2">{{ __('common.status') }}</th><th class="pb-2 px-2"></th></tr></thead>
            <tbody>
            @forelse ($users as $u)
                <tr class="border-t border-linesoft">
                    <td class="py-2.5 px-2">{{ $u->name }}</td>
                    <td class="py-2.5 px-2">{{ $u->email }}</td>
                    <td class="py-2.5 px-2 text-right">{{ $u->favorites_count }}</td>
                    <td class="py-2.5 px-2"><x-badge :status="$u->is_active ? 'Active' : 'Inactive'" /></td>
                    <td class="py-2.5 px-2 text-right">
                        <form action="{{ route('admin.users.toggle', $u) }}" method="POST">@csrf<button class="text-xs font-semibold {{ $u->is_active ? 'text-kdanger' : 'text-ksuccess' }}">{{ $u->is_active ? __('admin.suspend') : __('admin.activate') }}</button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="py-6 text-center text-textfaint">{{ __('admin.no_customers_yet') }}</td></tr>
            @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $users->links() }}</div>
    </x-panel>
</x-admin-layout>
