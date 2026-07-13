<x-admin-layout :title="__('admin.notifications_title')">
    <x-panel :title="__('admin.notification_templates')">
        <table class="w-full text-sm">
            <thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2 px-2">{{ __('admin.event_col') }}</th><th class="pb-2 px-2 text-right">Push</th><th class="pb-2 px-2 text-right">Email</th><th class="pb-2 px-2 text-right">SMS</th><th class="pb-2 px-2 text-right">WhatsApp</th></tr></thead>
            <tbody>
            @foreach ($templates as $t)
                <tr class="border-t border-linesoft">
                    <td class="py-2.5 px-2">{{ $t->label }}</td>
                    <td class="py-2.5 px-2 text-right"><input form="notif-{{ $t->id }}" type="checkbox" name="push_enabled" value="1" onchange="this.form.requestSubmit()" @checked($t->push_enabled)></td>
                    <td class="py-2.5 px-2 text-right"><input form="notif-{{ $t->id }}" type="checkbox" name="email_enabled" value="1" onchange="this.form.requestSubmit()" @checked($t->email_enabled)></td>
                    <td class="py-2.5 px-2 text-right"><input form="notif-{{ $t->id }}" type="checkbox" name="sms_enabled" value="1" onchange="this.form.requestSubmit()" @checked($t->sms_enabled)></td>
                    <td class="py-2.5 px-2 text-right"><input form="notif-{{ $t->id }}" type="checkbox" name="whatsapp_enabled" value="1" onchange="this.form.requestSubmit()" @checked($t->whatsapp_enabled)></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @foreach ($templates as $t)
            <form action="{{ route('admin.notifications.update', $t) }}" method="POST" id="notif-{{ $t->id }}" class="hidden">@csrf @method('PATCH')</form>
        @endforeach
    </x-panel>
</x-admin-layout>
