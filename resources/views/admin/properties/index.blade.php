<x-admin-layout title="Properties">
    <x-panel title="Properties">
        <div class="flex gap-1.5 mb-3.5 flex-wrap">
            <x-pill-button :href="route('admin.properties.index')" :active="!request('status')">All</x-pill-button>
            @foreach (['draft','pending','published','sold','rented','expired','rejected'] as $s)
                <x-pill-button :href="route('admin.properties.index', ['status' => $s])" :active="request('status') === $s">{{ ucfirst($s) }}</x-pill-button>
            @endforeach
        </div>
        <table class="w-full text-sm">
            <thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2 px-2">ID</th><th class="pb-2 px-2">Title</th><th class="pb-2 px-2">City</th><th class="pb-2 px-2">Provider</th><th class="pb-2 px-2">Status</th><th class="pb-2 px-2"></th></tr></thead>
            <tbody>
            @forelse ($properties as $p)
                <tr class="border-t border-linesoft">
                    <td class="py-2.5 px-2 font-mono text-xs">PR-{{ $p->id }}</td>
                    <td class="py-2.5 px-2">{{ $p->title }}</td>
                    <td class="py-2.5 px-2">{{ $p->city->name }}</td>
                    <td class="py-2.5 px-2">{{ $p->serviceProvider->office_name }}</td>
                    <td class="py-2.5 px-2"><x-badge :status="ucfirst($p->status)" /></td>
                    <td class="py-2.5 px-2 text-right whitespace-nowrap">
                        @if ($p->status === 'pending')
                        <form action="{{ route('admin.properties.approve', $p) }}" method="POST" class="inline">@csrf<button class="text-ksuccess text-xs font-semibold mr-2">Approve</button></form>
                        <form action="{{ route('admin.properties.reject', $p) }}" method="POST" class="inline" onsubmit="return promptReject(this)">@csrf<input type="hidden" name="reason" value=""><button class="text-kdanger text-xs font-semibold">Reject</button></form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="py-6 text-center text-textfaint">No properties found.</td></tr>
            @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $properties->links() }}</div>
    </x-panel>
    <script>
        function promptReject(form) {
            const reason = prompt('Reason for rejection:');
            if (!reason) return false;
            form.querySelector('[name=reason]').value = reason;
            return true;
        }
    </script>
</x-admin-layout>
