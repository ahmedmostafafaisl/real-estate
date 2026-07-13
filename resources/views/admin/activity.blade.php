<x-admin-layout :title="__('admin.activity_logs_title')">
    <x-panel :title="__('admin.activity_logs_title')">
        @if ($logs->isEmpty())
            <div class="text-center py-10 text-textfaint text-sm">
                {{ __('admin.no_activity_yet') }}<br>
                <code class="font-mono text-xs">php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider"</code>
            </div>
        @else
            <table class="w-full text-sm"><thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2">{{ __('admin.actor_col') }}</th><th class="pb-2">{{ __('admin.action_col') }}</th><th class="pb-2">{{ __('admin.time_col') }}</th></tr></thead><tbody>
                @foreach ($logs as $log)
                    <tr class="border-t border-linesoft"><td class="py-2.5">{{ $log->causer->name ?? __('admin.system') }}</td><td class="py-2.5">{{ $log->description }}</td><td class="py-2.5">{{ $log->created_at->format('M j, g:ia') }}</td></tr>
                @endforeach
            </tbody></table>
            <div class="mt-4">{{ $logs->links() }}</div>
        @endif
    </x-panel>
</x-admin-layout>
