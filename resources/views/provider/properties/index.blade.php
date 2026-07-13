<x-provider-layout title="My properties">
    <x-panel title="My properties">
        <x-slot:action>
            <a href="{{ route('provider.properties.create') }}" class="bg-ink text-white text-xs font-semibold rounded-md px-3.5 py-2 inline-flex items-center gap-1.5">+ New listing</a>
        </x-slot:action>

        <div class="flex gap-1.5 mb-3.5 flex-wrap">
            <x-pill-button :href="route('provider.properties.index')" :active="!request('status')">All</x-pill-button>
            @foreach (['Draft','Pending','Published','Sold','Rented','Expired'] as $s)
                <x-pill-button :href="route('provider.properties.index', ['status' => $s])" :active="request('status') === $s">{{ $s }}</x-pill-button>
            @endforeach
        </div>

        <table class="w-full text-sm">
            <thead>
                <tr class="text-[11px] uppercase text-textfaint text-left">
                    <th class="pb-2 px-2">ID</th><th class="pb-2 px-2">Listing</th><th class="pb-2 px-2">City</th>
                    <th class="pb-2 px-2 text-right">Price</th><th class="pb-2 px-2 text-right">Views</th>
                    <th class="pb-2 px-2">Lifecycle</th><th class="pb-2 px-2">Status</th><th class="pb-2 px-2"></th>
                </tr>
            </thead>
            <tbody>
            @forelse ($properties as $p)
                <tr class="border-t border-linesoft">
                    <td class="py-2.5 px-2 font-mono text-xs">PR-{{ $p->id }}</td>
                    <td class="py-2.5 px-2">{{ $p->title }}</td>
                    <td class="py-2.5 px-2">{{ $p->city->name }}</td>
                    <td class="py-2.5 px-2 text-right">SAR {{ number_format($p->price) }}</td>
                    <td class="py-2.5 px-2 text-right">{{ $p->views_count }}</td>
                    <td class="py-2.5 px-2"><x-lifecycle-arch :status="ucfirst($p->status)" /></td>
                    <td class="py-2.5 px-2"><x-badge :status="ucfirst($p->status)" /></td>
                    <td class="py-2.5 px-2 text-right whitespace-nowrap">
                        <a href="{{ route('provider.properties.edit', $p) }}" class="text-textmute text-xs font-semibold mr-2">Edit</a>
                        @if ($p->status === 'draft')
                            <form action="{{ route('provider.properties.submit', $p) }}" method="POST" class="inline"><input type="hidden" name="_token" value="{{ csrf_token() }}"><button class="text-teal text-xs font-semibold mr-2">Submit</button></form>
                        @elseif ($p->status === 'published')
                            <form action="{{ route('provider.properties.pause', $p) }}" method="POST" class="inline">@csrf<button class="text-kwarning text-xs font-semibold mr-2">Pause</button></form>
                        @endif
                        <form action="{{ route('provider.properties.destroy', $p) }}" method="POST" class="inline" onsubmit="return confirm('Delete this listing?')">@csrf @method('DELETE')<button class="text-kdanger text-xs font-semibold">Delete</button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="py-6 text-center text-textfaint">No listings yet — create your first one.</td></tr>
            @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $properties->links() }}</div>
    </x-panel>
</x-provider-layout>
