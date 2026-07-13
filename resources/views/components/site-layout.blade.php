@props(['title' => 'Keystone — Find your next property'])
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $title }}</title>

<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500;600&display=swap" rel="stylesheet">

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
<style>[x-cloak]{display:none!important}</style>
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
            <a href="{{ route('properties.index') }}" class="hover:text-ktext">Properties</a>
            <a href="{{ route('cities.index') }}" class="hover:text-ktext">Cities</a>
            <a href="{{ route('categories.index') }}" class="hover:text-ktext">Categories</a>
            <a href="{{ route('providers.index') }}" class="hover:text-ktext">Service Providers</a>
            <a href="{{ route('packages.index') }}" class="hover:text-ktext">Pricing</a>
        </nav>

        <div class="hidden md:flex items-center gap-3">
            @auth
                @if (auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-textmute">Admin console</a>
                @elseif (auth()->user()->hasRole('service_provider'))
                    <a href="{{ route('provider.dashboard') }}" class="text-sm font-semibold text-textmute">Provider console</a>
                @endif
                <form action="{{ route('logout') }}" method="POST">@csrf<button class="border border-line rounded-md px-3.5 py-2 text-sm font-semibold">Log out</button></form>
            @else
                <a href="{{ route('login') }}" class="text-sm font-semibold text-textmute">Log in</a>
                <a href="{{ route('register') }}" class="bg-ink text-white rounded-md px-4 py-2 text-sm font-semibold">Register</a>
            @endauth
        </div>

        <button @click="mobileNav = !mobileNav" class="md:hidden">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
    </div>
    <div x-show="mobileNav" x-cloak class="md:hidden border-t border-line px-6 py-4 flex flex-col gap-3 text-sm font-medium">
        <a href="{{ route('properties.index') }}">Properties</a>
        <a href="{{ route('cities.index') }}">Cities</a>
        <a href="{{ route('categories.index') }}">Categories</a>
        <a href="{{ route('providers.index') }}">Service Providers</a>
        <a href="{{ route('packages.index') }}">Pricing</a>
        @auth
            <form action="{{ route('logout') }}" method="POST">@csrf<button class="text-left">Log out</button></form>
        @else
            <a href="{{ route('login') }}">Log in</a>
            <a href="{{ route('register') }}">Register</a>
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
            <p class="text-sm text-textmute">Connecting property seekers with verified agencies, brokers, owners, and developers.</p>
        </div>
        <div>
            <div class="text-xs font-semibold uppercase text-textfaint mb-3">Explore</div>
            <div class="flex flex-col gap-2 text-sm text-textmute">
                <a href="{{ route('properties.index') }}" class="hover:text-ktext">Properties</a>
                <a href="{{ route('cities.index') }}" class="hover:text-ktext">Cities</a>
                <a href="{{ route('categories.index') }}" class="hover:text-ktext">Categories</a>
                <a href="{{ route('providers.index') }}" class="hover:text-ktext">Service providers</a>
            </div>
        </div>
        <div>
            <div class="text-xs font-semibold uppercase text-textfaint mb-3">Company</div>
            <div class="flex flex-col gap-2 text-sm text-textmute">
                <a href="{{ route('about') }}" class="hover:text-ktext">About us</a>
                <a href="{{ route('contact') }}" class="hover:text-ktext">Contact us</a>
                <a href="{{ route('packages.index') }}" class="hover:text-ktext">Pricing</a>
            </div>
        </div>
        <div>
            <div class="text-xs font-semibold uppercase text-textfaint mb-3">Legal</div>
            <div class="flex flex-col gap-2 text-sm text-textmute">
                <a href="{{ route('faq') }}" class="hover:text-ktext">FAQ</a>
                <a href="{{ route('privacy') }}" class="hover:text-ktext">Privacy policy</a>
                <a href="{{ route('terms') }}" class="hover:text-ktext">Terms &amp; conditions</a>
            </div>
        </div>
    </div>
    <div class="border-t border-line text-center text-xs text-textfaint py-4">© {{ date('Y') }} Keystone. All rights reserved.</div>
</footer>
</body>
</html>
