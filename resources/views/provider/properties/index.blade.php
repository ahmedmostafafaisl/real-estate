<x-provider-layout :title="__('provider.my_properties')">
    <x-panel :title="__('provider.my_properties')">
        <x-slot:action>
            <a href="{{ route('provider.properties.create') }}" class="bg-ink text-white text-xs font-semibold rounded-md px-3.5 py-2 inline-flex items-center gap-1.5">+ {{ __('provider.new_listing') }}</a>
        </x-slot:action>

        <div class="flex gap-1.5 mb-3.5 flex-wrap">
            <x-pill-button :href="route('provider.properties.index')" :active="!request('status')">{{ __('common.all') }}</x-pill-button>
            @foreach (['Draft','Pending','Published','Sold','Rented','Expired'] as $s)
                <x-pill-button :href="route('provider.properties.index', ['status' => $s])" :active="request('status') === $s">{{ __('status.'.strtolower($s)) }}</x-pill-button>
            @endforeach
        </div>

        <table class="w-full text-sm">
            <thead>
                <tr class="text-[11px] uppercase text-textfaint">
                    <th class="pb-2 px-2">{{ __('provider.id') }}</th><th class="pb-2 px-2">{{ __('provider.listing') }}</th><th class="pb-2 px-2">{{ __('common.city') }}</th>
                    <th class="pb-2 px-2 text-right">{{ __('common.price') }}</th><th class="pb-2 px-2 text-right">{{ __('provider.views') }}</th>
                    <th class="pb-2 px-2">{{ __('provider.lifecycle') }}</th><th class="pb-2 px-2">{{ __('common.status') }}</th><th class="pb-2 px-2">{{ __('common.actions') }}</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($properties as $p)
                <tr class="border-t border-linesoft">
                    <td class="py-2.5 px-2 font-mono text-xs">PR-{{ $p->id }}</td>
                    <td class="py-2.5 px-2">{{ $p->title }}</td>
                    <td class="py-2.5 px-2">{{ $p->city->name }}</td>
                    <td class="py-2.5 px-2 text-right">{{ __('common.currency') }} {{ number_format($p->price) }}</td>
                    <td class="py-2.5 px-2 text-right">{{ $p->views_count }}</td>
                    <td class="py-2.5 px-2"><x-lifecycle-arch :status="ucfirst($p->status)" /></td>
                    <td class="py-2.5 px-2"><x-badge :status="ucfirst($p->status)" /></td>
                    <td class="py-2.5 px-2">
                        <div class="flex items-center gap-1.5 flex-wrap">
                            <x-action-pill :href="route('provider.properties.edit', $p)">{{ __('common.edit') }}</x-action-pill>
                            @if ($p->status === 'draft')
                                <form action="{{ route('provider.properties.submit', $p) }}" method="POST">@csrf<x-action-pill tone="info">{{ __('provider.submit') }}</x-action-pill></form>
                            @elseif ($p->status === 'published')
                                <form action="{{ route('provider.properties.pause', $p) }}" method="POST">@csrf<x-action-pill tone="warning">{{ __('provider.pause') }}</x-action-pill></form>
                            @endif
                            <form action="{{ route('provider.properties.destroy', $p) }}" method="POST" onsubmit="return confirm('{{ __('provider.confirm_delete_listing') }}')">@csrf @method('DELETE')<x-action-pill tone="danger">{{ __('common.delete') }}</x-action-pill></form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="py-6 text-center text-textfaint">{{ __('provider.no_listings_yet') }}</td></tr>
            @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $properties->links() }}</div>
    </x-panel>
</x-provider-layout>
