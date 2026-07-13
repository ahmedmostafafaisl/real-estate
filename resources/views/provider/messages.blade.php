<x-provider-layout :title="__('provider.messages')">
    <div class="grid grid-cols-[260px_1fr] gap-3.5" x-data="{ active: 0 }">
        <x-panel :title="__('provider.messages')">
            <div class="flex flex-col gap-0.5">
                @forelse ($threads as $i => $t)
                    <button @click="active = {{ $i }}" :class="active === {{ $i }} ? 'bg-canvas' : ''" class="text-left p-2 rounded-md">
                        <div class="flex justify-between"><span class="text-sm font-semibold">{{ $t->user->name }}</span><span class="text-[11px] text-textfaint">{{ $t->created_at->diffForHumans() }}</span></div>
                        <div class="text-xs text-textmute truncate">{{ $t->message }}</div>
                    </button>
                @empty
                    <div class="text-textfaint text-sm p-2">{{ __('provider.no_conversations_yet') }}</div>
                @endforelse
            </div>
        </x-panel>
        <x-panel :title="__('provider.conversation')">
            <div class="flex flex-col gap-2.5 min-h-[200px]">
                @foreach ($threads as $i => $t)
                    <div x-show="active === {{ $i }}" x-cloak class="self-start bg-canvas rounded-lg px-3 py-2 max-w-[70%] text-sm">{{ $t->message }}</div>
                @endforeach
            </div>
            <div class="flex gap-2 mt-3.5">
                <input placeholder="{{ __('provider.write_message_placeholder') }}" class="flex-1 border border-line rounded-md px-2.5 py-2 text-sm">
                <button class="bg-ink text-white rounded-md px-3.5 py-2 text-xs font-semibold">{{ __('provider.send') }}</button>
            </div>
        </x-panel>
    </div>
</x-provider-layout>
