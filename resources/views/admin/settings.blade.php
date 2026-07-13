<x-admin-layout :title="__('admin.system_settings_title')">
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf @method('PUT')
        <div class="flex flex-col gap-3.5">
            <x-panel :title="__('admin.general')">
                <div class="grid grid-cols-3 gap-3.5">
                    <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">{{ __('admin.platform_name') }}</span><input name="settings[platform_name]" value="{{ $settings['platform_name'] ?? 'Keystone' }}" class="border border-line rounded-md px-2.5 py-2 text-sm"></label>
                    <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">{{ __('admin.default_currency') }}</span><input name="settings[currency]" value="{{ $settings['currency'] ?? 'SAR' }}" class="border border-line rounded-md px-2.5 py-2 text-sm"></label>
                    <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">{{ __('admin.default_tax_rate') }}</span><input name="settings[tax_rate]" value="{{ $settings['tax_rate'] ?? '15' }}" class="border border-line rounded-md px-2.5 py-2 text-sm"></label>
                    <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">{{ __('admin.default_commission_rate') }}</span><input name="settings[commission_rate]" value="{{ $settings['commission_rate'] ?? '2.0' }}" class="border border-line rounded-md px-2.5 py-2 text-sm"></label>
                    <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">{{ __('admin.support_email') }}</span><input name="settings[support_email]" value="{{ $settings['support_email'] ?? '' }}" class="border border-line rounded-md px-2.5 py-2 text-sm"></label>
                </div>
            </x-panel>
            <x-panel :title="__('admin.integrations')">
                <div class="flex flex-col gap-2.5">
                    <div class="grid grid-cols-[260px_1fr] items-center gap-2.5">
                        <span class="text-xs text-textmute">{{ __('admin.google_maps_key') }}</span>
                        <input name="settings[maps_key]" value="{{ $settings['maps_key'] ?? '' }}" class="border border-line rounded-md px-2.5 py-2 text-sm">
                    </div>
                    <div class="grid grid-cols-[260px_1fr] items-center gap-2.5">
                        <span class="text-xs text-textmute">{{ __('admin.fcm_key') }}</span>
                        <input name="settings[fcm_key]" value="{{ $settings['fcm_key'] ?? '' }}" class="border border-line rounded-md px-2.5 py-2 text-sm">
                    </div>
                    <div class="grid grid-cols-[260px_1fr] items-center gap-2.5">
                        <span class="text-xs text-textmute">{{ __('admin.payment_gateway_key') }}</span>
                        <input name="settings[payment_key]" value="{{ $settings['payment_key'] ?? '' }}" class="border border-line rounded-md px-2.5 py-2 text-sm">
                    </div>
                </div>
            </x-panel>
            <div class="flex justify-end"><button class="bg-ink text-white rounded-md px-3.5 py-2 text-xs font-semibold">{{ __('admin.save_settings') }}</button></div>
        </div>
    </form>
</x-admin-layout>
