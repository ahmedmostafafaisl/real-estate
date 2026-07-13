<x-admin-layout title="CMS pages">
    <div class="flex flex-col gap-3.5" x-data="{ editing: null }">
        <x-panel title="Pages">
            <x-slot:action>
                <button @click="editing = 'new'" class="bg-ink text-white text-xs font-semibold rounded-md px-3.5 py-2">+ New page</button>
            </x-slot:action>
            <table class="w-full text-sm"><thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2">Title</th><th class="pb-2">Slug</th><th class="pb-2">Status</th></tr></thead><tbody>
                @foreach ($pages as $p)
                    <tr class="border-t border-linesoft cursor-pointer" @click="editing = {{ $p->id }}">
                        <td class="py-2.5 font-semibold">{{ $p->title }}</td><td class="py-2.5 font-mono text-xs">/{{ $p->slug }}</td><td class="py-2.5"><x-badge :status="ucfirst($p->status)" /></td>
                    </tr>
                @endforeach
            </tbody></table>
        </x-panel>

        <div x-show="editing === 'new'" x-cloak>
            <x-panel title="New page">
                <form action="{{ route('admin.cms.pages.store') }}" method="POST" class="flex flex-col gap-3">
                    @csrf
                    <input name="title" placeholder="Title" required class="border border-line rounded-md px-2.5 py-2 text-sm">
                    <textarea name="content" rows="4" placeholder="Content" class="border border-line rounded-md px-2.5 py-2 text-sm"></textarea>
                    <select name="status" class="border border-line rounded-md px-2.5 py-2 text-sm w-40"><option value="draft">Draft</option><option value="published">Published</option></select>
                    <div><button class="bg-ink text-white rounded-md px-3.5 py-2 text-xs font-semibold">Create page</button></div>
                </form>
            </x-panel>
        </div>

        @foreach ($pages as $p)
            <div x-show="editing === {{ $p->id }}" x-cloak>
                <x-panel :title="'Edit — '.$p->title">
                    <form action="{{ route('admin.cms.pages.update', $p) }}" method="POST" class="flex flex-col gap-3">
                        @csrf @method('PATCH')
                        <input name="title" value="{{ $p->title }}" class="border border-line rounded-md px-2.5 py-2 text-sm">
                        <textarea name="content" rows="5" class="border border-line rounded-md px-2.5 py-2 text-sm">{{ $p->content }}</textarea>
                        <select name="status" class="border border-line rounded-md px-2.5 py-2 text-sm w-40">
                            <option value="draft" @selected($p->status==='draft')>Draft</option><option value="published" @selected($p->status==='published')>Published</option>
                        </select>
                        <div><button class="bg-ink text-white rounded-md px-3.5 py-2 text-xs font-semibold">Save</button></div>
                    </form>
                </x-panel>
            </div>
        @endforeach

        <x-panel title="FAQ">
            <x-slot:action>
                <form action="{{ route('admin.cms.faqs.store') }}" method="POST" class="flex gap-1.5">@csrf
                    <input name="question" placeholder="Question" required class="border border-line rounded-md px-2.5 py-1.5 text-xs w-56">
                    <input name="answer" placeholder="Answer" required class="border border-line rounded-md px-2.5 py-1.5 text-xs w-56">
                    <button class="bg-ink text-white rounded-md px-3 py-1.5 text-xs font-semibold">Add</button>
                </form>
            </x-slot:action>
            <div class="flex flex-col gap-2">
                @foreach ($faqs as $f)
                    <div class="border-t border-linesoft pt-2"><div class="font-semibold text-sm">{{ $f->question }}</div><div class="text-sm text-textmute">{{ $f->answer }}</div></div>
                @endforeach
            </div>
        </x-panel>
    </div>
</x-admin-layout>
