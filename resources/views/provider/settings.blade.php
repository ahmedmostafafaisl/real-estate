<x-provider-layout title="Account settings">
    <div class="flex flex-col gap-3.5">
        <x-panel title="Account">
            <form action="{{ route('provider.settings.update') }}" method="POST" class="grid grid-cols-2 gap-3.5">
                @csrf @method('PATCH')
                <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">Full name</span><input name="name" value="{{ $user->name }}" class="border border-line rounded-md px-2.5 py-2 text-sm"></label>
                <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">Email</span><input name="email" value="{{ $user->email }}" class="border border-line rounded-md px-2.5 py-2 text-sm"></label>
                <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">Phone</span><input name="phone" value="{{ $user->phone }}" class="border border-line rounded-md px-2.5 py-2 text-sm"></label>
                <div class="col-span-2 flex justify-end"><button class="bg-ink text-white rounded-md px-3.5 py-2 text-xs font-semibold">Save changes</button></div>
            </form>
        </x-panel>
        <x-panel title="Password">
            <form action="{{ route('provider.settings.password') }}" method="POST" class="grid grid-cols-2 gap-3.5 max-w-[460px]">
                @csrf @method('PATCH')
                <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">New password</span><input type="password" name="password" class="border border-line rounded-md px-2.5 py-2 text-sm"></label>
                <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-textmute">Confirm password</span><input type="password" name="password_confirmation" class="border border-line rounded-md px-2.5 py-2 text-sm"></label>
                <div class="col-span-2 flex justify-end"><button class="bg-ink text-white rounded-md px-3.5 py-2 text-xs font-semibold">Update password</button></div>
            </form>
        </x-panel>
    </div>
</x-provider-layout>
