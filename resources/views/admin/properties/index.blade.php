<x-admin-layout :title="__('admin.properties_title')">
    <x-panel :title="__('admin.properties_title')">
        <div class="flex gap-1.5 mb-3.5 flex-wrap">
            <x-pill-button :href="route('admin.properties.index')" :active="!request('status')">{{ __('common.all') }}</x-pill-button>
            @foreach (['draft','pending','published','sold','rented','expired','rejected'] as $s)
                <x-pill-button :href="route('admin.properties.index', ['status' => $s])" :active="request('status') === $s">{{ __('status.'.$s) }}</x-pill-button>
            @endforeach
        </div>
        <table class="w-full text-sm">
            <thead><tr class="text-[11px] uppercase text-textfaint"><th class="pb-2 px-2">{{ __('provider.id') }}</th><th class="pb-2 px-2">{{ __('admin.title_col') }}</th><th class="pb-2 px-2">{{ __('common.city') }}</th><th class="pb-2 px-2">{{ __('admin.provider_col') }}</th><th class="pb-2 px-2">{{ __('common.status') }}</th><th class="pb-2 px-2">{{ __('common.actions') }}</th></tr></thead>
            <tbody>
            @forelse ($properties as $p)
                <tr class="border-t border-linesoft">
                    <td class="py-2.5 px-2 font-mono text-xs">PR-{{ $p->id }}</td>
                    <td class="py-2.5 px-2">{{ $p->title }}</td>
                    <td class="py-2.5 px-2">{{ $p->city->name }}</td>
                    <td class="py-2.5 px-2">{{ $p->serviceProvider->office_name }}</td>
                    <td class="py-2.5 px-2"><x-badge :status="ucfirst($p->status)" /></td>
                    <td class="py-2.5 px-2">
                        <div class="flex items-center gap-1.5 flex-wrap">
                            <x-action-pill :href="route('admin.properties.show', $p)">{{ __('admin.view_details') }}</x-action-pill>
                            <x-action-pill :href="route('admin.properties.photos', $p)">{{ __('admin.manage_photos') }}</x-action-pill>
                            @if ($p->status === 'pending')
                            <form action="{{ route('admin.properties.approve', $p) }}" method="POST">@csrf<x-action-pill tone="success">{{ __('admin.approve') }}</x-action-pill></form>
                            <form action="{{ route('admin.properties.reject', $p) }}" method="POST" onsubmit="return promptReject(this)">@csrf<input type="hidden" name="reason" value=""><x-action-pill tone="danger">{{ __('admin.reject') }}</x-action-pill></form>
                            @endif
                        </div>
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
