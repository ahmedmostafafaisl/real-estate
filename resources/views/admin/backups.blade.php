<x-admin-layout :title="__('admin.backup_management_title')">
    <x-panel :title="__('admin.backups')">
        <x-slot:action>
            <span class="text-xs text-textfaint">{{ __('admin.configure_via') }} <code class="font-mono">spatie/laravel-backup</code></span>
        </x-slot:action>
        @if (empty($files) || count($files) === 0)
            <div class="text-center py-10 text-textfaint text-sm">
                {{ __('admin.no_backups_found') }}<br>
                <code class="font-mono text-xs">composer require spatie/laravel-backup</code> {{ __('admin.then_run') }} <code class="font-mono text-xs">php artisan backup:run</code>.
            </div>
        @else
            <table class="w-full text-sm"><thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2">{{ __('admin.file_col') }}</th><th class="pb-2 text-right">{{ __('admin.size_col') }}</th><th class="pb-2">{{ __('admin.created_col') }}</th></tr></thead><tbody>
                @foreach ($files as $f)
                    <tr class="border-t border-linesoft"><td class="py-2.5 font-mono text-xs">{{ $f['name'] }}</td><td class="py-2.5 text-right">{{ $f['size'] }}</td><td class="py-2.5">{{ $f['date']->format('M j, Y g:ia') }}</td></tr>
                @endforeach
            </tbody></table>
        @endif
    </x-panel>
</x-admin-layout>
