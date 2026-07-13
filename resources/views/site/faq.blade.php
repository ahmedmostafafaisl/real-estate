<x-site-layout :title="__('site.faq_title')">
    <div class="max-w-3xl mx-auto px-6 py-14" x-data="{ open: null }">
        <h1 class="font-serif text-3xl mb-8">{{ __('site.faq_title') }}</h1>
        <div class="flex flex-col gap-2">
            @foreach ($faqs as $i => $f)
                <div class="bg-white border border-line rounded-xl">
                    <button @click="open = open === {{ $i }} ? null : {{ $i }}" class="w-full text-left px-5 py-4 flex justify-between items-center font-semibold text-sm">
                        {{ $f->question }}
                        <span x-text="open === {{ $i }} ? '−' : '+'" class="text-textfaint"></span>
                    </button>
                    <div x-show="open === {{ $i }}" x-cloak class="px-5 pb-4 text-sm text-textmute">{{ $f->answer }}</div>
                </div>
            @endforeach
        </div>
    </div>
</x-site-layout>
