<x-admin-layout title="Customers">
    <x-panel title="Customers">
        <table class="w-full text-sm">
            <thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2 px-2">Name</th><th class="pb-2 px-2">Email</th><th class="pb-2 px-2 text-right">Favorites</th><th class="pb-2 px-2">Status</th><th class="pb-2 px-2"></th></tr></thead>
            <tbody>
            @forelse ($users as $u)
                <tr class="border-t border-linesoft">
                    <td class="py-2.5 px-2">{{ $u->name }}</td>
                    <td class="py-2.5 px-2">{{ $u->email }}</td>
                    <td class="py-2.5 px-2 text-right">{{ $u->favorites_count }}</td>
                    <td class="py-2.5 px-2"><x-badge :status="$u->is_active ? 'Active' : 'Rejected'" /></td>
                    <td class="py-2.5 px-2 text-right">
                        <form action="{{ route('admin.users.toggle', $u) }}" method="POST">@csrf<button class="text-xs font-semibold {{ $u->is_active ? 'text-kdanger' : 'text-ksuccess' }}">{{ $u->is_active ? 'Suspend' : 'Activate' }}</button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="py-6 text-center text-textfaint">No customers yet.</td></tr>
            @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $users->links() }}</div>
    </x-panel>
</x-admin-layout>
