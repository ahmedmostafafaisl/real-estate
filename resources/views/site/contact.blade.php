<x-site-layout :title="__('site.contact_title')">
    <div class="max-w-3xl mx-auto px-6 py-14">
        <h1 class="font-serif text-3xl mb-4">{{ __('site.contact_title') }}</h1>
        <p class="text-textmute mb-8">{{ $page->content ?? __('site.contact_subtitle') }}</p>

        <form action="{{ route('contact.submit') }}" method="POST" class="bg-white border border-line rounded-xl p-6 flex flex-col gap-3.5">
            @csrf
            <div class="grid grid-cols-2 gap-3.5">
                <input name="name" placeholder="{{ __('site.your_name') }}" required class="border border-line rounded-md px-3 py-2.5 text-sm">
                <input name="email" type="email" placeholder="{{ __('site.your_email') }}" required class="border border-line rounded-md px-3 py-2.5 text-sm">
            </div>
            <input name="subject" placeholder="{{ __('site.subject_optional') }}" class="border border-line rounded-md px-3 py-2.5 text-sm">
            <textarea name="message" rows="5" placeholder="{{ __('site.your_message') }}" required class="border border-line rounded-md px-3 py-2.5 text-sm"></textarea>
            <button class="bg-ink text-white rounded-md py-2.5 text-sm font-semibold self-start px-6">{{ __('site.send_message') }}</button>
        </form>
    </div>
</x-site-layout>
