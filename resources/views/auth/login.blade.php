<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ __('auth.sign_in_title') }}</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500&family=Inter:wght@400;500;600&family=Cairo:wght@500;600&family=IBM+Plex+Sans+Arabic:wght@400;500;600&display=swap" rel="stylesheet">
<style>
    body{font-family:Inter,sans-serif}
    @if (app()->getLocale() === 'ar')
        body{font-family:'IBM Plex Sans Arabic',Inter,sans-serif}
        .font-serif{font-family:'Cairo',serif}
    @endif
</style>
</head>
<body class="bg-[#EEF1EF] min-h-screen flex items-center justify-center">
<div class="w-[380px] bg-white border border-[#DDE2DF] rounded-xl p-8">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-2.5">
            <svg width="26" height="26" viewBox="0 0 40 40" fill="none">
                <path d="M6 34V20C6 11.16 12.16 5 20 5C27.84 5 34 11.16 34 20V34" stroke="#B8862E" stroke-width="4.2" stroke-linecap="round" fill="none"/>
                <path d="M20 5V15" stroke="#B8862E" stroke-width="4.2" stroke-linecap="round"/>
            </svg>
            <span class="font-serif text-lg">Keystone</span>
        </div>
        <div class="flex items-center text-xs font-semibold border border-[#DDE2DF] rounded-full overflow-hidden">
            <a href="{{ route('lang.switch', 'ar') }}" class="px-2.5 py-1.5 {{ app()->getLocale() === 'ar' ? 'bg-[#161B22] text-white' : 'text-[#5B6472]' }}">AR</a>
            <a href="{{ route('lang.switch', 'en') }}" class="px-2.5 py-1.5 {{ app()->getLocale() === 'en' ? 'bg-[#161B22] text-white' : 'text-[#5B6472]' }}">EN</a>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-[#F5DEE0] text-[#B23A48] text-sm rounded-md px-3 py-2 mb-4">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('login.store') }}" method="POST" class="flex flex-col gap-3.5">
        @csrf
        <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-[#5B6472]">{{ __('common.email') }}</span>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus class="border border-[#DDE2DF] rounded-md px-3 py-2 text-sm"></label>
        <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-[#5B6472]">{{ __('common.password') }}</span>
            <input type="password" name="password" required class="border border-[#DDE2DF] rounded-md px-3 py-2 text-sm"></label>
        <label class="flex items-center gap-2 text-xs text-[#5B6472]"><input type="checkbox" name="remember"> {{ __('auth.remember_me') }}</label>
        <button class="bg-[#161B22] text-white rounded-md py-2.5 text-sm font-semibold mt-1">{{ __('auth.sign_in') }}</button>
    </form>
</div>
</body>
</html>
