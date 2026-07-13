<x-site-layout :title="__('site.register_business_title')">
    <div class="max-w-lg mx-auto px-6 py-14">
        <h1 class="font-serif text-3xl mb-2">{{ __('site.register_business_title') }}</h1>
        <p class="text-textmute mb-6 text-sm">{{ __('site.register_business_subtitle') }}</p>

        @if ($errors->any())<div class="bg-dangersoft text-kdanger text-sm rounded-md px-3 py-2 mb-4">{{ $errors->first() }}</div>@endif

        <form action="{{ route('register.provider.store') }}" method="POST" class="bg-white border border-line rounded-xl p-6 flex flex-col gap-3.5">
            @csrf
            <div class="grid grid-cols-2 gap-3.5">
                <input name="name" value="{{ old('name') }}" placeholder="{{ __('site.full_name') }}" required class="border border-line rounded-md px-3 py-2.5 text-sm">
                <input name="phone" value="{{ old('phone') }}" placeholder="{{ __('common.phone') }}" required class="border border-line rounded-md px-3 py-2.5 text-sm">
            </div>
            <input name="email" type="email" value="{{ old('email') }}" placeholder="{{ __('common.email') }}" required class="border border-line rounded-md px-3 py-2.5 text-sm">
            <div class="grid grid-cols-2 gap-3.5">
                <input name="password" type="password" placeholder="{{ __('common.password') }}" required class="border border-line rounded-md px-3 py-2.5 text-sm">
                <input name="password_confirmation" type="password" placeholder="{{ __('common.confirm_password') }}" required class="border border-line rounded-md px-3 py-2.5 text-sm">
            </div>
            <hr class="border-line my-1">
            <input name="office_name" value="{{ old('office_name') }}" placeholder="{{ __('site.office_name') }}" required class="border border-line rounded-md px-3 py-2.5 text-sm">
            <div class="grid grid-cols-2 gap-3.5">
                <select name="provider_type" required class="border border-line rounded-md px-3 py-2.5 text-sm">
                    <option value="">{{ __('site.business_type') }}</option>
                    @foreach (['agency','broker','owner','developer'] as $t)<option value="{{ $t }}">{{ __('common.'.$t) }}</option>@endforeach
                </select>
                <select name="city_id" required class="border border-line rounded-md px-3 py-2.5 text-sm">
                    <option value="">{{ __('common.city') }}</option>
                    @foreach ($cities as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
                </select>
            </div>
            <input name="commercial_register_no" value="{{ old('commercial_register_no') }}" placeholder="{{ __('site.commercial_register_optional') }}" class="border border-line rounded-md px-3 py-2.5 text-sm">
            <button class="bg-ink text-white rounded-md py-2.5 text-sm font-semibold">{{ __('site.submit_application') }}</button>
        </form>
    </div>
</x-site-layout>
