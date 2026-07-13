<x-admin-layout title="System settings">
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf @method('PUT')
        <div class="flex flex-col gap-3.5">
            <x-panel title="General">
                <div class="grid grid-cols-3 gap-3.5">
                    <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">Platform name</span><input name="settings[platform_name]" value="{{ $settings['platform_name'] ?? 'Keystone' }}" class="border border-line rounded-md px-2.5 py-2 text-sm"></label>
                    <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">Default currency</span><input name="settings[currency]" value="{{ $settings['currency'] ?? 'SAR' }}" class="border border-line rounded-md px-2.5 py-2 text-sm"></label>
                    <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">Default tax rate (%)</span><input name="settings[tax_rate]" value="{{ $settings['tax_rate'] ?? '15' }}" class="border border-line rounded-md px-2.5 py-2 text-sm"></label>
                    <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">Default commission rate (%)</span><input name="settings[commission_rate]" value="{{ $settings['commission_rate'] ?? '2.0' }}" class="border border-line rounded-md px-2.5 py-2 text-sm"></label>
                    <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">Support email</span><input name="settings[support_email]" value="{{ $settings['support_email'] ?? '' }}" class="border border-line rounded-md px-2.5 py-2 text-sm"></label>
                </div>
            </x-panel>
            <x-panel title="Integrations">
                <div class="flex flex-col gap-2.5">
                    <div class="grid grid-cols-[260px_1fr] items-center gap-2.5">
                        <span class="text-xs text-textmute">Google Maps API key</span>
                        <input name="settings[maps_key]" value="{{ $settings['maps_key'] ?? '' }}" class="border border-line rounded-md px-2.5 py-2 text-sm">
                    </div>
                    <div class="grid grid-cols-[260px_1fr] items-center gap-2.5">
                        <span class="text-xs text-textmute">Firebase Cloud Messaging key</span>
                        <input name="settings[fcm_key]" value="{{ $settings['fcm_key'] ?? '' }}" class="border border-line rounded-md px-2.5 py-2 text-sm">
                    </div>
                    <div class="grid grid-cols-[260px_1fr] items-center gap-2.5">
                        <span class="text-xs text-textmute">Payment gateway key</span>
                        <input name="settings[payment_key]" value="{{ $settings['payment_key'] ?? '' }}" class="border border-line rounded-md px-2.5 py-2 text-sm">
                    </div>
                </div>
            </x-panel>
            <div class="flex justify-end"><button class="bg-ink text-white rounded-md px-3.5 py-2 text-xs font-semibold">Save settings</button></div>
        </div>
    </form>
</x-admin-layout>
