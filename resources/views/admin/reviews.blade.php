<x-admin-layout :title="__('admin.reviews_reports_title')">
    <div class="flex flex-col gap-3.5">
        <x-panel :title="__('admin.customer_reviews')">
            <table class="w-full text-sm"><thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2">{{ __('admin.property_col') }}</th><th class="pb-2">{{ __('admin.customer_col') }}</th><th class="pb-2">{{ __('admin.rating_col') }}</th><th class="pb-2">{{ __('admin.comment_col') }}</th><th class="pb-2">{{ __('common.status') }}</th><th class="pb-2"></th></tr></thead><tbody>
                @forelse ($reviews as $r)
                    <tr class="border-t border-linesoft">
                        <td class="py-2.5">{{ $r->property->title }}</td><td class="py-2.5">{{ $r->user->name }}</td>
                        <td class="py-2.5">{{ str_repeat('★', $r->rating) }}{{ str_repeat('☆', 5 - $r->rating) }}</td>
                        <td class="py-2.5 text-textmute">{{ $r->comment }}</td><td class="py-2.5"><x-badge :status="ucfirst($r->status)" /></td>
                        <td class="py-2.5 text-right whitespace-nowrap">
                            @if ($r->status === 'pending')
                            <form action="{{ route('admin.reviews.moderate', $r) }}" method="POST" class="inline">@csrf<input type="hidden" name="status" value="published"><button class="text-ksuccess text-xs font-semibold ms-2">{{ __('admin.publish') }}</button></form>
                            <form action="{{ route('admin.reviews.moderate', $r) }}" method="POST" class="inline">@csrf<input type="hidden" name="status" value="rejected"><button class="text-kdanger text-xs font-semibold">{{ __('admin.reject') }}</button></form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="py-6 text-center text-textfaint">{{ __('admin.no_reviews_yet') }}</td></tr>
                @endforelse
            </tbody></table>
        </x-panel>
        <x-panel :title="__('admin.reported_listings')">
            <x-slot:action><x-badge status="Pending" /></x-slot:action>
            <table class="w-full text-sm"><thead><tr class="text-[11px] uppercase text-textfaint text-left"><th class="pb-2">{{ __('admin.property_col') }}</th><th class="pb-2">{{ __('admin.reason_col') }}</th><th class="pb-2">{{ __('admin.reported_by_col') }}</th><th class="pb-2">{{ __('common.status') }}</th><th class="pb-2"></th></tr></thead><tbody>
                @forelse ($reports as $r)
                    <tr class="border-t border-linesoft">
                        <td class="py-2.5">{{ $r->property->title }}</td><td class="py-2.5">{{ $r->reason }}</td><td class="py-2.5">{{ $r->user->name }}</td>
                        <td class="py-2.5"><x-badge :status="ucfirst($r->status)" /></td>
                        <td class="py-2.5 text-right">
                            @if ($r->status === 'open')
                            <form action="{{ route('admin.reports.resolve', $r) }}" method="POST">@csrf<button class="text-ksuccess text-xs font-semibold">{{ __('admin.resolve') }}</button></form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-6 text-center text-textfaint">{{ __('admin.no_reports_yet') }}</td></tr>
                @endforelse
            </tbody></table>
        </x-panel>
    </div>
</x-admin-layout>
