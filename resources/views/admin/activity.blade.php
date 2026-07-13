<x-admin-layout title="Activity logs">
    <x-panel title="Activity logs">
        @if ($logs->isEmpty())
            <div class="text-center py-10 text-textfaint text-sm">
                No activity recorded yet. Enable logging by running<br>
                <code class="font-mono text-xs">php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider"</code> and migrating.
            </div>
        @else
            <table class="w-full text-sm"><thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2">Actor</th><th class="pb-2">Action</th><th class="pb-2">Time</th></tr></thead><tbody>
                @foreach ($logs as $log)
                    <tr class="border-t border-linesoft"><td class="py-2.5">{{ $log->causer->name ?? 'System' }}</td><td class="py-2.5">{{ $log->description }}</td><td class="py-2.5">{{ $log->created_at->format('M j, g:ia') }}</td></tr>
                @endforeach
            </tbody></table>
            <div class="mt-4">{{ $logs->links() }}</div>
        @endif
    </x-panel>
</x-admin-layout>
