<x-admin-layout title="Backup management">
    <x-panel title="Backups">
        <x-slot:action>
            <span class="text-xs text-textfaint">Configure and schedule via <code class="font-mono">spatie/laravel-backup</code></span>
        </x-slot:action>
        @if (empty($files) || count($files) === 0)
            <div class="text-center py-10 text-textfaint text-sm">
                No backups found. Install and configure<br>
                <code class="font-mono text-xs">composer require spatie/laravel-backup</code> then run <code class="font-mono text-xs">php artisan backup:run</code>.
            </div>
        @else
            <table class="w-full text-sm"><thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2">File</th><th class="pb-2 text-right">Size</th><th class="pb-2">Created</th></tr></thead><tbody>
                @foreach ($files as $f)
                    <tr class="border-t border-linesoft"><td class="py-2.5 font-mono text-xs">{{ $f['name'] }}</td><td class="py-2.5 text-right">{{ $f['size'] }}</td><td class="py-2.5">{{ $f['date']->format('M j, Y g:ia') }}</td></tr>
                @endforeach
            </tbody></table>
        @endif
    </x-panel>
</x-admin-layout>
