<x-provider-layout :title="__('dashboard.nav_employees')">
    <div class="flex flex-col gap-3.5">
        <x-panel :title="__('provider.add_employee')">
            <form action="{{ route('provider.employees.store') }}" method="POST" class="grid grid-cols-4 gap-3">
                @csrf
                <input name="name" placeholder="{{ __('provider.full_name') }}" required class="border border-line rounded-md px-2.5 py-2 text-sm">
                <input name="job_title" placeholder="{{ __('provider.job_title') }}" class="border border-line rounded-md px-2.5 py-2 text-sm">
                <input name="email" type="email" placeholder="{{ __('common.email') }}" class="border border-line rounded-md px-2.5 py-2 text-sm">
                <button class="bg-ink text-white rounded-md px-3.5 py-2 text-xs font-semibold">{{ __('provider.add_employee') }}</button>
            </form>
        </x-panel>
        <x-panel :title="__('dashboard.nav_employees')">
            <table class="w-full text-sm">
                <thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2 px-2">{{ __('common.name') }}</th><th class="pb-2 px-2">{{ __('provider.job_title') }}</th><th class="pb-2 px-2">{{ __('common.email') }}</th><th class="pb-2 px-2">{{ __('common.status') }}</th><th class="pb-2 px-2"></th></tr></thead>
                <tbody>
                @forelse ($employees as $e)
                    <tr class="border-t border-linesoft">
                        <td class="py-2.5 px-2">{{ $e->name }}</td>
                        <td class="py-2.5 px-2">{{ $e->job_title }}</td>
                        <td class="py-2.5 px-2">{{ $e->email }}</td>
                        <td class="py-2.5 px-2"><x-badge :status="$e->is_active ? 'Active' : 'Inactive'" /></td>
                        <td class="py-2.5 px-2 text-right">
                            <form action="{{ route('provider.employees.destroy', $e) }}" method="POST" onsubmit="return confirm('{{ __('provider.confirm_remove_employee') }}')">@csrf @method('DELETE')<button class="text-kdanger text-xs font-semibold">{{ __('provider.remove') }}</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-6 text-center text-textfaint">{{ __('provider.no_employees_yet') }}</td></tr>
                @endforelse
                </tbody>
            </table>
        </x-panel>
    </div>
</x-provider-layout>
