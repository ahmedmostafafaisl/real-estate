<x-site-layout :title="$title.' — Keystone'">
    <div class="max-w-3xl mx-auto px-6 py-14">
        <h1 class="font-serif text-3xl mb-6">{{ $title }}</h1>
        <div class="text-textmute leading-relaxed whitespace-pre-line">
            {{ $page->content ?? 'This page has not been published yet.' }}
        </div>
    </div>
</x-site-layout>
