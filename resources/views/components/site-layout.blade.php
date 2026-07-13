@props(['title' => null])
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $title ?? __('site.meta_title_home') }}</title>

<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500;600&family=Cairo:wght@500;600;700&family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">

<script>
  tailwind.config = {
    theme: { extend: {
      colors: {
        ink: '#161B22', inksoft: '#232B36', paper: '#F8F7F3', canvas: '#EEF1EF',
        line: '#E3E1D9', linesoft: '#EDEBE3',
        ktext: '#1B2127', textmute: '#5B6472', textfaint: '#8A929C',
        brass: '#B8862E', brasssoft: '#F2E7D2',
        teal: '#1D6F64', tealsoft: '#DCEEEA',
        ksuccess: '#2E8B57', successsoft: '#DEEFE3',
        kwarning: '#C97A2E', warningsoft: '#F6E6D4',
        kdanger: '#B23A48', dangersoft: '#F5DEE0',
        kslate: '#6B7280', slatesoft: '#E7E9EC',
      },
      fontFamily: { serif: ['Fraunces','serif'], sans: ['Inter','sans-serif'], mono: ['IBM Plex Mono','monospace'] },
    }}
  }
</script>
<style>
  [x-cloak]{display:none!important}
  @if (app()->getLocale() === 'ar')
    body { font-family: 'IBM Plex Sans Arabic', 'Inter', sans-serif; }
    .font-serif { font-family: 'Cairo', 'Fraunces', serif; }
    .font-mono { font-family: 'IBM Plex Sans Arabic', 'IBM Plex Mono', monospace; }
  @endif
</style>
</head>
<body class="bg-paper text-ktext font-sans antialiased" x-data="{ mobileNav: false }">

<header class="border-b border-line bg-paper sticky top-0 z-20">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <svg width="26" height="26" viewBox="0 0 40 40" fill="none">
                <path d="M6 34V20C6 11.16 12.16 5 20 5C27.84 5 34 11.16 34 20V34" stroke="#B8862E" stroke-width="4.2" stroke-linecap="round" fill="none"/>
                <path d="M20 5V15" stroke="#B8862E" stroke-width="4.2" stroke-linecap="round"/>
            </svg>
            <span class="font-serif text-xl">Keystone</span>
        </a>

        <nav class="hidden md:flex items-center gap-7 text-sm font-medium text-textmute">
            <a href="{{ route('properties.index') }}" class="hover:text-ktext">{{ __('nav.properties') }}</a>
            <a href="{{ route('cities.index') }}" class="hover:text-ktext">{{ __('nav.cities') }}</a>
            <a href="{{ route('categories.index') }}" class="hover:text-ktext">{{ __('nav.categories') }}</a>
            <a href="{{ route('providers.index') }}" class="hover:text-ktext">{{ __('nav.providers') }}</a>
            <a href="{{ route('packages.index') }}" class="hover:text-ktext">{{ __('nav.pricing') }}</a>
        </nav>

        <div class="hidden md:flex items-center gap-3">
            <div class="flex items-center text-xs font-semibold border border-line rounded-full overflow-hidden">
                <a href="{{ route('lang.switch', 'ar') }}" class="px-2.5 py-1.5 {{ app()->getLocale() === 'ar' ? 'bg-ink text-white' : 'text-textmute' }}">AR</a>
                <a href="{{ route('lang.switch', 'en') }}" class="px-2.5 py-1.5 {{ app()->getLocale() === 'en' ? 'bg-ink text-white' : 'text-textmute' }}">EN</a>
            </div>
            @auth
                @if (auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-textmute">{{ __('nav.admin_console') }}</a>
                @elseif (auth()->user()->hasRole('service_provider'))
                    <a href="{{ route('provider.dashboard') }}" class="text-sm font-semibold text-textmute">{{ __('nav.provider_console') }}</a>
                @endif
                <form action="{{ route('logout') }}" method="POST">@csrf<button class="border border-line rounded-md px-3.5 py-2 text-sm font-semibold">{{ __('common.log_out') }}</button></form>
            @else
                <a href="{{ route('login') }}" class="text-sm font-semibold text-textmute">{{ __('common.log_in') }}</a>
                <a href="{{ route('register') }}" class="bg-ink text-white rounded-md px-4 py-2 text-sm font-semibold">{{ __('common.register') }}</a>
            @endauth
        </div>

        <button @click="mobileNav = !mobileNav" class="md:hidden">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
    </div>
    <div x-show="mobileNav" x-cloak class="md:hidden border-t border-line px-6 py-4 flex flex-col gap-3 text-sm font-medium">
        <a href="{{ route('properties.index') }}">{{ __('nav.properties') }}</a>
        <a href="{{ route('cities.index') }}">{{ __('nav.cities') }}</a>
        <a href="{{ route('categories.index') }}">{{ __('nav.categories') }}</a>
        <a href="{{ route('providers.index') }}">{{ __('nav.providers') }}</a>
        <a href="{{ route('packages.index') }}">{{ __('nav.pricing') }}</a>
        <div class="flex items-center gap-2 text-xs font-semibold pt-1">
            <a href="{{ route('lang.switch', 'ar') }}" class="{{ app()->getLocale() === 'ar' ? 'text-brass' : 'text-textmute' }}">العربية</a>
            <span class="text-textfaint">/</span>
            <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() === 'en' ? 'text-brass' : 'text-textmute' }}">English</a>
        </div>
        @auth
            <form action="{{ route('logout') }}" method="POST">@csrf<button class="text-left">{{ __('common.log_out') }}</button></form>
        @else
            <a href="{{ route('login') }}">{{ __('common.log_in') }}</a>
            <a href="{{ route('register') }}">{{ __('common.register') }}</a>
        @endauth
    </div>
