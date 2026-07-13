<x-admin-layout :title="__('admin.properties_title')">
    <x-panel :title="__('admin.properties_title')">
        <div class="flex gap-1.5 mb-3.5 flex-wrap">
            <x-pill-button :href="route('admin.properties.index')" :active="!request('status')">{{ __('common.all') }}</x-pill-button>
            @foreach (['draft','pending','published','sold','rented','expired','rejected'] as $s)
                <x-pill-button :href="route('admin.properties.index', ['status' => $s])" :active="request('status') === $s">{{ __('status.'.$s) }}</x-pill-button>
            @endforeach
        </div>
        <table class="w-full text-sm">
            <thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2 px-2">{{ __('provider.id') }}</th><th class="pb-2 px-2">{{ __('admin.title_col') }}</th><th class="pb-2 px-2">{{ __('common.city') }}</th><th class="pb-2 px-2">{{ __('admin.provider_col') }}</th><th class="pb-2 px-2">{{ __('common.status') }}</th><th class="pb-2 px-2"></th></tr></thead>
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
                        <form action="{{ route('admin.properties.approve', $p) }}" method="POST" class="inline">@csrf<button class="text-ksuccess text-xs font-semibold ms-2">{{ __('admin.approve') }}</button></form>
                        <form action="{{ route('admin.properties.reject', $p) }}" method="POST" class="inline" onsubmit="return promptReject(this)">@csrf<input type="hidden" name="reason" value=""><button class="text-kdanger text-xs font-semibold">{{ __('admin.reject') }}</button></form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="py-6 text-center text-textfaint">{{ __('admin.no_properties_found') }}</td></tr>
            @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $properties->links() }}</div>
    </x-panel>
    <script>
        function promptReject(form) {
            const reason = prompt('{{ __('admin.reason_for_rejection') }}');
            if (!reason) return false;
            form.querySelector('[name=reason]').value = reason;
            return true;
        }
    </script>
</x-admin-layout>
