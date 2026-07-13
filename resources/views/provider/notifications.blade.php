<x-provider-layout :title="__('dashboard.nav_notifications')">
    <x-panel :title="__('provider.notification_preferences')">
        <form action="{{ route('provider.notifications.update') }}" method="POST" class="flex flex-col gap-3">
            @csrf @method('PATCH')
            <table class="w-full text-sm">
                <thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2 px-2">{{ __('provider.event') }}</th><th class="pb-2 px-2 text-right">Push</th><th class="pb-2 px-2 text-right">Email</th><th class="pb-2 px-2 text-right">WhatsApp</th></tr></thead>
                <tbody>
                @foreach ($templates as $t)
                    @php $o = $overrides[$t->event_key] ?? ['push' => $t->push_enabled, 'email' => $t->email_enabled, 'whatsapp' => $t->whatsapp_enabled]; @endphp
                    <tr class="border-t border-linesoft">
                        <td class="py-2.5 px-2">{{ $t->label }}</td>
                        <td class="py-2.5 px-2 text-right"><x-toggle name="preferences[{{ $t->event_key }}][push]" :on="$o['push']" /></td>
                        <td class="py-2.5 px-2 text-right"><x-toggle name="preferences[{{ $t->event_key }}][email]" :on="$o['email']" /></td>
                        <td class="py-2.5 px-2 text-right"><x-toggle name="preferences[{{ $t->event_key }}][whatsapp]" :on="$o['whatsapp']" /></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="flex justify-end"><button class="bg-ink text-white rounded-md px-3.5 py-2 text-xs font-semibold">{{ __('provider.save_preferences') }}</button></div>
        </form>
    </x-panel>
</x-provider-layout>