</header>

<main>
    @if (session('status'))
        <div class="max-w-6xl mx-auto px-6 pt-4"><div class="bg-successsoft text-ksuccess text-sm font-medium rounded-md px-4 py-2.5">{{ session('status') }}</div></div>
    @endif
    {{ $slot }}
</main>

<footer class="border-t border-line bg-white mt-16">
    <div class="max-w-6xl mx-auto px-6 py-12 grid grid-cols-4 gap-8">
        <div>
            <div class="flex items-center gap-2 mb-3">
                <svg width="22" height="22" viewBox="0 0 40 40" fill="none"><path d="M6 34V20C6 11.16 12.16 5 20 5C27.84 5 34 11.16 34 20V34" stroke="#B8862E" stroke-width="4.2" stroke-linecap="round" fill="none"/><path d="M20 5V15" stroke="#B8862E" stroke-width="4.2" stroke-linecap="round"/></svg>
                <span class="font-serif text-lg">Keystone</span>
            </div>
            <p class="text-sm text-textmute">{{ __('nav.tagline') }}</p>
        </div>
        <div>
            <div class="text-xs font-semibold uppercase text-textfaint mb-3">{{ __('nav.explore') }}</div>
            <div class="flex flex-col gap-2 text-sm text-textmute">
                <a href="{{ route('properties.index') }}" class="hover:text-ktext">{{ __('nav.properties') }}</a>
                <a href="{{ route('cities.index') }}" class="hover:text-ktext">{{ __('nav.cities') }}</a>
                <a href="{{ route('categories.index') }}" class="hover:text-ktext">{{ __('nav.categories') }}</a>
                <a href="{{ route('providers.index') }}" class="hover:text-ktext">{{ __('nav.providers') }}</a>
            </div>
        </div>
        <div>
            <div class="text-xs font-semibold uppercase text-textfaint mb-3">{{ __('nav.company') }}</div>
            <div class="flex flex-col gap-2 text-sm text-textmute">
                <a href="{{ route('about') }}" class="hover:text-ktext">{{ __('nav.about') }}</a>
                <a href="{{ route('contact') }}" class="hover:text-ktext">{{ __('nav.contact') }}</a>
                <a href="{{ route('packages.index') }}" class="hover:text-ktext">{{ __('nav.pricing') }}</a>
            </div>
        </div>
        <div>
            <div class="text-xs font-semibold uppercase text-textfaint mb-3">{{ __('nav.legal') }}</div>
            <div class="flex flex-col gap-2 text-sm text-textmute">
                <a href="{{ route('faq') }}" class="hover:text-ktext">{{ __('nav.faq') }}</a>
                <a href="{{ route('privacy') }}" class="hover:text-ktext">{{ __('nav.privacy') }}</a>
                <a href="{{ route('terms') }}" class="hover:text-ktext">{{ __('nav.terms') }}</a>
            </div>
        </div>
    </div>
    <div class="border-t border-line text-center text-xs text-textfaint py-4">© {{ date('Y') }} Keystone. {{ __('common.rights_reserved') }}</div>
</footer>
</body>
</html>
