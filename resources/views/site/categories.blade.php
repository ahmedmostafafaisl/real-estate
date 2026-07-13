<x-site-layout title="Property categories — Keystone">
    <div class="max-w-6xl mx-auto px-6 py-10">
        <h1 class="font-serif text-3xl mb-6">Property categories</h1>
        <div class="flex flex-col gap-6">
            @foreach ($categories as $c)
                <div class="bg-white border border-line rounded-xl p-5">
                    <div class="flex items-center justify-between mb-3">
                        <div class="font-serif text-xl">{{ $c->name }}</div>
                        <span class="text-xs text-textfaint">{{ $c->properties_count }} listings</span>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @foreach ($c->types as $t)
                            <a href="{{ route('properties.index', ['property_type_id' => $t->id]) }}" class="border border-line rounded-md px-3 py-2 text-sm hover:border-brass">
                                {{ $t->name }} <span class="text-textfaint text-xs">({{ $t->properties_count }})</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-site-layout>
