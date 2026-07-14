<x-admin-layout :title="__('admin.photos_for', ['title' => $property->title])">
    <x-panel :title="__('admin.photos_for', ['title' => $property->title])">
        <x-slot:action>
            <a href="{{ route('admin.properties.index') }}" class="text-xs font-semibold text-textmute">← {{ __('admin.back_to_properties') }}</a>
        </x-slot:action>

        @if ($property->images->isEmpty())
            <p class="text-sm text-textfaint py-6 text-center">{{ __('provider.no_photos_yet') }}</p>
        @else
            <div class="grid grid-cols-4 gap-3">
                @foreach ($property->images as $image)
                    <div class="relative border border-line rounded-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $image->path) }}" alt="" class="w-full h-32 object-cover">
                        @if ($image->is_featured)
                            <span class="absolute top-1.5 start-1.5 bg-brass text-white text-[10px] font-semibold px-2 py-0.5 rounded-full">{{ __('provider.featured_photo') }}</span>
                        @endif
                        <form action="{{ route('admin.properties.photos.destroy', [$property, $image]) }}" method="POST"
                              class="absolute inset-x-0 bottom-0 bg-black/55 p-1.5"
                              onsubmit="return confirm('{{ __('provider.remove_photo') }}?')">
                            @csrf @method('DELETE')
                            <button class="text-[11px] text-white font-semibold w-full text-center">{{ __('provider.remove_photo') }}</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </x-panel>
</x-admin-layout>
