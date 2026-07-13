<x-admin-layout title="Roles & permissions">
    <div class="grid grid-cols-[260px_1fr] gap-3.5" x-data="{ active: '{{ $roles->first()->name ?? '' }}' }">
        <x-panel title="Roles">
            <x-slot:action>
                <form action="{{ route('admin.roles.store') }}" method="POST" class="flex gap-1">@csrf
                    <input name="name" placeholder="New role" class="border border-line rounded-md px-2 py-1 text-xs w-[90px]">
                    <button class="bg-ink text-white rounded-md px-2 py-1 text-xs font-semibold">+</button>
                </form>
            </x-slot:action>
            <div class="flex flex-col gap-0.5">
                @foreach ($roles as $role)
                    <button @click="active = '{{ $role->name }}'" :class="active === '{{ $role->name }}' ? 'bg-brasssoft text-brass' : ''" class="flex justify-between items-center text-left px-2.5 py-2 rounded-md text-sm font-medium">
                        {{ $role->name }} <span class="text-[11px] text-textfaint">{{ $role->users_count }} users</span>
                    </button>
                @endforeach
            </div>
        </x-panel>
        <x-panel title="Permissions">
            @foreach ($roles as $role)
                <div x-show="active === '{{ $role->name }}'" x-cloak>
                    <form action="{{ route('admin.roles.permissions', $role) }}" method="POST" class="flex flex-col gap-4">
                        @csrf
                        @php $rolePerms = $role->permissions->pluck('name')->toArray(); @endphp
                        @php $groups = $permissions->groupBy(fn($p) => explode('.', $p->name)[0]); @endphp
                        @foreach ($groups as $group => $perms)
                            <div>
                                <div class="text-xs font-semibold mb-2">{{ ucfirst($group) }}</div>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($perms as $perm)
                                        <label class="relative flex items-center gap-1.5 text-[12.5px] border rounded-full px-3 py-1.5 cursor-pointer border-line text-textmute has-[:checked]:bg-brasssoft has-[:checked]:border-brass has-[:checked]:text-brass">
                                            <input type="checkbox" name="permissions[]" value="{{ $perm->name }}" @checked(in_array($perm->name, $rolePerms)) class="hidden">
                                            {{ Str::after($perm->name, '.') }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        <div><button class="bg-ink text-white rounded-md px-3.5 py-2 text-xs font-semibold">Save changes</button></div>
                    </form>
                </div>
            @endforeach
        </x-panel>
    </div>
</x-admin-layout>
