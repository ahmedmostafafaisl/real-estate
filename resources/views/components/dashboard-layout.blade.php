@props([
    'navGroups' => [],
    'title' => 'Dashboard',
    'subtitle' => 'Keystone Console',
    'searchAction' => '#',
    'searchPlaceholder' => null,
])
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $title }} — Keystone</title>

<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500;600&family=Cairo:wght@500;600;700&family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">

<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          ink: '#161B22', inksoft: '#232B36', canvas: '#EEF1EF',
          line: '#DDE2DF', linesoft: '#E8ECE9',
          ktext: '#1B2127', textmute: '#5B6472', textfaint: '#8A929C',
          brass: '#B8862E', brasssoft: '#F2E7D2',
          teal: '#1D6F64', tealsoft: '#DCEEEA',
          ksuccess: '#2E8B57', successsoft: '#DEEFE3',
          kwarning: '#C97A2E', warningsoft: '#F6E6D4',
          kdanger: '#B23A48', dangersoft: '#F5DEE0',
          kslate: '#6B7280', slatesoft: '#E7E9EC',
        },
        fontFamily: {
          serif: ['Fraunces', 'serif'],
          sans: ['Inter', 'sans-serif'],
          mono: ['IBM Plex Mono', 'monospace'],
        },
      },
    },
  }
</script>
<style>
  [x-cloak] { display: none !important; }
  ::-webkit-scrollbar { height: 8px; width: 8px; }
  ::-webkit-scrollbar-thumb { background: #DDE2DF; border-radius: 8px; }
  /* Headers were hardcoded to physical text-left, which doesn't flip with dir="rtl",
     while data cells use the browser's default logical "start" alignment (which does
     flip correctly). That mismatch is what makes header labels drift away from their
     column. Forcing both to the same logical alignment guarantees they always match,
     in either language, on every table across the app. */
  table th, table td { text-align: start !important; }
  @if (app()->getLocale() === 'ar')
    body { font-family: 'IBM Plex Sans Arabic', 'Inter', sans-serif; }
    .font-serif { font-family: 'Cairo', 'Fraunces', serif; }
    .font-mono { font-family: 'IBM Plex Sans Arabic', 'IBM Plex Mono', monospace; }
  @endif
</style>
</head>
<body class="bg-canvas text-ktext font-sans antialiased" x-data="{ sidebarCollapsed: false }">

<div class="flex min-h-screen">
  <aside :class="sidebarCollapsed ? 'w-[68px]' : 'w-[240px]'" class="bg-ink flex-shrink-0 flex flex-col sticky top-0 h-screen overflow-y-auto transition-all duration-150">
    <div class="flex items-center gap-2.5 px-[18px] py-5 border-b border-inksoft">
      <svg width="26" height="26" viewBox="0 0 40 40" fill="none">
        <path d="M6 34V20C6 11.16 12.16 5 20 5C27.84 5 34 11.16 34 20V34" stroke="#B8862E" stroke-width="4.2" stroke-linecap="round" fill="none"/>
        <path d="M20 5V15" stroke="#B8862E" stroke-width="4.2" stroke-linecap="round"/>
      </svg>
      <span x-show="!sidebarCollapsed" x-cloak class="font-serif text-lg text-white tracking-wide">Keystone</span>
    </div>

    @isset($accountBadge)
      <div x-show="!sidebarCollapsed" x-cloak class="px-[18px] py-3 border-b border-inksoft flex items-center gap-2">
        {{ $accountBadge }}
      </div>
    @endisset

    <nav class="p-2.5 flex-1">
      @foreach ($navGroups as $group => $items)
        <div class="mb-3.5">
          <div x-show="!sidebarCollapsed" x-cloak class="text-[10.5px] uppercase tracking-wide text-[#7C8695] px-2.5 mb-1.5 font-semibold">{{ $group }}</div>
          @foreach ($items as $item)
            <a href="{{ $item['url'] }}"
               class="flex items-center gap-2.5 px-2.5 py-2 rounded-md mb-0.5 text-[13px] font-medium
                      {{ request()->routeIs($item['route']) ? 'bg-brass text-[#1B1200] font-semibold' : 'text-[#C7CDD6] hover:bg-inksoft' }}">
              <span class="w-4 flex-shrink-0">{!! $item['icon'] !!}</span>
              <span x-show="!sidebarCollapsed" x-cloak>{{ $item['label'] }}</span>
            </a>
          @endforeach
        </div>
      @endforeach
    </nav>
  </aside>

  <div class="flex-1 min-w-0">
    <div class="sticky top-0 z-10 bg-canvas flex items-center justify-between px-6 py-4 border-b border-line">
      <div class="flex items-center gap-3">
        <button @click="sidebarCollapsed = !sidebarCollapsed" class="border border-line bg-white rounded-md w-8 h-8 flex items-center justify-center">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#5B6472" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
        <div>
          <div class="font-serif text-xl">{{ $title }}</div>
          <div class="text-xs text-textfaint">{{ $subtitle }}</div>
        </div>
      </div>
      <div class="flex items-center gap-2.5">
        <div class="flex items-center text-[11px] font-semibold border border-line rounded-full overflow-hidden">
          <a href="{{ route('lang.switch', 'ar') }}" class="px-2 py-1 {{ app()->getLocale() === 'ar' ? 'bg-ink text-white' : 'text-textmute bg-white' }}">AR</a>
          <a href="{{ route('lang.switch', 'en') }}" class="px-2 py-1 {{ app()->getLocale() === 'en' ? 'bg-ink text-white' : 'text-textmute bg-white' }}">EN</a>
        </div>
        <form action="{{ $searchAction }}" method="GET" class="flex items-center gap-1.5 bg-white border border-line rounded-md px-3 py-1.5 w-[220px]">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8A929C" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input name="q" value="{{ request('q') }}" placeholder="{{ $searchPlaceholder ?? __('common.search') }}" class="text-xs text-ktext placeholder:text-textfaint outline-none bg-transparent flex-1">
        </form>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="border border-line bg-white rounded-md px-3 py-1.5 text-xs font-semibold text-textmute">{{ __('common.log_out') }}</button>
        </form>
      </div>
    </div>

    <div class="p-6">
      @if (session('status'))
        <div class="mb-4 bg-successsoft text-ksuccess text-sm font-medium rounded-md px-4 py-2.5">{{ session('status') }}</div>
      @endif
      {{ $slot }}
    </div>
  </div>
</div>

</body>
</html>
