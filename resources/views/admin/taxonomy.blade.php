<x-admin-layout title="Categories & types">
    <div class="flex flex-col gap-3.5">
        <x-panel title="Categories">
            <x-slot:action>
                <form action="{{ route('admin.taxonomy.categories.store') }}" method="POST" class="flex gap-1.5">@csrf
                    <input name="name" placeholder="New category" required class="border border-line rounded-md px-2.5 py-1.5 text-xs">
                    <button class="bg-ink text-white rounded-md px-3 py-1.5 text-xs font-semibold">Add</button>
                </form>
            </x-slot:action>
            <table class="w-full text-sm"><thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2">Category</th><th class="pb-2 text-right">Types</th><th class="pb-2 text-right">Listings</th></tr></thead><tbody>
                @foreach ($categories as $c)
                    <tr class="border-t border-linesoft"><td class="py-2.5">{{ $c->name }}</td><td class="py-2.5 text-right">{{ $c->types->count() }}</td><td class="py-2.5 text-right">{{ $c->properties_count }}</td></tr>
                @endforeach
            </tbody></table>
        </x-panel>
        <x-panel title="Property types">
            <x-slot:action>
                <form action="{{ route('admin.taxonomy.types.store') }}" method="POST" class="flex gap-1.5">@csrf
                    <select name="property_category_id" class="border border-line rounded-md px-2 py-1.5 text-xs">
                        @foreach ($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
                    </select>
                    <input name="name" placeholder="New type" required class="border border-line rounded-md px-2.5 py-1.5 text-xs">
                    <button class="bg-ink text-white rounded-md px-3 py-1.5 text-xs font-semibold">Add</button>
                </form>
            </x-slot:action>
            <table class="w-full text-sm"><thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2">Type</th><th class="pb-2">Category</th><th class="pb-2 text-right">Listings</th></tr></thead><tbody>
                @foreach ($types as $t)
                    <tr class="border-t border-linesoft"><td class="py-2.5">{{ $t->name }}</td><td class="py-2.5">{{ $t->category->name }}</td><td class="py-2.5 text-right">{{ $t->properties_count }}</td></tr>
                @endforeach
            </tbody></table>
        </x-panel>
        <x-panel title="Property features">
            <x-slot:action>
                <form action="{{ route('admin.taxonomy.features.store') }}" method="POST" class="flex gap-1.5">@csrf
                    <input name="name" placeholder="New feature" required class="border border-line rounded-md px-2.5 py-1.5 text-xs">
                    <button class="bg-ink text-white rounded-md px-3 py-1.5 text-xs font-semibold">Add</button>
                </form>
            </x-slot:action>
            <div class="flex flex-wrap gap-2">
                @foreach ($features as $f)<span class="text-xs border border-line rounded-full px-3 py-1.5">{{ $f->name }}</span>@endforeach
            </div>
        </x-panel>
    </div>
</x-admin-layout>
