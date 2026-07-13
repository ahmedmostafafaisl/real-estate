<x-site-layout :title="__('site.create_account_title')">
    <div class="max-w-md mx-auto px-6 py-14">
        <h1 class="font-serif text-3xl mb-2">{{ __('site.create_account_title') }}</h1>
        <p class="text-textmute mb-6 text-sm">{{ __('site.create_account_subtitle') }}</p>

        @if ($errors->any())<div class="bg-dangersoft text-kdanger text-sm rounded-md px-3 py-2 mb-4">{{ $errors->first() }}</div>@endif

        <form action="{{ route('register.store') }}" method="POST" class="bg-white border border-line rounded-xl p-6 flex flex-col gap-3.5">
            @csrf
            <input name="name" value="{{ old('name') }}" placeholder="{{ __('site.full_name') }}" required class="border border-line rounded-md px-3 py-2.5 text-sm">
            <input name="email" type="email" value="{{ old('email') }}" placeholder="{{ __('common.email') }}" required class="border border-line rounded-md px-3 py-2.5 text-sm">
            <input name="phone" value="{{ old('phone') }}" placeholder="{{ __('site.phone_optional') }}" class="border border-line rounded-md px-3 py-2.5 text-sm">
            <input name="password" type="password" placeholder="{{ __('common.password') }}" required class="border border-line rounded-md px-3 py-2.5 text-sm">
            <input name="password_confirmation" type="password" placeholder="{{ __('common.confirm_password') }}" required class="border border-line rounded-md px-3 py-2.5 text-sm">
            <button class="bg-ink text-white rounded-md py-2.5 text-sm font-semibold">{{ __('site.create_account') }}</button>
        </form>

        <div class="text-center text-sm text-textmute mt-5">{{ __('site.have_account') }} <a href="{{ route('login') }}" class="text-brass font-semibold">{{ __('common.log_in') }}</a></div>
        <div class="text-center text-sm text-textmute mt-2">{{ __('site.own_business') }} <a href="{{ route('register.provider') }}" class="text-brass font-semibold">{{ __('site.register_as_provider') }}</a></div>
    </div>
</x-site-layout>
