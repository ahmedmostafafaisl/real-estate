<x-provider-layout title="Employees">
    <div class="flex flex-col gap-3.5">
        <x-panel title="Add employee">
            <form action="{{ route('provider.employees.store') }}" method="POST" class="grid grid-cols-4 gap-3">
                @csrf
                <input name="name" placeholder="Full name" required class="border border-line rounded-md px-2.5 py-2 text-sm">
                <input name="job_title" placeholder="Job title" class="border border-line rounded-md px-2.5 py-2 text-sm">
                <input name="email" type="email" placeholder="Email" class="border border-line rounded-md px-2.5 py-2 text-sm">
                <button class="bg-ink text-white rounded-md px-3.5 py-2 text-xs font-semibold">Add employee</button>
            </form>
        </x-panel>
        <x-panel title="Employees">
            <table class="w-full text-sm">
                <thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2 px-2">Name</th><th class="pb-2 px-2">Job title</th><th class="pb-2 px-2">Email</th><th class="pb-2 px-2">Status</th><th class="pb-2 px-2"></th></tr></thead>
                <tbody>
                @forelse ($employees as $e)
                    <tr class="border-t border-linesoft">
                        <td class="py-2.5 px-2">{{ $e->name }}</td>
                        <td class="py-2.5 px-2">{{ $e->job_title }}</td>
                        <td class="py-2.5 px-2">{{ $e->email }}</td>
                        <td class="py-2.5 px-2"><x-badge :status="$e->is_active ? 'Active' : 'Draft'" /></td>
                        <td class="py-2.5 px-2 text-right">
                            <form action="{{ route('provider.employees.destroy', $e) }}" method="POST" onsubmit="return confirm('Remove this employee?')">@csrf @method('DELETE')<button class="text-kdanger text-xs font-semibold">Remove</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-6 text-center text-textfaint">No employees added yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </x-panel>
    </div>
</x-provider-layout>
